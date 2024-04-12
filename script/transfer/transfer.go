package main

import (
	"context"
	"fmt"
	"time"
	"log"
	"math/big"
	"strings"
	_ "github.com/go-sql-driver/mysql"
	"database/sql"
	"github.com/ethereum/go-ethereum"
	"github.com/ethereum/go-ethereum/accounts/abi"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
)

func GetLatestBlock(client *ethclient.Client) (*big.Int, error) {
	header, err := client.HeaderByNumber(context.Background(), nil)
	if err != nil {
		return nil, err
	}

	latestBlockNumber := header.Number
	return latestBlockNumber, nil
}

func InsertEvent(db* sql.DB, index_code string, event_type int, block_number uint64, 
	from_address string, to_address string, token string, amt int64, created_time uint64) (error) {
	stmt, err := db.Prepare("INSERT INTO event (index_code, event_type, block_number, from_address, to_address, amt, created_time) VALUES (?, ?, ?, ?, ?, ?, ?)")		
	if err != nil {
		return err
	}
	defer stmt.Close()
	_, err = stmt.Exec(index_code, event_type, block_number, from_address, to_address, amt, created_time)
	if err != nil {
		return err
	}
	fmt.Printf("insert success! block_number：", block_number)
	return nil
}

func main() {
	const rpc_url = "http://120.55.165.46:8545"
	const contract_addr = "0xD7aAdD7BD1d12ee13E1f4Db8BB56458882796bE4"
	const assetLockerAbi = `[{
		"inputs": [],
			"stateMutability": "nonpayable",
			"type": "constructor"
		},
		{
			"anonymous": false,
			"inputs": [
				{
				  "indexed": false,
				  "internalType": "address",
				  "name": "previousAdmin",
				  "type": "address"
				},
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "newAdmin",
				  "type": "address"
			  }
			  ],
				  "name": "AdminChanged",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": true,
				  "internalType": "address",
				  "name": "beacon",
				  "type": "address"
			  }
			  ],
				  "name": "BeaconUpgraded",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_locker",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_to",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_token",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "uint256",
				  "name": "_amt",
				  "type": "uint256"
			  }
			  ],
				  "name": "CancelLock",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_locker",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_to",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_token",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "uint256",
				  "name": "_amt",
				  "type": "uint256"
			  }
			  ],
				  "name": "DelegateSettle",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "uint8",
				  "name": "version",
				  "type": "uint8"
			  }
			  ],
				  "name": "Initialized",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_user",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_token",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "uint256",
				  "name": "_lockAmt",
				  "type": "uint256"
			  }
			  ],
				  "name": "LockAsset",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": true,
				  "internalType": "address",
				  "name": "previousOwner",
				  "type": "address"
			  },
			  {
				  "indexed": true,
				  "internalType": "address",
				  "name": "newOwner",
				  "type": "address"
			  }
			  ],
				  "name": "OwnershipTransferred",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "account",
				  "type": "address"
			  }
			  ],
				  "name": "Paused",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "address[]",
				  "name": "_tokenList",
				  "type": "address[]"
			  },
			  {
				  "indexed": false,
				  "internalType": "bool[]",
				  "name": "_flagList",
				  "type": "bool[]"
			  }
			  ],
				  "name": "SetTokenLockable",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_to",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "_token",
				  "type": "address"
			  },
			  {
				  "indexed": false,
				  "internalType": "uint256",
				  "name": "_amt",
				  "type": "uint256"
			  }
			  ],
				  "name": "Settle",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": false,
				  "internalType": "address",
				  "name": "account",
				  "type": "address"
			  }
			  ],
				  "name": "Unpaused",
				  "type": "event"
		  },
		  {
			  "anonymous": false,
			  "inputs": [
			  {
				  "indexed": true,
				  "internalType": "address",
				  "name": "implementation",
				  "type": "address"
			  }
			  ],
				  "name": "Upgraded",
				  "type": "event"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  }
			  ],
				  "name": "cancelLock",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  }
			  ],
				  "name": "delegateSettle",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address[]",
				  "name": "_tokenList",
				  "type": "address[]"
			  }
			  ],
				  "name": "initialize",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  },
			  {
				  "internalType": "address",
				  "name": "_to",
				  "type": "address"
			  },
			  {
				  "internalType": "address",
				  "name": "_token",
				  "type": "address"
			  },
			  {
				  "internalType": "uint256",
				  "name": "_lockAmt",
				  "type": "uint256"
			  }
			  ],
				  "name": "lockAsset",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "string",
				  "name": "indexCode",
				  "type": "string"
			  }
			  ],
				  "name": "orderLockInfo",
				  "outputs": [
				  {
					  "internalType": "address",
					  "name": "locker",
					  "type": "address"
				  },
				  {
					  "internalType": "address",
					  "name": "to",
					  "type": "address"
				  },
				  {
					  "internalType": "address",
					  "name": "token",
					  "type": "address"
				  },
				  {
					  "internalType": "uint256",
					  "name": "amt",
					  "type": "uint256"
				  },
				  {
					  "internalType": "enum AssetLocker.OrderStatus",
					  "name": "status",
					  "type": "uint8"
				  }
			  ],
				  "stateMutability": "view",
				  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "owner",
			  "outputs": [
			  {
				  "internalType": "address",
				  "name": "",
				  "type": "address"
			  }
			  ],
				  "stateMutability": "view",
				  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "pause",
			  "outputs": [],
			  "stateMutability": "nonpayable",
			  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "paused",
			  "outputs": [
			  {
				  "internalType": "bool",
				  "name": "",
				  "type": "bool"
			  }
			  ],
				  "stateMutability": "view",
				  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "proxiableUUID",
			  "outputs": [
			  {
				  "internalType": "bytes32",
				  "name": "",
				  "type": "bytes32"
			  }
			  ],
				  "stateMutability": "view",
				  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "renounceOwnership",
			  "outputs": [],
			  "stateMutability": "nonpayable",
			  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address[]",
				  "name": "_tokenList",
				  "type": "address[]"
			  },
			  {
				  "internalType": "bool[]",
				  "name": "_flagList",
				  "type": "bool[]"
			  }
			  ],
				  "name": "setTokenLockable",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "string",
				  "name": "_indexCode",
				  "type": "string"
			  }
			  ],
				  "name": "settle",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address",
				  "name": "token",
				  "type": "address"
			  }
			  ],
				  "name": "tokenLockable",
				  "outputs": [
				  {
					  "internalType": "bool",
					  "name": "lockable",
					  "type": "bool"
				  }
				  ],
					  "stateMutability": "view",
					  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address",
				  "name": "newOwner",
				  "type": "address"
			  }
			  ],
				  "name": "transferOwnership",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "unpause",
			  "outputs": [],
			  "stateMutability": "nonpayable",
			  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address",
				  "name": "newImplementation",
				  "type": "address"
			  }
			  ],
				  "name": "upgradeTo",
				  "outputs": [],
				  "stateMutability": "nonpayable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address",
				  "name": "newImplementation",
				  "type": "address"
			  },
			  {
				  "internalType": "bytes",
				  "name": "data",
				  "type": "bytes"
			  }
			  ],
				  "name": "upgradeToAndCall",
				  "outputs": [],
				  "stateMutability": "payable",
				  "type": "function"
		  },
		  {
			  "inputs": [
			  {
				  "internalType": "address",
				  "name": "user",
				  "type": "address"
			  },
			  {
				  "internalType": "address",
				  "name": "token",
				  "type": "address"
			  }
			  ],
				  "name": "userLockedBal",
				  "outputs": [
				  {
					  "internalType": "uint256",
					  "name": "amt",
					  "type": "uint256"
				  }
				  ],
					  "stateMutability": "view",
					  "type": "function"
		  },
		  {
			  "inputs": [],
			  "name": "version",
			  "outputs": [
			  {
				  "internalType": "string",
				  "name": "",
				  "type": "string"
			  }
			  ],
				  "stateMutability": "pure",
				  "type": "function"
		  },
		  {
			  "stateMutability": "payable",
			  "type": "receive"
		  }]`

/*
	cfg := mysql.Config{
		User:   "root",
		Passwd: "F0BYKDqw7",
		Net:    "tcp",
		Addr:   "192.168.0.194:3306",
		DBName: "kolink",
	}
	var db *sql.DB
	db, err := sql.Open("mysql", cfg.FormatDSN())
*/
	db, err := sql.Open("mysql", "root:F0BYKDqw7@tcp(192.168.0.194:3306)/kolink?parseTime=true&loc=Local")
	if err != nil {
		log.Fatal(err)
	}
	pingErr := db.Ping()
	if pingErr != nil {
		log.Fatal(pingErr)
	}
	fmt.Println("mysql connected!")
	rows, _ := db.Query("SELECT last_block_number FROM event_base")
	defer rows.Close()
	var last_block_number int
	for rows.Next() {
		if err := rows.Scan(&last_block_number); err != nil {
			fmt.Errorf("query last_block_number error: %v", err)
			return;
		}
	}
	fmt.Println("last_block_number:", last_block_number)

	const start_block = 19622170
	const end_block = 19622200
	const event_type_lock_assert = 0;
	const event_type_settle = 1;
	const event_type_delegate_settle = 2;
	const event_type_cancel_lock = 3;

	client, err := ethclient.Dial(rpc_url)
	if err != nil {
		log.Fatal(err)
	}

	latestBlockNumber, err := GetLatestBlock(client)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("Latest Block Number:", latestBlockNumber)

	contractAddress := common.HexToAddress(contract_addr)
	contractAbi, err := abi.JSON(strings.NewReader(assetLockerAbi))
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

	lockAssetEventSig := []byte("LockAsset(address,address,uint256)")
	lockAssetEventSigHash := crypto.Keccak256Hash(lockAssetEventSig)
	type ContractsLockAsset struct {
		User    common.Address
		Token   common.Address
		LockAmt *big.Int
	}

	settleSig := []byte("Settle(string,address,address,uint256)")
	settleEventSigHash := crypto.Keccak256Hash(settleSig)
	type ContractsSettle struct {
		IndexCode string
		To        common.Address
		Token     common.Address
		Amt       *big.Int
	}

	delegateSettleSig := []byte("DelegateSettle(string,address,address,address,uint256)")
	delegateSettleEventSigHash := crypto.Keccak256Hash(delegateSettleSig)
	type ContractsDelegateSettle struct {
		IndexCode string
		Locker    common.Address
		To        common.Address
		Token     common.Address
		Amt       *big.Int
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
		fmt.Println("BlockNumber:",vLog.BlockNumber)
		block, err := client.BlockByNumber(context.Background(), new(big.Int).SetUint64(vLog.BlockNumber))
		if err != nil {
			log.Fatal(err)
		}
		fmt.Println("Timestamp:", time.Unix(int64(block.Time()), 0).Format("2006-01-02 15:04:05 MST"))
		switch vLog.Topics[0].Hex() {
		case lockAssetEventSigHash.Hex():
			fmt.Printf("Event Name: LockAsset()\n")

			var lockAssetEvent ContractsLockAsset
			err := contractAbi.UnpackIntoInterface(&lockAssetEvent, "LockAsset", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			fmt.Println("lockAssetEvent.User : ", lockAssetEvent.User)
			fmt.Println("lockAssetEvent.Token : ", lockAssetEvent.Token)
			fmt.Println("lockAssetEvent.LockAmt : ", lockAssetEvent.LockAmt)
			err = InsertEvent(db, "", event_type_lock_assert, vLog.BlockNumber, lockAssetEvent.User.String(), "", lockAssetEvent.Token.String(), lockAssetEvent.LockAmt.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case settleEventSigHash.Hex():
			fmt.Printf("Event Name: Settle()\n")

			var settleEvent ContractsSettle
			err := contractAbi.UnpackIntoInterface(&settleEvent, "Settle", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			fmt.Println("settleEvent.IndexCode : ", settleEvent.IndexCode)
			fmt.Println("settleEvent.To : ", settleEvent.To)
			fmt.Println("settleEvent.Token : ", settleEvent.Token)
			fmt.Println("settleEvent.Amt : ", settleEvent.Amt)
			err = InsertEvent(db, settleEvent.IndexCode, event_type_settle, vLog.BlockNumber, "", settleEvent.To.String(), settleEvent.Token.String(), settleEvent.Amt.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case delegateSettleEventSigHash.Hex():
			fmt.Printf("Event Name: DelegateSettle()\n")

			var delegateSettleEvent ContractsDelegateSettle
			err := contractAbi.UnpackIntoInterface(&delegateSettleEvent, "DelegateSettle", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			fmt.Println("delegateSettleEvent.IndexCode : ", delegateSettleEvent.IndexCode)
			fmt.Println("delegateSettleEvent.Locker : ", delegateSettleEvent.Locker)
			fmt.Println("delegateSettleEvent.To : ", delegateSettleEvent.To)
			fmt.Println("delegateSettleEvent.Token : ", delegateSettleEvent.Token)
			fmt.Println("delegateSettleEvent.Amt : ", delegateSettleEvent.Amt)
			err = InsertEvent(db, delegateSettleEvent.IndexCode, event_type_delegate_settle, vLog.BlockNumber, 
				delegateSettleEvent.Locker.String(), delegateSettleEvent.To.String(), delegateSettleEvent.Token.String(), delegateSettleEvent.Amt.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}

		case cancelLockEventSigHash.Hex():
			fmt.Printf("Event Name: CancelLock()\n")

			var cancelLockEvent ContractsCancelLock
			err := contractAbi.UnpackIntoInterface(&cancelLockEvent, "CancelLock", vLog.Data)
			if err != nil {
				log.Fatal(err)
			}
			fmt.Println("cancelLockEvent.IndexCode : ", cancelLockEvent.IndexCode)
			fmt.Println("cancelLockEvent.Locker : ", cancelLockEvent.Locker)
			fmt.Println("cancelLockEvent.To : ", cancelLockEvent.To)
			fmt.Println("cancelLockEvent.Token : ", cancelLockEvent.Token)
			fmt.Println("cancelLockEvent.Amt : ", cancelLockEvent.Amt)
			err = InsertEvent(db, cancelLockEvent.IndexCode, event_type_cancel_lock, vLog.BlockNumber, 
				cancelLockEvent.Locker.String(), cancelLockEvent.To.String(), cancelLockEvent.Token.String(), cancelLockEvent.Amt.Int64(), block.Time());
			if err != nil {
				log.Fatal(err)
			}
		}
		fmt.Printf("\n\n")
	}
	sql := "UPDATE event_base SET last_block_number = ?"
	_, err = db.Exec(sql, latestBlockNumber.String())
	if err != nil {
		log.Fatal(err)
	}

}
