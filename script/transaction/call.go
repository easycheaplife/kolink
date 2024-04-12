package main

import (
	"contracts"
	"context"
	"fmt"
	"github.com/ethereum/go-ethereum/accounts/abi/bind"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
	"log"
	"math/big"
)

func main() {
	client, err := ethclient.Dial("http://120.55.165.46:8545")
	if err != nil {
		log.Fatal(err)
	}

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
	fmt.Println("owner address === ", fromAddress.String())

	contractAddress := common.HexToAddress("0xD7aAdD7BD1d12ee13E1f4Db8BB56458882796bE4")
	instance, err := contracts.NewContracts(contractAddress, client)
	if err != nil {
		log.Fatal(err)
	}
	indexCode := "0x009"
	tx, err := instance.DelegateSettle(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("delegateSettle call tx === ", tx)
	fmt.Println("delegateSettle call tx hash === ", tx.Hash().String())

	receipt, err := bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("Transaction receipt.Status === ", receipt.Status)

	tx, err = instance.CancelLock(auth, indexCode)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("CancelLock call tx === ", tx)
	fmt.Println("CancelLock call tx hash === ", tx.Hash().String())

	receipt, err = bind.WaitMined(context.Background(), client, tx)
	if err != nil {
		log.Fatal(err)
	}
	fmt.Println("Transaction receipt.Status === ", receipt.Status)
}
