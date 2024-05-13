package main

import (
	"context"
	"time"
	"log"
	"os"
	"math/big"
	"strings"
	"io/ioutil"
	_ "github.com/go-sql-driver/mysql"
	"database/sql"
	"github.com/ethereum/go-ethereum"
	"github.com/ethereum/go-ethereum/accounts/abi"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
	)

const status_cancel = 1
const status_accept = 4
const status_finish = 7
const status_cancel_pending = 10;
const status_upload_timeout_cancel_pending = 13;
const status_upload_timeout_cancel = 14;

const transaction_type_lock_assert = 0;
const transaction_type_settle = 1;
const transaction_type_delegate_settle = 2;
const transaction_type_cancel_lock = 3;

func GetLatestBlock(client *ethclient.Client) (*big.Int, error) {
	header, err := client.HeaderByNumber(context.Background(), nil)
	if err != nil {
		return nil, err
	}

	latestBlockNumber := header.Number
	return latestBlockNumber, nil
}

func GetProjectTaskApplicationStatus(db* sql.DB, index_code string) (int) {
	rows, _ := db.Query("SELECT status FROM project_task_application WHERE web3_hash = ?", index_code)
	defer rows.Close()
	var status int
	for rows.Next() {
		if err := rows.Scan(&status); err != nil {
			log.Printf("query project_task_application error: %v", err)
			return -1;
		}
	}
	log.Printf("get task status:index_code=%s  status=%d\n", index_code,  status)
	return status
}

func UpdateProjectTaskApplicationStatus(db* sql.DB, transaction_type int, index_code string) (error) {
	stmt, err := db.Prepare("UPDATE project_task_application SET status = ? where web3_hash = ?;")	
	if err != nil {
		return err
	}
	defer stmt.Close()
	var status int
	switch transaction_type {
		case transaction_type_lock_assert: 
			status = status_accept 
		case transaction_type_settle: 
			status = status_finish 
		case transaction_type_delegate_settle: 
			status = status_finish 
		case transaction_type_cancel_lock: 
			cur_status := GetProjectTaskApplicationStatus(db, index_code)
			if cur_status == status_upload_timeout_cancel_pending {
				status = status_upload_timeout_cancel 
			} else if cur_status == status_cancel_pending {
				status = status_cancel 
			} else {
				return nil
			}
	}
	_, err = stmt.Exec(status, index_code)
	if err != nil {
		return err
	}
	log.Printf("update success! index_code:%s transaction_type:%d  status:%d\n", index_code, transaction_type, status)
	return nil
}

func InsertEvent(db* sql.DB, index_code string, transaction_type int, block_number uint64, 
	from_address string, to_address string, token string, amt int64, fee int64, transaction_time uint64) (error) {
	created_time := time.Now().Unix()
	stmt, err := db.Prepare("INSERT INTO transaction (index_code, transaction_type, block_number, from_address, to_address, token, amt, fee, transaction_time, created_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)")		
	if err != nil {
		return err
	}
	defer stmt.Close()
	_, err = stmt.Exec(index_code, transaction_type, block_number, from_address, to_address, token, amt, fee, transaction_time, created_time)
	if err != nil {
		return err
	}
	log.Printf("insert success! block_number：%d \n", block_number)
	err = UpdateProjectTaskApplicationStatus(db, transaction_type, index_code)
	return err
}

