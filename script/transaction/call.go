package main

import (
	"contracts"
	"context"
	"time"
	"github.com/ethereum/go-ethereum/accounts/abi/bind"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
	"log"
	"os"
	"math/big"
	_ "github.com/go-sql-driver/mysql"
	"database/sql"
)

const max_transaction_try_times = 3
const transaction_type_lock_assert = 0;
const transaction_type_settle = 1;
const transaction_type_delegate_settle = 2;
const transaction_type_cancel_lock = 3;

func SettleCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, indexCode string) uint64 {
	tx, err := instance.Settle(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	if 0 == receipt.Status {
		log.Println(receipt.Logs)		
	}
	log.Println("Settle receipt.Status:", receipt.Status)
	return receipt.Status
}

func DelegateSettleCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, indexCode string) uint64 {
	log.Println("DelegateSettleCall indexCode:", indexCode)
	indexCodeSlice := []string{indexCode}
	tx, err := instance.DelegateSettle(auth, indexCodeSlice)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	if 0 == receipt.Status {
		log.Println(receipt.Logs)		
	}
	log.Println("DelegateSettleCall receipt.Status:", receipt.Status)
	return receipt.Status
}

func UpdateTransactionFlag(db* sql.DB, id int, transaction_flag int, transaction_try_times int) {
	updated_time := time.Now().Format("2006-01-02 15:04:05")
	sql := "UPDATE transaction_queue SET transaction_flag = ?,transaction_try_times = ?, updated_at = ? where id = ?"
	_, err := db.Exec(sql, transaction_flag, transaction_try_times, updated_time, id)
	if err != nil {
		log.Fatal(err)
	}
	log.Printf("update success! id:%d, transaction_flag:%d, transaction_try_times:%d", id, transaction_flag, transaction_try_times)
}

func LockAssetCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, 
	indexCode string, address_to common.Address, address_token common.Address, fee *big.Int) uint64 {
	tx, err := instance.LockAsset(auth, indexCode, address_to, address_to, fee)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	if 0 == receipt.Status {
		log.Println(receipt.Logs)		
	}
	log.Println("LockAsset receipt.Status:", receipt.Status)
	return receipt.Status
}

func CancelLockCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, indexCode string) uint64 {
	log.Println("CancelLockCall indexCode:", indexCode)
	tx, err := instance.CancelLock(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	if 0 == receipt.Status {
		log.Println(receipt)		
	}
	log.Println("CancelLockCall receipt.Status:", receipt.Status)
	return receipt.Status
}

func Execute(db* sql.DB, rpc_url string, contract_addr string, private_key string, blockchain_id int) {
	client, err := ethclient.Dial(rpc_url)
	if err != nil {
		log.Fatal(err)
	}
	header, err := client.HeaderByNumber(context.Background(), nil)
	if err != nil {
		log.Fatal(err)
	}
	gasPrice, err := client.SuggestGasPrice(context.Background())
	if err != nil {
		log.Fatal(err)
	}
	privateKey, err := crypto.HexToECDSA(private_key)
	if err != nil {
		log.Fatal(err)
	}
	chainID := big.NewInt(int64(blockchain_id))
	auth, err := bind.NewKeyedTransactorWithChainID(privateKey, chainID)
	if err != nil {
		log.Fatal(err)
	}
	auth.Value = big.NewInt(0)
	auth.GasLimit = uint64(header.GasLimit -1)
	auth.GasPrice = gasPrice
	fromAddress := auth.From
	log.Printf("blockchain_id:%d owner_address:%s gas_limit:%d gas_price:%d", blockchain_id, fromAddress.String(), header.GasLimit, gasPrice)

	contractAddress := common.HexToAddress(contract_addr)
	instance, err := contracts.NewContracts(contractAddress, client)
	if err != nil {
		log.Fatal(err)
	}

	sql := "SELECT id, index_node, transaction_type,transaction_try_times FROM transaction_queue where blockchain_id = ? and transaction_type in (2,3) and transaction_flag = 0 and transaction_try_times < ? order by updated_at"
	rows, _ := db.Query(sql, blockchain_id, max_transaction_try_times)
	defer rows.Close()
	var id int
	var index_node string 
	var transaction_type int
	var transaction_try_times int
	for rows.Next() {
		if err := rows.Scan(&id, &index_node, &transaction_type, &transaction_try_times); err != nil {
			log.Printf("query last_block_number error: %v", err)
			return;
		}
		var status uint64
		log.Printf("id=%d,blockchain_id=%d,index_node=%s,transaction_type=%d,transaction_try_times=%d", id, blockchain_id, index_node, transaction_type, transaction_try_times) 
		switch transaction_type {
		case transaction_type_delegate_settle:
			status = DelegateSettleCall(client, instance, auth, index_node)
		case transaction_type_cancel_lock:
			status = CancelLockCall(client, instance, auth, index_node)
		}
		if (0 != status) {
			UpdateTransactionFlag(db, id, 1, transaction_try_times + 1)
		} else {
			UpdateTransactionFlag(db, id, 0, transaction_try_times + 1)
		}
	}

	// test code
	/*
	addressTo := common.HexToAddress("0x2a09e7387e4cb1cc5140f8900d3c17ccd9e0a279")
	address_token := common.HexToAddress("0x97789F1dEA6510D56FbC8EBd44f8F5d6EE1fc7fD")
	fee := big.NewInt(100)
	index_node = "test001"
	LockAssetCall(client, instance, auth, index_node, addressTo, address_token, fee)
	*/
}

func main() {
	currentTime := time.Now()
	date := currentTime.Format("2006-01-02") 
	fileName := "logs/call_log_" + date + ".txt"
	file, err := os.OpenFile(fileName, os.O_CREATE|os.O_WRONLY|os.O_APPEND, 0666)
	if err != nil {
		log.Fatal(err)
	}
	defer file.Close()

	log.SetFlags(log.Ldate | log.Ltime)
	log.SetOutput(file)

	db, err := sql.Open("mysql", "root:F0BYKDqw7@tcp(127.0.0.1:3306)/kolink?parseTime=true&loc=Local")
	if err != nil {
		log.Fatal(err)
	}
	pingErr := db.Ping()
	if pingErr != nil {
		log.Fatal(pingErr)
	}
	rows, _ := db.Query("SELECT blockchain_id,rpc_url,contract_addr,private_key FROM transaction_base")
	defer rows.Close()
	var blockchain_id int
	var rpc_url string
	var contract_addr string
	var private_key string
	for rows.Next() {
		if err := rows.Scan(&blockchain_id, &rpc_url, &contract_addr, &private_key); err != nil {
			log.Printf("query transaction_base error: %v", err)
			return;
		}
		log.Printf("blockchain_id:%d rpc_url:%s contract_addr:%s private_key:%s", blockchain_id, rpc_url, contract_addr, private_key)
		Execute(db, rpc_url, contract_addr, private_key, blockchain_id)
	}
}
