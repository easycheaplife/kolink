package main

import (
	"contracts"
	"context"
	"time"
	"fmt"
	"github.com/ethereum/go-ethereum/accounts/abi/bind"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
	"log"
	"math/big"
	_ "github.com/go-sql-driver/mysql"
	"database/sql"
)

func DelegateSettleCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, indexCode string) uint64 {
	tx, err := instance.DelegateSettle(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("DelegateSettleCall receipt.Status:", receipt.Status)
	return receipt.Status
}

func UpdateTransactionFlag(db* sql.DB, id int, transaction_flag int, transaction_try_times int) {
	updated_time := time.Now().Format("2006-01-02 15:04:05")
	sql := "UPDATE transaction_queue SET transaction_flag = ?,transaction_try_times = ?, updated_at = ? where id = ?"
	_, err := db.Exec(sql, transaction_flag, transaction_try_times, updated_time, id)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Printf("update success! id:%d, transaction_flag:%d, transaction_try_times:%d", id, transaction_flag, transaction_try_times)
}

func CancelLockCall(client *ethclient.Client, instance *contracts.Contracts, auth *bind.TransactOpts, indexCode string) uint64 {
	tx, err := instance.CancelLock(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("CancelLockCall receipt.Status:", receipt.Status)
	return receipt.Status
}

func main() {
	const max_transaction_try_times = 3
	const transaction_type_lock_assert = 0;
	const transaction_type_settle = 1;
	const transaction_type_delegate_settle = 2;
	const transaction_type_cancel_lock = 3;

	db, err := sql.Open("mysql", "root:F0BYKDqw7@tcp(127.0.0.1:3306)/kolink?parseTime=true&loc=Local")
	client, err := ethclient.Dial("http://120.55.165.46:8545")
	if err != nil {
		log.Fatal(err)
	}
	pingErr := db.Ping()
	if pingErr != nil {
		log.Fatal(pingErr)
	}
	fmt.Println("mysql connected!")

	const owner_pvk = "6a4843f986e41899fa98984f0a559d8e870f2bb5552bfeb79b427c1199386710"
	privateKey, err := crypto.HexToECDSA(owner_pvk)
	if err != nil {
		log.Fatal(err)
	}
	chainID := big.NewInt(1)
	auth, err := bind.NewKeyedTransactorWithChainID(privateKey, chainID)
	if err != nil {
		log.Fatal(err)
	}
	auth.Value = big.NewInt(0)
	auth.GasLimit = uint64(1000000)
	auth.GasPrice = big.NewInt(3000000000000)
	fromAddress := auth.From
	fmt.Println("owner address:", fromAddress.String())

	contractAddress := common.HexToAddress("0xD7aAdD7BD1d12ee13E1f4Db8BB56458882796bE4")
	instance, err := contracts.NewContracts(contractAddress, client)
	if err != nil {
		log.Fatal(err)
	}

	sql := "SELECT id, index_node, transaction_type,transaction_try_times FROM transaction_queue where transaction_type in (2,3) and transaction_flag = 0 and transaction_try_times < ? order by updated_at"
	rows, _ := db.Query(sql, max_transaction_try_times)
	defer rows.Close()
	indexCode := "0x009"
	var id int
	var index_node string 
	var transaction_type int
	var transaction_try_times int
	for rows.Next() {
		if err := rows.Scan(&id, &index_node, &transaction_type, &transaction_try_times); err != nil {
			fmt.Errorf("query last_block_number error: %v", err)
			return;
		}
		var status uint64
		fmt.Println("id,index_node, transaction_type,transaction_try_times", id, index_node, transaction_type, transaction_try_times) 
		switch transaction_type {
		case transaction_type_delegate_settle:
			status = DelegateSettleCall(client, instance, auth, indexCode)
		case transaction_type_cancel_lock:
			status = CancelLockCall(client, instance, auth, indexCode)
		}
		if (0 != status) {
			UpdateTransactionFlag(db, id, 1, transaction_try_times + 1)
		} else {
			UpdateTransactionFlag(db, id, 0, transaction_try_times + 1)
		}
	}

}