func Execute(db* sql.DB, rpc_url string, contract_addr string, last_block_number int) {
	client, err := ethclient.Dial(rpc_url)
	if err != nil {
		log.Fatal(err)
	}

	latestBlockNumber, err := GetLatestBlock(client)
	if err != nil {
		log.Fatal(err)
	}
	log.Printf("Execute function called=latest_block_number:%d last_block_number:%d rpc_url:%s contract_addr:%s\n", latestBlockNumber, last_block_number, rpc_url, contract_addr)

	contractAddress := common.HexToAddress(contract_addr)
	abiData, err := ioutil.ReadFile("AssetLocker.json")
	if err != nil {
		log.Println("Failed to read ABI file:", err)
		return
	}
	contractAbi, err := abi.JSON(strings.NewReader(string(abiData)))
	if err != nil {
		log.Fatal(err)
	}

	query := ethereum.FilterQuery{
		FromBlock: big.NewInt(int64(last_block_number)),
		ToBlock:   big.NewInt(latestBlockNumber.Int64()),
		Addresses: []common.Address{
			contractAddress,
		},
	}
	logs, err := client.FilterLogs(context.Background(), query)
	if err != nil {
		log.Fatal(err)
	}

	lockAssetEventSig := []byte("LockAsset(string,address,address,address,uint256)")
	lockAssetEventSigHash := crypto.Keccak256Hash(lockAssetEventSig)
	type ContractsLockAsset struct {
		IndexCode string
		User    common.Address
		To      common.Address
		Token   common.Address
		LockAmt *big.Int
	}

	settleSig := []byte("Settle(string,address,address,uint256,uint256)")
	settleEventSigHash := crypto.Keccak256Hash(settleSig)
	type ContractsSettle struct {
		IndexCode string
		To        common.Address
		Token     common.Address
		Amt       *big.Int
		Fee       *big.Int
	}

	delegateSettleSig := []byte("DelegateSettle(string,address,address,address,uint256,uint256)")
	delegateSettleEventSigHash := crypto.Keccak256Hash(delegateSettleSig)
	type ContractsDelegateSettle struct {
		IndexCode string
		Locker    common.Address
		To        common.Address
		Token     common.Address
		Amt       *big.Int
		Fee       *big.Int
	}

	cancelLockSig := []byte("CancelLock(string,address,address,address,uint256)")
	cancelLockEventSigHash := crypto.Keccak256Hash(cancelLockSig)
	type ContractsCancelLock struct {
		IndexCode string
		Locker    common.Address
		To        common.Address
		Token     common.Address
		Amt       *big.Int
	}

	for _, vLog := range logs {
		log.Println("BlockNumber:",vLog.BlockNumber)
		block, err := client.BlockByNumber(context.Background(), new(big.Int).SetUint64(vLog.BlockNumber))
		if err != nil {
			log.Fatal(err)
		}
		log.Println("Timestamp:", time.Unix(int64(block.Time()), 0).Format("2006-01-02 15:04:05 MST"))
		switch vLog.Topics[0].Hex() {
		case lockAssetEventSigHash.Hex():
			log.Printf("Event Name: LockAsset()\n")

			var lockAssetEvent ContractsLockAsset
			err := contractAbi.UnpackIntoInterface(&lockAssetEvent, "LockAsset", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			log.Println("lockAssetEvent.IndexCode : ", lockAssetEvent.IndexCode)
			log.Println("lockAssetEvent.User : ", lockAssetEvent.User)
			log.Println("lockAssetEvent.To : ", lockAssetEvent.To)
			log.Println("lockAssetEvent.Token : ", lockAssetEvent.Token)
			log.Println("lockAssetEvent.LockAmt : ", lockAssetEvent.LockAmt)
			err = InsertEvent(db, lockAssetEvent.IndexCode, transaction_type_lock_assert, vLog.BlockNumber, lockAssetEvent.User.String(), lockAssetEvent.To.String(), lockAssetEvent.Token.String(), lockAssetEvent.LockAmt.Int64(), 0, block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case settleEventSigHash.Hex():
			log.Printf("Event Name: Settle()\n")

			var settleEvent ContractsSettle
			err := contractAbi.UnpackIntoInterface(&settleEvent, "Settle", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			log.Println("settleEvent.IndexCode : ", settleEvent.IndexCode)
			log.Println("settleEvent.To : ", settleEvent.To)
			log.Println("settleEvent.Token : ", settleEvent.Token)
			log.Println("settleEvent.Amt : ", settleEvent.Amt)
			log.Println("settleEvent.Fee : ", settleEvent.Fee)
			err = InsertEvent(db, settleEvent.IndexCode, transaction_type_settle, vLog.BlockNumber, "", settleEvent.To.String(), settleEvent.Token.String(), settleEvent.Amt.Int64(), settleEvent.Fee.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case delegateSettleEventSigHash.Hex():
			log.Printf("Event Name: DelegateSettle()\n")

			var delegateSettleEvent ContractsDelegateSettle
			err := contractAbi.UnpackIntoInterface(&delegateSettleEvent, "DelegateSettle", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			log.Println("delegateSettleEvent.IndexCode : ", delegateSettleEvent.IndexCode)
			log.Println("delegateSettleEvent.Locker : ", delegateSettleEvent.Locker)
			log.Println("delegateSettleEvent.To : ", delegateSettleEvent.To)
			log.Println("delegateSettleEvent.Token : ", delegateSettleEvent.Token)
			log.Println("delegateSettleEvent.Amt : ", delegateSettleEvent.Amt)
			log.Println("delegateSettleEvent.Fee : ", delegateSettleEvent.Fee)
			err = InsertEvent(db, delegateSettleEvent.IndexCode, transaction_type_delegate_settle, vLog.BlockNumber, 
				delegateSettleEvent.Locker.String(), delegateSettleEvent.To.String(), delegateSettleEvent.Token.String(), delegateSettleEvent.Amt.Int64(), delegateSettleEvent.Fee.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case cancelLockEventSigHash.Hex():
			log.Printf("Event Name: CancelLock()\n")

			var cancelLockEvent ContractsCancelLock
			err := contractAbi.UnpackIntoInterface(&cancelLockEvent, "CancelLock", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			log.Println("cancelLockEvent.IndexCode : ", cancelLockEvent.IndexCode)
			log.Println("cancelLockEvent.Locker : ", cancelLockEvent.Locker)
			log.Println("cancelLockEvent.To : ", cancelLockEvent.To)
			log.Println("cancelLockEvent.Token : ", cancelLockEvent.Token)
			log.Println("cancelLockEvent.Amt : ", cancelLockEvent.Amt)
			err = InsertEvent(db, cancelLockEvent.IndexCode, transaction_type_cancel_lock, vLog.BlockNumber, 
				cancelLockEvent.Locker.String(), cancelLockEvent.To.String(), cancelLockEvent.Token.String(), cancelLockEvent.Amt.Int64(), 0, block.Time());
			if err != nil {
				log.Fatal(err)
			}
		}
		log.Printf("\n\n")
	}
	sql := "UPDATE transaction_base SET last_block_number = ?"
	_, err = db.Exec(sql, latestBlockNumber.String())
	if err != nil {
		log.Fatal(err)
	}
}

func SetLogFormat() {
	currentTime := time.Now()
	date := currentTime.Format("2006-01-02") 
	fileName := "logs/transaction_log_" + date + ".txt"
	file, err := os.OpenFile(fileName, os.O_CREATE|os.O_WRONLY|os.O_APPEND, 0666)
	if err != nil {
		log.Fatal(err)
	}
	defer file.Close()

	log.SetFlags(log.Ldate | log.Ltime)
	// log.SetOutput(file)
	log.SetOutput(os.Stdout)
}

// insert into transaction_base (blockchain_id,last_block_number,rpc_url,contract_addr) values(1,38568012,"https://bsc-mainnet.nodereal.io/v1/7a5eca2f07be48d586a09275ea2f687c","0x0BDBb9EBaDBA7e4061e56E533fAb06D10e90aE96");
func main() {
	SetLogFormat()
	db, err := sql.Open("mysql", "root:F0BYKDqw7@tcp(127.0.0.1:3306)/kolink?parseTime=true&loc=Local")
	if err != nil {
		log.Fatal(err)
	}
	pingErr := db.Ping()
	if pingErr != nil {
		log.Fatal(pingErr)
	}
	rows, _ := db.Query("SELECT blockchain_id,last_block_number,rpc_url,contract_addr FROM transaction_base")
	defer rows.Close()
	var last_block_number int
	var blockchain_id int
	var rpc_url string
	var contract_addr string
	for rows.Next() {
		if err := rows.Scan(&blockchain_id,&last_block_number,&rpc_url,&contract_addr); err != nil {
			log.Printf("query transaction_base error: %v", err)
			return;
		}
		log.Printf("transaction_base=blockchain_id:%d last_block_number:%d rpc_url:%s contract_addr:%s\n", blockchain_id, last_block_number, rpc_url, contract_addr)
		Execute(db, rpc_url, contract_addr, last_block_number)
	}

	// UpdateProjectTaskApplicationStatus(db, transaction_type_cancel_lock, "web123456789")
	// UpdateProjectTaskApplicationStatus(db, transaction_type_delegate_settle, "web123456789")
}
