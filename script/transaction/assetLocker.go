// Code generated - DO NOT EDIT.
// This file is a generated binding and any manual changes will be lost.

package contracts

import (
	"errors"
	"math/big"
	"strings"

	ethereum "github.com/ethereum/go-ethereum"
	"github.com/ethereum/go-ethereum/accounts/abi"
	"github.com/ethereum/go-ethereum/accounts/abi/bind"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/core/types"
	"github.com/ethereum/go-ethereum/event"
)

// Reference imports to suppress errors if they are not otherwise used.
var (
	_ = errors.New
	_ = big.NewInt
	_ = strings.NewReader
	_ = ethereum.NotFound
	_ = bind.Bind
	_ = common.Big1
	_ = types.BloomLookup
	_ = event.NewSubscription
	_ = abi.ConvertType
)

// ContractsMetaData contains all meta data concerning the Contracts contract.
var ContractsMetaData = &bind.MetaData{
	ABI: "[{\"inputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"constructor\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"address\",\"name\":\"previousAdmin\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"newAdmin\",\"type\":\"address\"}],\"name\":\"AdminChanged\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"internalType\":\"address\",\"name\":\"beacon\",\"type\":\"address\"}],\"name\":\"BeaconUpgraded\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_locker\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_to\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_token\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_amt\",\"type\":\"uint256\"}],\"name\":\"CancelLock\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_locker\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_to\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_token\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_amt\",\"type\":\"uint256\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_fee\",\"type\":\"uint256\"}],\"name\":\"DelegateSettle\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"uint8\",\"name\":\"version\",\"type\":\"uint8\"}],\"name\":\"Initialized\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_user\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_to\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_token\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_lockAmt\",\"type\":\"uint256\"}],\"name\":\"LockAsset\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"internalType\":\"address\",\"name\":\"previousOwner\",\"type\":\"address\"},{\"indexed\":true,\"internalType\":\"address\",\"name\":\"newOwner\",\"type\":\"address\"}],\"name\":\"OwnershipTransferred\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"address\",\"name\":\"account\",\"type\":\"address\"}],\"name\":\"Paused\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_oldFeeRate\",\"type\":\"uint256\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_newFeeRate\",\"type\":\"uint256\"}],\"name\":\"SetPlatformFeeRate\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_oldReceiver\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_newReceiver\",\"type\":\"address\"}],\"name\":\"SetPlatformFeeReceiver\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"address[]\",\"name\":\"_tokenList\",\"type\":\"address[]\"},{\"indexed\":false,\"internalType\":\"bool[]\",\"name\":\"_flagList\",\"type\":\"bool[]\"}],\"name\":\"SetTokenLockable\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_to\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"address\",\"name\":\"_token\",\"type\":\"address\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_amt\",\"type\":\"uint256\"},{\"indexed\":false,\"internalType\":\"uint256\",\"name\":\"_fee\",\"type\":\"uint256\"}],\"name\":\"Settle\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":false,\"internalType\":\"address\",\"name\":\"account\",\"type\":\"address\"}],\"name\":\"Unpaused\",\"type\":\"event\"},{\"anonymous\":false,\"inputs\":[{\"indexed\":true,\"internalType\":\"address\",\"name\":\"implementation\",\"type\":\"address\"}],\"name\":\"Upgraded\",\"type\":\"event\"},{\"inputs\":[{\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"}],\"name\":\"cancelLock\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"}],\"name\":\"delegateSettle\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address[]\",\"name\":\"_tokenList\",\"type\":\"address[]\"},{\"internalType\":\"uint256\",\"name\":\"_platformFeeRate\",\"type\":\"uint256\"},{\"internalType\":\"address\",\"name\":\"_platformFeeReceiver\",\"type\":\"address\"}],\"name\":\"initialize\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"},{\"internalType\":\"address\",\"name\":\"_to\",\"type\":\"address\"},{\"internalType\":\"address\",\"name\":\"_token\",\"type\":\"address\"},{\"internalType\":\"uint256\",\"name\":\"_lockAmt\",\"type\":\"uint256\"}],\"name\":\"lockAsset\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"string\",\"name\":\"indexCode\",\"type\":\"string\"}],\"name\":\"orderLockInfo\",\"outputs\":[{\"internalType\":\"address\",\"name\":\"locker\",\"type\":\"address\"},{\"internalType\":\"address\",\"name\":\"to\",\"type\":\"address\"},{\"internalType\":\"address\",\"name\":\"token\",\"type\":\"address\"},{\"internalType\":\"uint256\",\"name\":\"amt\",\"type\":\"uint256\"},{\"internalType\":\"enumAssetLocker.OrderStatus\",\"name\":\"status\",\"type\":\"uint8\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"owner\",\"outputs\":[{\"internalType\":\"address\",\"name\":\"\",\"type\":\"address\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"pause\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"paused\",\"outputs\":[{\"internalType\":\"bool\",\"name\":\"\",\"type\":\"bool\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"platformFeeRate\",\"outputs\":[{\"internalType\":\"uint256\",\"name\":\"\",\"type\":\"uint256\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"platformFeeReceiver\",\"outputs\":[{\"internalType\":\"address\",\"name\":\"\",\"type\":\"address\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"proxiableUUID\",\"outputs\":[{\"internalType\":\"bytes32\",\"name\":\"\",\"type\":\"bytes32\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"renounceOwnership\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"uint256\",\"name\":\"_newFeeRate\",\"type\":\"uint256\"}],\"name\":\"setPlatformFeeRate\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"_newReceiver\",\"type\":\"address\"}],\"name\":\"setPlatformFeeReceiver\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address[]\",\"name\":\"_tokenList\",\"type\":\"address[]\"},{\"internalType\":\"bool[]\",\"name\":\"_flagList\",\"type\":\"bool[]\"}],\"name\":\"setTokenLockable\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"string\",\"name\":\"_indexCode\",\"type\":\"string\"}],\"name\":\"settle\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"token\",\"type\":\"address\"}],\"name\":\"tokenLockable\",\"outputs\":[{\"internalType\":\"bool\",\"name\":\"lockable\",\"type\":\"bool\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"newOwner\",\"type\":\"address\"}],\"name\":\"transferOwnership\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"unpause\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"newImplementation\",\"type\":\"address\"}],\"name\":\"upgradeTo\",\"outputs\":[],\"stateMutability\":\"nonpayable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"newImplementation\",\"type\":\"address\"},{\"internalType\":\"bytes\",\"name\":\"data\",\"type\":\"bytes\"}],\"name\":\"upgradeToAndCall\",\"outputs\":[],\"stateMutability\":\"payable\",\"type\":\"function\"},{\"inputs\":[{\"internalType\":\"address\",\"name\":\"user\",\"type\":\"address\"},{\"internalType\":\"address\",\"name\":\"token\",\"type\":\"address\"}],\"name\":\"userLockedBal\",\"outputs\":[{\"internalType\":\"uint256\",\"name\":\"amt\",\"type\":\"uint256\"}],\"stateMutability\":\"view\",\"type\":\"function\"},{\"inputs\":[],\"name\":\"version\",\"outputs\":[{\"internalType\":\"string\",\"name\":\"\",\"type\":\"string\"}],\"stateMutability\":\"pure\",\"type\":\"function\"},{\"stateMutability\":\"payable\",\"type\":\"receive\"}]",
}

// ContractsABI is the input ABI used to generate the binding from.
// Deprecated: Use ContractsMetaData.ABI instead.
var ContractsABI = ContractsMetaData.ABI

// Contracts is an auto generated Go binding around an Ethereum contract.
type Contracts struct {
	ContractsCaller     // Read-only binding to the contract
	ContractsTransactor // Write-only binding to the contract
	ContractsFilterer   // Log filterer for contract events
}

// ContractsCaller is an auto generated read-only Go binding around an Ethereum contract.
type ContractsCaller struct {
	contract *bind.BoundContract // Generic contract wrapper for the low level calls
}

// ContractsTransactor is an auto generated write-only Go binding around an Ethereum contract.
type ContractsTransactor struct {
	contract *bind.BoundContract // Generic contract wrapper for the low level calls
}

// ContractsFilterer is an auto generated log filtering Go binding around an Ethereum contract events.
type ContractsFilterer struct {
	contract *bind.BoundContract // Generic contract wrapper for the low level calls
}

// ContractsSession is an auto generated Go binding around an Ethereum contract,
// with pre-set call and transact options.
type ContractsSession struct {
	Contract     *Contracts        // Generic contract binding to set the session for
	CallOpts     bind.CallOpts     // Call options to use throughout this session
	TransactOpts bind.TransactOpts // Transaction auth options to use throughout this session
}

// ContractsCallerSession is an auto generated read-only Go binding around an Ethereum contract,
// with pre-set call options.
type ContractsCallerSession struct {
	Contract *ContractsCaller // Generic contract caller binding to set the session for
	CallOpts bind.CallOpts    // Call options to use throughout this session
}

// ContractsTransactorSession is an auto generated write-only Go binding around an Ethereum contract,
// with pre-set transact options.
type ContractsTransactorSession struct {
	Contract     *ContractsTransactor // Generic contract transactor binding to set the session for
	TransactOpts bind.TransactOpts    // Transaction auth options to use throughout this session
}

// ContractsRaw is an auto generated low-level Go binding around an Ethereum contract.
type ContractsRaw struct {
	Contract *Contracts // Generic contract binding to access the raw methods on
}

// ContractsCallerRaw is an auto generated low-level read-only Go binding around an Ethereum contract.
type ContractsCallerRaw struct {
	Contract *ContractsCaller // Generic read-only contract binding to access the raw methods on
}

// ContractsTransactorRaw is an auto generated low-level write-only Go binding around an Ethereum contract.
type ContractsTransactorRaw struct {
	Contract *ContractsTransactor // Generic write-only contract binding to access the raw methods on
}

// NewContracts creates a new instance of Contracts, bound to a specific deployed contract.
func NewContracts(address common.Address, backend bind.ContractBackend) (*Contracts, error) {
	contract, err := bindContracts(address, backend, backend, backend)
	if err != nil {
		return nil, err
	}
	return &Contracts{ContractsCaller: ContractsCaller{contract: contract}, ContractsTransactor: ContractsTransactor{contract: contract}, ContractsFilterer: ContractsFilterer{contract: contract}}, nil
}

// NewContractsCaller creates a new read-only instance of Contracts, bound to a specific deployed contract.
func NewContractsCaller(address common.Address, caller bind.ContractCaller) (*ContractsCaller, error) {
	contract, err := bindContracts(address, caller, nil, nil)
	if err != nil {
		return nil, err
	}
	return &ContractsCaller{contract: contract}, nil
}

// NewContractsTransactor creates a new write-only instance of Contracts, bound to a specific deployed contract.
func NewContractsTransactor(address common.Address, transactor bind.ContractTransactor) (*ContractsTransactor, error) {
	contract, err := bindContracts(address, nil, transactor, nil)
	if err != nil {
		return nil, err
	}
	return &ContractsTransactor{contract: contract}, nil
}

// NewContractsFilterer creates a new log filterer instance of Contracts, bound to a specific deployed contract.
func NewContractsFilterer(address common.Address, filterer bind.ContractFilterer) (*ContractsFilterer, error) {
	contract, err := bindContracts(address, nil, nil, filterer)
	if err != nil {
		return nil, err
	}
	return &ContractsFilterer{contract: contract}, nil
}

// bindContracts binds a generic wrapper to an already deployed contract.
func bindContracts(address common.Address, caller bind.ContractCaller, transactor bind.ContractTransactor, filterer bind.ContractFilterer) (*bind.BoundContract, error) {
	parsed, err := ContractsMetaData.GetAbi()
	if err != nil {
		return nil, err
	}
	return bind.NewBoundContract(address, *parsed, caller, transactor, filterer), nil
}

// Call invokes the (constant) contract method with params as input values and
// sets the output to result. The result type might be a single field for simple
// returns, a slice of interfaces for anonymous returns and a struct for named
// returns.
func (_Contracts *ContractsRaw) Call(opts *bind.CallOpts, result *[]interface{}, method string, params ...interface{}) error {
	return _Contracts.Contract.ContractsCaller.contract.Call(opts, result, method, params...)
}

// Transfer initiates a plain transaction to move funds to the contract, calling
// its default method if one is available.
func (_Contracts *ContractsRaw) Transfer(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.Contract.ContractsTransactor.contract.Transfer(opts)
}

// Transact invokes the (paid) contract method with params as input values.
func (_Contracts *ContractsRaw) Transact(opts *bind.TransactOpts, method string, params ...interface{}) (*types.Transaction, error) {
	return _Contracts.Contract.ContractsTransactor.contract.Transact(opts, method, params...)
}

// Call invokes the (constant) contract method with params as input values and
// sets the output to result. The result type might be a single field for simple
// returns, a slice of interfaces for anonymous returns and a struct for named
// returns.
func (_Contracts *ContractsCallerRaw) Call(opts *bind.CallOpts, result *[]interface{}, method string, params ...interface{}) error {
	return _Contracts.Contract.contract.Call(opts, result, method, params...)
}

// Transfer initiates a plain transaction to move funds to the contract, calling
// its default method if one is available.
func (_Contracts *ContractsTransactorRaw) Transfer(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.Contract.contract.Transfer(opts)
}

// Transact invokes the (paid) contract method with params as input values.
func (_Contracts *ContractsTransactorRaw) Transact(opts *bind.TransactOpts, method string, params ...interface{}) (*types.Transaction, error) {
	return _Contracts.Contract.contract.Transact(opts, method, params...)
}

// OrderLockInfo is a free data retrieval call binding the contract method 0x78342fb9.
//
// Solidity: function orderLockInfo(string indexCode) view returns(address locker, address to, address token, uint256 amt, uint8 status)
func (_Contracts *ContractsCaller) OrderLockInfo(opts *bind.CallOpts, indexCode string) (struct {
	Locker common.Address
	To     common.Address
	Token  common.Address
	Amt    *big.Int
	Status uint8
}, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "orderLockInfo", indexCode)

	outstruct := new(struct {
		Locker common.Address
		To     common.Address
		Token  common.Address
		Amt    *big.Int
		Status uint8
	})
	if err != nil {
		return *outstruct, err
	}

	outstruct.Locker = *abi.ConvertType(out[0], new(common.Address)).(*common.Address)
	outstruct.To = *abi.ConvertType(out[1], new(common.Address)).(*common.Address)
	outstruct.Token = *abi.ConvertType(out[2], new(common.Address)).(*common.Address)
	outstruct.Amt = *abi.ConvertType(out[3], new(*big.Int)).(**big.Int)
	outstruct.Status = *abi.ConvertType(out[4], new(uint8)).(*uint8)

	return *outstruct, err

}

// OrderLockInfo is a free data retrieval call binding the contract method 0x78342fb9.
//
// Solidity: function orderLockInfo(string indexCode) view returns(address locker, address to, address token, uint256 amt, uint8 status)
func (_Contracts *ContractsSession) OrderLockInfo(indexCode string) (struct {
	Locker common.Address
	To     common.Address
	Token  common.Address
	Amt    *big.Int
	Status uint8
}, error) {
	return _Contracts.Contract.OrderLockInfo(&_Contracts.CallOpts, indexCode)
}

// OrderLockInfo is a free data retrieval call binding the contract method 0x78342fb9.
//
// Solidity: function orderLockInfo(string indexCode) view returns(address locker, address to, address token, uint256 amt, uint8 status)
func (_Contracts *ContractsCallerSession) OrderLockInfo(indexCode string) (struct {
	Locker common.Address
	To     common.Address
	Token  common.Address
	Amt    *big.Int
	Status uint8
}, error) {
	return _Contracts.Contract.OrderLockInfo(&_Contracts.CallOpts, indexCode)
}

// Owner is a free data retrieval call binding the contract method 0x8da5cb5b.
//
// Solidity: function owner() view returns(address)
func (_Contracts *ContractsCaller) Owner(opts *bind.CallOpts) (common.Address, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "owner")

	if err != nil {
		return *new(common.Address), err
	}

	out0 := *abi.ConvertType(out[0], new(common.Address)).(*common.Address)

	return out0, err

}

// Owner is a free data retrieval call binding the contract method 0x8da5cb5b.
//
// Solidity: function owner() view returns(address)
func (_Contracts *ContractsSession) Owner() (common.Address, error) {
	return _Contracts.Contract.Owner(&_Contracts.CallOpts)
}

// Owner is a free data retrieval call binding the contract method 0x8da5cb5b.
//
// Solidity: function owner() view returns(address)
func (_Contracts *ContractsCallerSession) Owner() (common.Address, error) {
	return _Contracts.Contract.Owner(&_Contracts.CallOpts)
}

// Paused is a free data retrieval call binding the contract method 0x5c975abb.
//
// Solidity: function paused() view returns(bool)
func (_Contracts *ContractsCaller) Paused(opts *bind.CallOpts) (bool, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "paused")

	if err != nil {
		return *new(bool), err
	}

	out0 := *abi.ConvertType(out[0], new(bool)).(*bool)

	return out0, err

}

// Paused is a free data retrieval call binding the contract method 0x5c975abb.
//
// Solidity: function paused() view returns(bool)
func (_Contracts *ContractsSession) Paused() (bool, error) {
	return _Contracts.Contract.Paused(&_Contracts.CallOpts)
}

// Paused is a free data retrieval call binding the contract method 0x5c975abb.
//
// Solidity: function paused() view returns(bool)
func (_Contracts *ContractsCallerSession) Paused() (bool, error) {
	return _Contracts.Contract.Paused(&_Contracts.CallOpts)
}

// PlatformFeeRate is a free data retrieval call binding the contract method 0xeeca08f0.
//
// Solidity: function platformFeeRate() view returns(uint256)
func (_Contracts *ContractsCaller) PlatformFeeRate(opts *bind.CallOpts) (*big.Int, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "platformFeeRate")

	if err != nil {
		return *new(*big.Int), err
	}

	out0 := *abi.ConvertType(out[0], new(*big.Int)).(**big.Int)

	return out0, err

}

// PlatformFeeRate is a free data retrieval call binding the contract method 0xeeca08f0.
//
// Solidity: function platformFeeRate() view returns(uint256)
func (_Contracts *ContractsSession) PlatformFeeRate() (*big.Int, error) {
	return _Contracts.Contract.PlatformFeeRate(&_Contracts.CallOpts)
}

// PlatformFeeRate is a free data retrieval call binding the contract method 0xeeca08f0.
//
// Solidity: function platformFeeRate() view returns(uint256)
func (_Contracts *ContractsCallerSession) PlatformFeeRate() (*big.Int, error) {
	return _Contracts.Contract.PlatformFeeRate(&_Contracts.CallOpts)
}

// PlatformFeeReceiver is a free data retrieval call binding the contract method 0x2d656ad7.
//
// Solidity: function platformFeeReceiver() view returns(address)
func (_Contracts *ContractsCaller) PlatformFeeReceiver(opts *bind.CallOpts) (common.Address, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "platformFeeReceiver")

	if err != nil {
		return *new(common.Address), err
	}

	out0 := *abi.ConvertType(out[0], new(common.Address)).(*common.Address)

	return out0, err

}

// PlatformFeeReceiver is a free data retrieval call binding the contract method 0x2d656ad7.
//
// Solidity: function platformFeeReceiver() view returns(address)
func (_Contracts *ContractsSession) PlatformFeeReceiver() (common.Address, error) {
	return _Contracts.Contract.PlatformFeeReceiver(&_Contracts.CallOpts)
}

// PlatformFeeReceiver is a free data retrieval call binding the contract method 0x2d656ad7.
//
// Solidity: function platformFeeReceiver() view returns(address)
func (_Contracts *ContractsCallerSession) PlatformFeeReceiver() (common.Address, error) {
	return _Contracts.Contract.PlatformFeeReceiver(&_Contracts.CallOpts)
}

// ProxiableUUID is a free data retrieval call binding the contract method 0x52d1902d.
//
// Solidity: function proxiableUUID() view returns(bytes32)
func (_Contracts *ContractsCaller) ProxiableUUID(opts *bind.CallOpts) ([32]byte, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "proxiableUUID")

	if err != nil {
		return *new([32]byte), err
	}

	out0 := *abi.ConvertType(out[0], new([32]byte)).(*[32]byte)

	return out0, err

}

// ProxiableUUID is a free data retrieval call binding the contract method 0x52d1902d.
//
// Solidity: function proxiableUUID() view returns(bytes32)
func (_Contracts *ContractsSession) ProxiableUUID() ([32]byte, error) {
	return _Contracts.Contract.ProxiableUUID(&_Contracts.CallOpts)
}

// ProxiableUUID is a free data retrieval call binding the contract method 0x52d1902d.
//
// Solidity: function proxiableUUID() view returns(bytes32)
func (_Contracts *ContractsCallerSession) ProxiableUUID() ([32]byte, error) {
	return _Contracts.Contract.ProxiableUUID(&_Contracts.CallOpts)
}

// TokenLockable is a free data retrieval call binding the contract method 0x02c2461a.
//
// Solidity: function tokenLockable(address token) view returns(bool lockable)
func (_Contracts *ContractsCaller) TokenLockable(opts *bind.CallOpts, token common.Address) (bool, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "tokenLockable", token)

	if err != nil {
		return *new(bool), err
	}

	out0 := *abi.ConvertType(out[0], new(bool)).(*bool)

	return out0, err

}

// TokenLockable is a free data retrieval call binding the contract method 0x02c2461a.
//
// Solidity: function tokenLockable(address token) view returns(bool lockable)
func (_Contracts *ContractsSession) TokenLockable(token common.Address) (bool, error) {
	return _Contracts.Contract.TokenLockable(&_Contracts.CallOpts, token)
}

// TokenLockable is a free data retrieval call binding the contract method 0x02c2461a.
//
// Solidity: function tokenLockable(address token) view returns(bool lockable)
func (_Contracts *ContractsCallerSession) TokenLockable(token common.Address) (bool, error) {
	return _Contracts.Contract.TokenLockable(&_Contracts.CallOpts, token)
}

// UserLockedBal is a free data retrieval call binding the contract method 0x30efd6b1.
//
// Solidity: function userLockedBal(address user, address token) view returns(uint256 amt)
func (_Contracts *ContractsCaller) UserLockedBal(opts *bind.CallOpts, user common.Address, token common.Address) (*big.Int, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "userLockedBal", user, token)

	if err != nil {
		return *new(*big.Int), err
	}

	out0 := *abi.ConvertType(out[0], new(*big.Int)).(**big.Int)

	return out0, err

}

// UserLockedBal is a free data retrieval call binding the contract method 0x30efd6b1.
//
// Solidity: function userLockedBal(address user, address token) view returns(uint256 amt)
func (_Contracts *ContractsSession) UserLockedBal(user common.Address, token common.Address) (*big.Int, error) {
	return _Contracts.Contract.UserLockedBal(&_Contracts.CallOpts, user, token)
}

// UserLockedBal is a free data retrieval call binding the contract method 0x30efd6b1.
//
// Solidity: function userLockedBal(address user, address token) view returns(uint256 amt)
func (_Contracts *ContractsCallerSession) UserLockedBal(user common.Address, token common.Address) (*big.Int, error) {
	return _Contracts.Contract.UserLockedBal(&_Contracts.CallOpts, user, token)
}

// Version is a free data retrieval call binding the contract method 0x54fd4d50.
//
// Solidity: function version() pure returns(string)
func (_Contracts *ContractsCaller) Version(opts *bind.CallOpts) (string, error) {
	var out []interface{}
	err := _Contracts.contract.Call(opts, &out, "version")

	if err != nil {
		return *new(string), err
	}

	out0 := *abi.ConvertType(out[0], new(string)).(*string)

	return out0, err

}

// Version is a free data retrieval call binding the contract method 0x54fd4d50.
//
// Solidity: function version() pure returns(string)
func (_Contracts *ContractsSession) Version() (string, error) {
	return _Contracts.Contract.Version(&_Contracts.CallOpts)
}

// Version is a free data retrieval call binding the contract method 0x54fd4d50.
//
// Solidity: function version() pure returns(string)
func (_Contracts *ContractsCallerSession) Version() (string, error) {
	return _Contracts.Contract.Version(&_Contracts.CallOpts)
}

// CancelLock is a paid mutator transaction binding the contract method 0x454a7944.
//
// Solidity: function cancelLock(string _indexCode) returns()
func (_Contracts *ContractsTransactor) CancelLock(opts *bind.TransactOpts, _indexCode string) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "cancelLock", _indexCode)
}

// CancelLock is a paid mutator transaction binding the contract method 0x454a7944.
//
// Solidity: function cancelLock(string _indexCode) returns()
func (_Contracts *ContractsSession) CancelLock(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.CancelLock(&_Contracts.TransactOpts, _indexCode)
}

// CancelLock is a paid mutator transaction binding the contract method 0x454a7944.
//
// Solidity: function cancelLock(string _indexCode) returns()
func (_Contracts *ContractsTransactorSession) CancelLock(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.CancelLock(&_Contracts.TransactOpts, _indexCode)
}

// DelegateSettle is a paid mutator transaction binding the contract method 0x849650c2.
//
// Solidity: function delegateSettle(string _indexCode) returns()
func (_Contracts *ContractsTransactor) DelegateSettle(opts *bind.TransactOpts, _indexCode string) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "delegateSettle", _indexCode)
}

// DelegateSettle is a paid mutator transaction binding the contract method 0x849650c2.
//
// Solidity: function delegateSettle(string _indexCode) returns()
func (_Contracts *ContractsSession) DelegateSettle(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.DelegateSettle(&_Contracts.TransactOpts, _indexCode)
}

// DelegateSettle is a paid mutator transaction binding the contract method 0x849650c2.
//
// Solidity: function delegateSettle(string _indexCode) returns()
func (_Contracts *ContractsTransactorSession) DelegateSettle(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.DelegateSettle(&_Contracts.TransactOpts, _indexCode)
}

// Initialize is a paid mutator transaction binding the contract method 0x72483bf9.
//
// Solidity: function initialize(address[] _tokenList, uint256 _platformFeeRate, address _platformFeeReceiver) returns()
func (_Contracts *ContractsTransactor) Initialize(opts *bind.TransactOpts, _tokenList []common.Address, _platformFeeRate *big.Int, _platformFeeReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "initialize", _tokenList, _platformFeeRate, _platformFeeReceiver)
}

// Initialize is a paid mutator transaction binding the contract method 0x72483bf9.
//
// Solidity: function initialize(address[] _tokenList, uint256 _platformFeeRate, address _platformFeeReceiver) returns()
func (_Contracts *ContractsSession) Initialize(_tokenList []common.Address, _platformFeeRate *big.Int, _platformFeeReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.Initialize(&_Contracts.TransactOpts, _tokenList, _platformFeeRate, _platformFeeReceiver)
}

// Initialize is a paid mutator transaction binding the contract method 0x72483bf9.
//
// Solidity: function initialize(address[] _tokenList, uint256 _platformFeeRate, address _platformFeeReceiver) returns()
func (_Contracts *ContractsTransactorSession) Initialize(_tokenList []common.Address, _platformFeeRate *big.Int, _platformFeeReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.Initialize(&_Contracts.TransactOpts, _tokenList, _platformFeeRate, _platformFeeReceiver)
}

// LockAsset is a paid mutator transaction binding the contract method 0xbd2f5fdb.
//
// Solidity: function lockAsset(string _indexCode, address _to, address _token, uint256 _lockAmt) returns()
func (_Contracts *ContractsTransactor) LockAsset(opts *bind.TransactOpts, _indexCode string, _to common.Address, _token common.Address, _lockAmt *big.Int) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "lockAsset", _indexCode, _to, _token, _lockAmt)
}

// LockAsset is a paid mutator transaction binding the contract method 0xbd2f5fdb.
//
// Solidity: function lockAsset(string _indexCode, address _to, address _token, uint256 _lockAmt) returns()
func (_Contracts *ContractsSession) LockAsset(_indexCode string, _to common.Address, _token common.Address, _lockAmt *big.Int) (*types.Transaction, error) {
	return _Contracts.Contract.LockAsset(&_Contracts.TransactOpts, _indexCode, _to, _token, _lockAmt)
}

// LockAsset is a paid mutator transaction binding the contract method 0xbd2f5fdb.
//
// Solidity: function lockAsset(string _indexCode, address _to, address _token, uint256 _lockAmt) returns()
func (_Contracts *ContractsTransactorSession) LockAsset(_indexCode string, _to common.Address, _token common.Address, _lockAmt *big.Int) (*types.Transaction, error) {
	return _Contracts.Contract.LockAsset(&_Contracts.TransactOpts, _indexCode, _to, _token, _lockAmt)
}

// Pause is a paid mutator transaction binding the contract method 0x8456cb59.
//
// Solidity: function pause() returns()
func (_Contracts *ContractsTransactor) Pause(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "pause")
}

// Pause is a paid mutator transaction binding the contract method 0x8456cb59.
//
// Solidity: function pause() returns()
func (_Contracts *ContractsSession) Pause() (*types.Transaction, error) {
	return _Contracts.Contract.Pause(&_Contracts.TransactOpts)
}

// Pause is a paid mutator transaction binding the contract method 0x8456cb59.
//
// Solidity: function pause() returns()
func (_Contracts *ContractsTransactorSession) Pause() (*types.Transaction, error) {
	return _Contracts.Contract.Pause(&_Contracts.TransactOpts)
}

// RenounceOwnership is a paid mutator transaction binding the contract method 0x715018a6.
//
// Solidity: function renounceOwnership() returns()
func (_Contracts *ContractsTransactor) RenounceOwnership(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "renounceOwnership")
}

// RenounceOwnership is a paid mutator transaction binding the contract method 0x715018a6.
//
// Solidity: function renounceOwnership() returns()
func (_Contracts *ContractsSession) RenounceOwnership() (*types.Transaction, error) {
	return _Contracts.Contract.RenounceOwnership(&_Contracts.TransactOpts)
}

// RenounceOwnership is a paid mutator transaction binding the contract method 0x715018a6.
//
// Solidity: function renounceOwnership() returns()
func (_Contracts *ContractsTransactorSession) RenounceOwnership() (*types.Transaction, error) {
	return _Contracts.Contract.RenounceOwnership(&_Contracts.TransactOpts)
}

// SetPlatformFeeRate is a paid mutator transaction binding the contract method 0x927fef2e.
//
// Solidity: function setPlatformFeeRate(uint256 _newFeeRate) returns()
func (_Contracts *ContractsTransactor) SetPlatformFeeRate(opts *bind.TransactOpts, _newFeeRate *big.Int) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "setPlatformFeeRate", _newFeeRate)
}

// SetPlatformFeeRate is a paid mutator transaction binding the contract method 0x927fef2e.
//
// Solidity: function setPlatformFeeRate(uint256 _newFeeRate) returns()
func (_Contracts *ContractsSession) SetPlatformFeeRate(_newFeeRate *big.Int) (*types.Transaction, error) {
	return _Contracts.Contract.SetPlatformFeeRate(&_Contracts.TransactOpts, _newFeeRate)
}

// SetPlatformFeeRate is a paid mutator transaction binding the contract method 0x927fef2e.
//
// Solidity: function setPlatformFeeRate(uint256 _newFeeRate) returns()
func (_Contracts *ContractsTransactorSession) SetPlatformFeeRate(_newFeeRate *big.Int) (*types.Transaction, error) {
	return _Contracts.Contract.SetPlatformFeeRate(&_Contracts.TransactOpts, _newFeeRate)
}

// SetPlatformFeeReceiver is a paid mutator transaction binding the contract method 0xe340977a.
//
// Solidity: function setPlatformFeeReceiver(address _newReceiver) returns()
func (_Contracts *ContractsTransactor) SetPlatformFeeReceiver(opts *bind.TransactOpts, _newReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "setPlatformFeeReceiver", _newReceiver)
}

// SetPlatformFeeReceiver is a paid mutator transaction binding the contract method 0xe340977a.
//
// Solidity: function setPlatformFeeReceiver(address _newReceiver) returns()
func (_Contracts *ContractsSession) SetPlatformFeeReceiver(_newReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.SetPlatformFeeReceiver(&_Contracts.TransactOpts, _newReceiver)
}

// SetPlatformFeeReceiver is a paid mutator transaction binding the contract method 0xe340977a.
//
// Solidity: function setPlatformFeeReceiver(address _newReceiver) returns()
func (_Contracts *ContractsTransactorSession) SetPlatformFeeReceiver(_newReceiver common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.SetPlatformFeeReceiver(&_Contracts.TransactOpts, _newReceiver)
}

// SetTokenLockable is a paid mutator transaction binding the contract method 0xb362d3ce.
//
// Solidity: function setTokenLockable(address[] _tokenList, bool[] _flagList) returns()
func (_Contracts *ContractsTransactor) SetTokenLockable(opts *bind.TransactOpts, _tokenList []common.Address, _flagList []bool) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "setTokenLockable", _tokenList, _flagList)
}

// SetTokenLockable is a paid mutator transaction binding the contract method 0xb362d3ce.
//
// Solidity: function setTokenLockable(address[] _tokenList, bool[] _flagList) returns()
func (_Contracts *ContractsSession) SetTokenLockable(_tokenList []common.Address, _flagList []bool) (*types.Transaction, error) {
	return _Contracts.Contract.SetTokenLockable(&_Contracts.TransactOpts, _tokenList, _flagList)
}

// SetTokenLockable is a paid mutator transaction binding the contract method 0xb362d3ce.
//
// Solidity: function setTokenLockable(address[] _tokenList, bool[] _flagList) returns()
func (_Contracts *ContractsTransactorSession) SetTokenLockable(_tokenList []common.Address, _flagList []bool) (*types.Transaction, error) {
	return _Contracts.Contract.SetTokenLockable(&_Contracts.TransactOpts, _tokenList, _flagList)
}

// Settle is a paid mutator transaction binding the contract method 0xbaf312eb.
//
// Solidity: function settle(string _indexCode) returns()
func (_Contracts *ContractsTransactor) Settle(opts *bind.TransactOpts, _indexCode string) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "settle", _indexCode)
}

// Settle is a paid mutator transaction binding the contract method 0xbaf312eb.
//
// Solidity: function settle(string _indexCode) returns()
func (_Contracts *ContractsSession) Settle(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.Settle(&_Contracts.TransactOpts, _indexCode)
}

// Settle is a paid mutator transaction binding the contract method 0xbaf312eb.
//
// Solidity: function settle(string _indexCode) returns()
func (_Contracts *ContractsTransactorSession) Settle(_indexCode string) (*types.Transaction, error) {
	return _Contracts.Contract.Settle(&_Contracts.TransactOpts, _indexCode)
}

// TransferOwnership is a paid mutator transaction binding the contract method 0xf2fde38b.
//
// Solidity: function transferOwnership(address newOwner) returns()
func (_Contracts *ContractsTransactor) TransferOwnership(opts *bind.TransactOpts, newOwner common.Address) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "transferOwnership", newOwner)
}

// TransferOwnership is a paid mutator transaction binding the contract method 0xf2fde38b.
//
// Solidity: function transferOwnership(address newOwner) returns()
func (_Contracts *ContractsSession) TransferOwnership(newOwner common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.TransferOwnership(&_Contracts.TransactOpts, newOwner)
}

// TransferOwnership is a paid mutator transaction binding the contract method 0xf2fde38b.
//
// Solidity: function transferOwnership(address newOwner) returns()
func (_Contracts *ContractsTransactorSession) TransferOwnership(newOwner common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.TransferOwnership(&_Contracts.TransactOpts, newOwner)
}

// Unpause is a paid mutator transaction binding the contract method 0x3f4ba83a.
//
// Solidity: function unpause() returns()
func (_Contracts *ContractsTransactor) Unpause(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "unpause")
}

// Unpause is a paid mutator transaction binding the contract method 0x3f4ba83a.
//
// Solidity: function unpause() returns()
func (_Contracts *ContractsSession) Unpause() (*types.Transaction, error) {
	return _Contracts.Contract.Unpause(&_Contracts.TransactOpts)
}

// Unpause is a paid mutator transaction binding the contract method 0x3f4ba83a.
//
// Solidity: function unpause() returns()
func (_Contracts *ContractsTransactorSession) Unpause() (*types.Transaction, error) {
	return _Contracts.Contract.Unpause(&_Contracts.TransactOpts)
}

// UpgradeTo is a paid mutator transaction binding the contract method 0x3659cfe6.
//
// Solidity: function upgradeTo(address newImplementation) returns()
func (_Contracts *ContractsTransactor) UpgradeTo(opts *bind.TransactOpts, newImplementation common.Address) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "upgradeTo", newImplementation)
}

// UpgradeTo is a paid mutator transaction binding the contract method 0x3659cfe6.
//
// Solidity: function upgradeTo(address newImplementation) returns()
func (_Contracts *ContractsSession) UpgradeTo(newImplementation common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.UpgradeTo(&_Contracts.TransactOpts, newImplementation)
}

// UpgradeTo is a paid mutator transaction binding the contract method 0x3659cfe6.
//
// Solidity: function upgradeTo(address newImplementation) returns()
func (_Contracts *ContractsTransactorSession) UpgradeTo(newImplementation common.Address) (*types.Transaction, error) {
	return _Contracts.Contract.UpgradeTo(&_Contracts.TransactOpts, newImplementation)
}

// UpgradeToAndCall is a paid mutator transaction binding the contract method 0x4f1ef286.
//
// Solidity: function upgradeToAndCall(address newImplementation, bytes data) payable returns()
func (_Contracts *ContractsTransactor) UpgradeToAndCall(opts *bind.TransactOpts, newImplementation common.Address, data []byte) (*types.Transaction, error) {
	return _Contracts.contract.Transact(opts, "upgradeToAndCall", newImplementation, data)
}

// UpgradeToAndCall is a paid mutator transaction binding the contract method 0x4f1ef286.
//
// Solidity: function upgradeToAndCall(address newImplementation, bytes data) payable returns()
func (_Contracts *ContractsSession) UpgradeToAndCall(newImplementation common.Address, data []byte) (*types.Transaction, error) {
	return _Contracts.Contract.UpgradeToAndCall(&_Contracts.TransactOpts, newImplementation, data)
}

// UpgradeToAndCall is a paid mutator transaction binding the contract method 0x4f1ef286.
//
// Solidity: function upgradeToAndCall(address newImplementation, bytes data) payable returns()
func (_Contracts *ContractsTransactorSession) UpgradeToAndCall(newImplementation common.Address, data []byte) (*types.Transaction, error) {
	return _Contracts.Contract.UpgradeToAndCall(&_Contracts.TransactOpts, newImplementation, data)
}

// Receive is a paid mutator transaction binding the contract receive function.
//
// Solidity: receive() payable returns()
func (_Contracts *ContractsTransactor) Receive(opts *bind.TransactOpts) (*types.Transaction, error) {
	return _Contracts.contract.RawTransact(opts, nil) // calldata is disallowed for receive function
}

// Receive is a paid mutator transaction binding the contract receive function.
//
// Solidity: receive() payable returns()
func (_Contracts *ContractsSession) Receive() (*types.Transaction, error) {
	return _Contracts.Contract.Receive(&_Contracts.TransactOpts)
}

// Receive is a paid mutator transaction binding the contract receive function.
//
// Solidity: receive() payable returns()
func (_Contracts *ContractsTransactorSession) Receive() (*types.Transaction, error) {
	return _Contracts.Contract.Receive(&_Contracts.TransactOpts)
}

// ContractsAdminChangedIterator is returned from FilterAdminChanged and is used to iterate over the raw logs and unpacked data for AdminChanged events raised by the Contracts contract.
type ContractsAdminChangedIterator struct {
	Event *ContractsAdminChanged // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsAdminChangedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsAdminChanged)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsAdminChanged)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsAdminChangedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsAdminChangedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsAdminChanged represents a AdminChanged event raised by the Contracts contract.
type ContractsAdminChanged struct {
	PreviousAdmin common.Address
	NewAdmin      common.Address
	Raw           types.Log // Blockchain specific contextual infos
}

// FilterAdminChanged is a free log retrieval operation binding the contract event 0x7e644d79422f17c01e4894b5f4f588d331ebfa28653d42ae832dc59e38c9798f.
//
// Solidity: event AdminChanged(address previousAdmin, address newAdmin)
func (_Contracts *ContractsFilterer) FilterAdminChanged(opts *bind.FilterOpts) (*ContractsAdminChangedIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "AdminChanged")
	if err != nil {
		return nil, err
	}
	return &ContractsAdminChangedIterator{contract: _Contracts.contract, event: "AdminChanged", logs: logs, sub: sub}, nil
}

// WatchAdminChanged is a free log subscription operation binding the contract event 0x7e644d79422f17c01e4894b5f4f588d331ebfa28653d42ae832dc59e38c9798f.
//
// Solidity: event AdminChanged(address previousAdmin, address newAdmin)
func (_Contracts *ContractsFilterer) WatchAdminChanged(opts *bind.WatchOpts, sink chan<- *ContractsAdminChanged) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "AdminChanged")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsAdminChanged)
				if err := _Contracts.contract.UnpackLog(event, "AdminChanged", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseAdminChanged is a log parse operation binding the contract event 0x7e644d79422f17c01e4894b5f4f588d331ebfa28653d42ae832dc59e38c9798f.
//
// Solidity: event AdminChanged(address previousAdmin, address newAdmin)
func (_Contracts *ContractsFilterer) ParseAdminChanged(log types.Log) (*ContractsAdminChanged, error) {
	event := new(ContractsAdminChanged)
	if err := _Contracts.contract.UnpackLog(event, "AdminChanged", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsBeaconUpgradedIterator is returned from FilterBeaconUpgraded and is used to iterate over the raw logs and unpacked data for BeaconUpgraded events raised by the Contracts contract.
type ContractsBeaconUpgradedIterator struct {
	Event *ContractsBeaconUpgraded // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsBeaconUpgradedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsBeaconUpgraded)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsBeaconUpgraded)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsBeaconUpgradedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsBeaconUpgradedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsBeaconUpgraded represents a BeaconUpgraded event raised by the Contracts contract.
type ContractsBeaconUpgraded struct {
	Beacon common.Address
	Raw    types.Log // Blockchain specific contextual infos
}

// FilterBeaconUpgraded is a free log retrieval operation binding the contract event 0x1cf3b03a6cf19fa2baba4df148e9dcabedea7f8a5c07840e207e5c089be95d3e.
//
// Solidity: event BeaconUpgraded(address indexed beacon)
func (_Contracts *ContractsFilterer) FilterBeaconUpgraded(opts *bind.FilterOpts, beacon []common.Address) (*ContractsBeaconUpgradedIterator, error) {

	var beaconRule []interface{}
	for _, beaconItem := range beacon {
		beaconRule = append(beaconRule, beaconItem)
	}

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "BeaconUpgraded", beaconRule)
	if err != nil {
		return nil, err
	}
	return &ContractsBeaconUpgradedIterator{contract: _Contracts.contract, event: "BeaconUpgraded", logs: logs, sub: sub}, nil
}

// WatchBeaconUpgraded is a free log subscription operation binding the contract event 0x1cf3b03a6cf19fa2baba4df148e9dcabedea7f8a5c07840e207e5c089be95d3e.
//
// Solidity: event BeaconUpgraded(address indexed beacon)
func (_Contracts *ContractsFilterer) WatchBeaconUpgraded(opts *bind.WatchOpts, sink chan<- *ContractsBeaconUpgraded, beacon []common.Address) (event.Subscription, error) {

	var beaconRule []interface{}
	for _, beaconItem := range beacon {
		beaconRule = append(beaconRule, beaconItem)
	}

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "BeaconUpgraded", beaconRule)
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsBeaconUpgraded)
				if err := _Contracts.contract.UnpackLog(event, "BeaconUpgraded", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseBeaconUpgraded is a log parse operation binding the contract event 0x1cf3b03a6cf19fa2baba4df148e9dcabedea7f8a5c07840e207e5c089be95d3e.
//
// Solidity: event BeaconUpgraded(address indexed beacon)
func (_Contracts *ContractsFilterer) ParseBeaconUpgraded(log types.Log) (*ContractsBeaconUpgraded, error) {
	event := new(ContractsBeaconUpgraded)
	if err := _Contracts.contract.UnpackLog(event, "BeaconUpgraded", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsCancelLockIterator is returned from FilterCancelLock and is used to iterate over the raw logs and unpacked data for CancelLock events raised by the Contracts contract.
type ContractsCancelLockIterator struct {
	Event *ContractsCancelLock // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsCancelLockIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsCancelLock)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsCancelLock)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsCancelLockIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsCancelLockIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsCancelLock represents a CancelLock event raised by the Contracts contract.
type ContractsCancelLock struct {
	IndexCode string
	Locker    common.Address
	To        common.Address
	Token     common.Address
	Amt       *big.Int
	Raw       types.Log // Blockchain specific contextual infos
}

// FilterCancelLock is a free log retrieval operation binding the contract event 0x4eeb1f2ae11bdcaed9de4c8d761f8aebb3e84ea825b4d5e8be9488473ac2adf8.
//
// Solidity: event CancelLock(string _indexCode, address _locker, address _to, address _token, uint256 _amt)
func (_Contracts *ContractsFilterer) FilterCancelLock(opts *bind.FilterOpts) (*ContractsCancelLockIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "CancelLock")
	if err != nil {
		return nil, err
	}
	return &ContractsCancelLockIterator{contract: _Contracts.contract, event: "CancelLock", logs: logs, sub: sub}, nil
}

// WatchCancelLock is a free log subscription operation binding the contract event 0x4eeb1f2ae11bdcaed9de4c8d761f8aebb3e84ea825b4d5e8be9488473ac2adf8.
//
// Solidity: event CancelLock(string _indexCode, address _locker, address _to, address _token, uint256 _amt)
func (_Contracts *ContractsFilterer) WatchCancelLock(opts *bind.WatchOpts, sink chan<- *ContractsCancelLock) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "CancelLock")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsCancelLock)
				if err := _Contracts.contract.UnpackLog(event, "CancelLock", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseCancelLock is a log parse operation binding the contract event 0x4eeb1f2ae11bdcaed9de4c8d761f8aebb3e84ea825b4d5e8be9488473ac2adf8.
//
// Solidity: event CancelLock(string _indexCode, address _locker, address _to, address _token, uint256 _amt)
func (_Contracts *ContractsFilterer) ParseCancelLock(log types.Log) (*ContractsCancelLock, error) {
	event := new(ContractsCancelLock)
	if err := _Contracts.contract.UnpackLog(event, "CancelLock", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsDelegateSettleIterator is returned from FilterDelegateSettle and is used to iterate over the raw logs and unpacked data for DelegateSettle events raised by the Contracts contract.
type ContractsDelegateSettleIterator struct {
	Event *ContractsDelegateSettle // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsDelegateSettleIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsDelegateSettle)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsDelegateSettle)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsDelegateSettleIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsDelegateSettleIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsDelegateSettle represents a DelegateSettle event raised by the Contracts contract.
type ContractsDelegateSettle struct {
	IndexCode string
	Locker    common.Address
	To        common.Address
	Token     common.Address
	Amt       *big.Int
	Fee       *big.Int
	Raw       types.Log // Blockchain specific contextual infos
}

// FilterDelegateSettle is a free log retrieval operation binding the contract event 0xef24c20701bd3d8d614dc8f1b3d013da4668c971c7ed3f48806505d7a7f2e1c6.
//
// Solidity: event DelegateSettle(string _indexCode, address _locker, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) FilterDelegateSettle(opts *bind.FilterOpts) (*ContractsDelegateSettleIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "DelegateSettle")
	if err != nil {
		return nil, err
	}
	return &ContractsDelegateSettleIterator{contract: _Contracts.contract, event: "DelegateSettle", logs: logs, sub: sub}, nil
}

// WatchDelegateSettle is a free log subscription operation binding the contract event 0xef24c20701bd3d8d614dc8f1b3d013da4668c971c7ed3f48806505d7a7f2e1c6.
//
// Solidity: event DelegateSettle(string _indexCode, address _locker, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) WatchDelegateSettle(opts *bind.WatchOpts, sink chan<- *ContractsDelegateSettle) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "DelegateSettle")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsDelegateSettle)
				if err := _Contracts.contract.UnpackLog(event, "DelegateSettle", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseDelegateSettle is a log parse operation binding the contract event 0xef24c20701bd3d8d614dc8f1b3d013da4668c971c7ed3f48806505d7a7f2e1c6.
//
// Solidity: event DelegateSettle(string _indexCode, address _locker, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) ParseDelegateSettle(log types.Log) (*ContractsDelegateSettle, error) {
	event := new(ContractsDelegateSettle)
	if err := _Contracts.contract.UnpackLog(event, "DelegateSettle", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsInitializedIterator is returned from FilterInitialized and is used to iterate over the raw logs and unpacked data for Initialized events raised by the Contracts contract.
type ContractsInitializedIterator struct {
	Event *ContractsInitialized // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsInitializedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsInitialized)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsInitialized)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsInitializedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsInitializedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsInitialized represents a Initialized event raised by the Contracts contract.
type ContractsInitialized struct {
	Version uint8
	Raw     types.Log // Blockchain specific contextual infos
}

// FilterInitialized is a free log retrieval operation binding the contract event 0x7f26b83ff96e1f2b6a682f133852f6798a09c465da95921460cefb3847402498.
//
// Solidity: event Initialized(uint8 version)
func (_Contracts *ContractsFilterer) FilterInitialized(opts *bind.FilterOpts) (*ContractsInitializedIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "Initialized")
	if err != nil {
		return nil, err
	}
	return &ContractsInitializedIterator{contract: _Contracts.contract, event: "Initialized", logs: logs, sub: sub}, nil
}

// WatchInitialized is a free log subscription operation binding the contract event 0x7f26b83ff96e1f2b6a682f133852f6798a09c465da95921460cefb3847402498.
//
// Solidity: event Initialized(uint8 version)
func (_Contracts *ContractsFilterer) WatchInitialized(opts *bind.WatchOpts, sink chan<- *ContractsInitialized) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "Initialized")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsInitialized)
				if err := _Contracts.contract.UnpackLog(event, "Initialized", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseInitialized is a log parse operation binding the contract event 0x7f26b83ff96e1f2b6a682f133852f6798a09c465da95921460cefb3847402498.
//
// Solidity: event Initialized(uint8 version)
func (_Contracts *ContractsFilterer) ParseInitialized(log types.Log) (*ContractsInitialized, error) {
	event := new(ContractsInitialized)
	if err := _Contracts.contract.UnpackLog(event, "Initialized", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsLockAssetIterator is returned from FilterLockAsset and is used to iterate over the raw logs and unpacked data for LockAsset events raised by the Contracts contract.
type ContractsLockAssetIterator struct {
	Event *ContractsLockAsset // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsLockAssetIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsLockAsset)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsLockAsset)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsLockAssetIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsLockAssetIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsLockAsset represents a LockAsset event raised by the Contracts contract.
type ContractsLockAsset struct {
	IndexCode string
	User      common.Address
	To        common.Address
	Token     common.Address
	LockAmt   *big.Int
	Raw       types.Log // Blockchain specific contextual infos
}

// FilterLockAsset is a free log retrieval operation binding the contract event 0xd5e6b6f9a1e2229e64785d0dab3df803fbc838f421f1cbbb52f8aa32b9eae299.
//
// Solidity: event LockAsset(string _indexCode, address _user, address _to, address _token, uint256 _lockAmt)
func (_Contracts *ContractsFilterer) FilterLockAsset(opts *bind.FilterOpts) (*ContractsLockAssetIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "LockAsset")
	if err != nil {
		return nil, err
	}
	return &ContractsLockAssetIterator{contract: _Contracts.contract, event: "LockAsset", logs: logs, sub: sub}, nil
}

// WatchLockAsset is a free log subscription operation binding the contract event 0xd5e6b6f9a1e2229e64785d0dab3df803fbc838f421f1cbbb52f8aa32b9eae299.
//
// Solidity: event LockAsset(string _indexCode, address _user, address _to, address _token, uint256 _lockAmt)
func (_Contracts *ContractsFilterer) WatchLockAsset(opts *bind.WatchOpts, sink chan<- *ContractsLockAsset) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "LockAsset")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsLockAsset)
				if err := _Contracts.contract.UnpackLog(event, "LockAsset", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseLockAsset is a log parse operation binding the contract event 0xd5e6b6f9a1e2229e64785d0dab3df803fbc838f421f1cbbb52f8aa32b9eae299.
//
// Solidity: event LockAsset(string _indexCode, address _user, address _to, address _token, uint256 _lockAmt)
func (_Contracts *ContractsFilterer) ParseLockAsset(log types.Log) (*ContractsLockAsset, error) {
	event := new(ContractsLockAsset)
	if err := _Contracts.contract.UnpackLog(event, "LockAsset", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsOwnershipTransferredIterator is returned from FilterOwnershipTransferred and is used to iterate over the raw logs and unpacked data for OwnershipTransferred events raised by the Contracts contract.
type ContractsOwnershipTransferredIterator struct {
	Event *ContractsOwnershipTransferred // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsOwnershipTransferredIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsOwnershipTransferred)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsOwnershipTransferred)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsOwnershipTransferredIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsOwnershipTransferredIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsOwnershipTransferred represents a OwnershipTransferred event raised by the Contracts contract.
type ContractsOwnershipTransferred struct {
	PreviousOwner common.Address
	NewOwner      common.Address
	Raw           types.Log // Blockchain specific contextual infos
}

// FilterOwnershipTransferred is a free log retrieval operation binding the contract event 0x8be0079c531659141344cd1fd0a4f28419497f9722a3daafe3b4186f6b6457e0.
//
// Solidity: event OwnershipTransferred(address indexed previousOwner, address indexed newOwner)
func (_Contracts *ContractsFilterer) FilterOwnershipTransferred(opts *bind.FilterOpts, previousOwner []common.Address, newOwner []common.Address) (*ContractsOwnershipTransferredIterator, error) {

	var previousOwnerRule []interface{}
	for _, previousOwnerItem := range previousOwner {
		previousOwnerRule = append(previousOwnerRule, previousOwnerItem)
	}
	var newOwnerRule []interface{}
	for _, newOwnerItem := range newOwner {
		newOwnerRule = append(newOwnerRule, newOwnerItem)
	}

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "OwnershipTransferred", previousOwnerRule, newOwnerRule)
	if err != nil {
		return nil, err
	}
	return &ContractsOwnershipTransferredIterator{contract: _Contracts.contract, event: "OwnershipTransferred", logs: logs, sub: sub}, nil
}

// WatchOwnershipTransferred is a free log subscription operation binding the contract event 0x8be0079c531659141344cd1fd0a4f28419497f9722a3daafe3b4186f6b6457e0.
//
// Solidity: event OwnershipTransferred(address indexed previousOwner, address indexed newOwner)
func (_Contracts *ContractsFilterer) WatchOwnershipTransferred(opts *bind.WatchOpts, sink chan<- *ContractsOwnershipTransferred, previousOwner []common.Address, newOwner []common.Address) (event.Subscription, error) {

	var previousOwnerRule []interface{}
	for _, previousOwnerItem := range previousOwner {
		previousOwnerRule = append(previousOwnerRule, previousOwnerItem)
	}
	var newOwnerRule []interface{}
	for _, newOwnerItem := range newOwner {
		newOwnerRule = append(newOwnerRule, newOwnerItem)
	}

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "OwnershipTransferred", previousOwnerRule, newOwnerRule)
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsOwnershipTransferred)
				if err := _Contracts.contract.UnpackLog(event, "OwnershipTransferred", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseOwnershipTransferred is a log parse operation binding the contract event 0x8be0079c531659141344cd1fd0a4f28419497f9722a3daafe3b4186f6b6457e0.
//
// Solidity: event OwnershipTransferred(address indexed previousOwner, address indexed newOwner)
func (_Contracts *ContractsFilterer) ParseOwnershipTransferred(log types.Log) (*ContractsOwnershipTransferred, error) {
	event := new(ContractsOwnershipTransferred)
	if err := _Contracts.contract.UnpackLog(event, "OwnershipTransferred", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsPausedIterator is returned from FilterPaused and is used to iterate over the raw logs and unpacked data for Paused events raised by the Contracts contract.
type ContractsPausedIterator struct {
	Event *ContractsPaused // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsPausedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsPaused)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsPaused)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsPausedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsPausedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsPaused represents a Paused event raised by the Contracts contract.
type ContractsPaused struct {
	Account common.Address
	Raw     types.Log // Blockchain specific contextual infos
}

// FilterPaused is a free log retrieval operation binding the contract event 0x62e78cea01bee320cd4e420270b5ea74000d11b0c9f74754ebdbfc544b05a258.
//
// Solidity: event Paused(address account)
func (_Contracts *ContractsFilterer) FilterPaused(opts *bind.FilterOpts) (*ContractsPausedIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "Paused")
	if err != nil {
		return nil, err
	}
	return &ContractsPausedIterator{contract: _Contracts.contract, event: "Paused", logs: logs, sub: sub}, nil
}

// WatchPaused is a free log subscription operation binding the contract event 0x62e78cea01bee320cd4e420270b5ea74000d11b0c9f74754ebdbfc544b05a258.
//
// Solidity: event Paused(address account)
func (_Contracts *ContractsFilterer) WatchPaused(opts *bind.WatchOpts, sink chan<- *ContractsPaused) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "Paused")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsPaused)
				if err := _Contracts.contract.UnpackLog(event, "Paused", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParsePaused is a log parse operation binding the contract event 0x62e78cea01bee320cd4e420270b5ea74000d11b0c9f74754ebdbfc544b05a258.
//
// Solidity: event Paused(address account)
func (_Contracts *ContractsFilterer) ParsePaused(log types.Log) (*ContractsPaused, error) {
	event := new(ContractsPaused)
	if err := _Contracts.contract.UnpackLog(event, "Paused", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsSetPlatformFeeRateIterator is returned from FilterSetPlatformFeeRate and is used to iterate over the raw logs and unpacked data for SetPlatformFeeRate events raised by the Contracts contract.
type ContractsSetPlatformFeeRateIterator struct {
	Event *ContractsSetPlatformFeeRate // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsSetPlatformFeeRateIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsSetPlatformFeeRate)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsSetPlatformFeeRate)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsSetPlatformFeeRateIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsSetPlatformFeeRateIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsSetPlatformFeeRate represents a SetPlatformFeeRate event raised by the Contracts contract.
type ContractsSetPlatformFeeRate struct {
	OldFeeRate *big.Int
	NewFeeRate *big.Int
	Raw        types.Log // Blockchain specific contextual infos
}

// FilterSetPlatformFeeRate is a free log retrieval operation binding the contract event 0xa65bd7f153da9f047c0301c17e137220280385cd4861edc31b2d75d89fdca5e7.
//
// Solidity: event SetPlatformFeeRate(uint256 _oldFeeRate, uint256 _newFeeRate)
func (_Contracts *ContractsFilterer) FilterSetPlatformFeeRate(opts *bind.FilterOpts) (*ContractsSetPlatformFeeRateIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "SetPlatformFeeRate")
	if err != nil {
		return nil, err
	}
	return &ContractsSetPlatformFeeRateIterator{contract: _Contracts.contract, event: "SetPlatformFeeRate", logs: logs, sub: sub}, nil
}

// WatchSetPlatformFeeRate is a free log subscription operation binding the contract event 0xa65bd7f153da9f047c0301c17e137220280385cd4861edc31b2d75d89fdca5e7.
//
// Solidity: event SetPlatformFeeRate(uint256 _oldFeeRate, uint256 _newFeeRate)
func (_Contracts *ContractsFilterer) WatchSetPlatformFeeRate(opts *bind.WatchOpts, sink chan<- *ContractsSetPlatformFeeRate) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "SetPlatformFeeRate")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsSetPlatformFeeRate)
				if err := _Contracts.contract.UnpackLog(event, "SetPlatformFeeRate", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseSetPlatformFeeRate is a log parse operation binding the contract event 0xa65bd7f153da9f047c0301c17e137220280385cd4861edc31b2d75d89fdca5e7.
//
// Solidity: event SetPlatformFeeRate(uint256 _oldFeeRate, uint256 _newFeeRate)
func (_Contracts *ContractsFilterer) ParseSetPlatformFeeRate(log types.Log) (*ContractsSetPlatformFeeRate, error) {
	event := new(ContractsSetPlatformFeeRate)
	if err := _Contracts.contract.UnpackLog(event, "SetPlatformFeeRate", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsSetPlatformFeeReceiverIterator is returned from FilterSetPlatformFeeReceiver and is used to iterate over the raw logs and unpacked data for SetPlatformFeeReceiver events raised by the Contracts contract.
type ContractsSetPlatformFeeReceiverIterator struct {
	Event *ContractsSetPlatformFeeReceiver // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsSetPlatformFeeReceiverIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsSetPlatformFeeReceiver)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsSetPlatformFeeReceiver)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsSetPlatformFeeReceiverIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsSetPlatformFeeReceiverIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsSetPlatformFeeReceiver represents a SetPlatformFeeReceiver event raised by the Contracts contract.
type ContractsSetPlatformFeeReceiver struct {
	OldReceiver common.Address
	NewReceiver common.Address
	Raw         types.Log // Blockchain specific contextual infos
}

// FilterSetPlatformFeeReceiver is a free log retrieval operation binding the contract event 0xe0c4ab7d68178432e816d745a40305da1efba45a47b4d7dfe6fe5e1ef991405f.
//
// Solidity: event SetPlatformFeeReceiver(address _oldReceiver, address _newReceiver)
func (_Contracts *ContractsFilterer) FilterSetPlatformFeeReceiver(opts *bind.FilterOpts) (*ContractsSetPlatformFeeReceiverIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "SetPlatformFeeReceiver")
	if err != nil {
		return nil, err
	}
	return &ContractsSetPlatformFeeReceiverIterator{contract: _Contracts.contract, event: "SetPlatformFeeReceiver", logs: logs, sub: sub}, nil
}

// WatchSetPlatformFeeReceiver is a free log subscription operation binding the contract event 0xe0c4ab7d68178432e816d745a40305da1efba45a47b4d7dfe6fe5e1ef991405f.
//
// Solidity: event SetPlatformFeeReceiver(address _oldReceiver, address _newReceiver)
func (_Contracts *ContractsFilterer) WatchSetPlatformFeeReceiver(opts *bind.WatchOpts, sink chan<- *ContractsSetPlatformFeeReceiver) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "SetPlatformFeeReceiver")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsSetPlatformFeeReceiver)
				if err := _Contracts.contract.UnpackLog(event, "SetPlatformFeeReceiver", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseSetPlatformFeeReceiver is a log parse operation binding the contract event 0xe0c4ab7d68178432e816d745a40305da1efba45a47b4d7dfe6fe5e1ef991405f.
//
// Solidity: event SetPlatformFeeReceiver(address _oldReceiver, address _newReceiver)
func (_Contracts *ContractsFilterer) ParseSetPlatformFeeReceiver(log types.Log) (*ContractsSetPlatformFeeReceiver, error) {
	event := new(ContractsSetPlatformFeeReceiver)
	if err := _Contracts.contract.UnpackLog(event, "SetPlatformFeeReceiver", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsSetTokenLockableIterator is returned from FilterSetTokenLockable and is used to iterate over the raw logs and unpacked data for SetTokenLockable events raised by the Contracts contract.
type ContractsSetTokenLockableIterator struct {
	Event *ContractsSetTokenLockable // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsSetTokenLockableIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsSetTokenLockable)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsSetTokenLockable)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsSetTokenLockableIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsSetTokenLockableIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsSetTokenLockable represents a SetTokenLockable event raised by the Contracts contract.
type ContractsSetTokenLockable struct {
	TokenList []common.Address
	FlagList  []bool
	Raw       types.Log // Blockchain specific contextual infos
}

// FilterSetTokenLockable is a free log retrieval operation binding the contract event 0xa84319f26bafb5bbf71c9a68bd8da164a6bc9cd2596adb54df752f7717faa959.
//
// Solidity: event SetTokenLockable(address[] _tokenList, bool[] _flagList)
func (_Contracts *ContractsFilterer) FilterSetTokenLockable(opts *bind.FilterOpts) (*ContractsSetTokenLockableIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "SetTokenLockable")
	if err != nil {
		return nil, err
	}
	return &ContractsSetTokenLockableIterator{contract: _Contracts.contract, event: "SetTokenLockable", logs: logs, sub: sub}, nil
}

// WatchSetTokenLockable is a free log subscription operation binding the contract event 0xa84319f26bafb5bbf71c9a68bd8da164a6bc9cd2596adb54df752f7717faa959.
//
// Solidity: event SetTokenLockable(address[] _tokenList, bool[] _flagList)
func (_Contracts *ContractsFilterer) WatchSetTokenLockable(opts *bind.WatchOpts, sink chan<- *ContractsSetTokenLockable) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "SetTokenLockable")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsSetTokenLockable)
				if err := _Contracts.contract.UnpackLog(event, "SetTokenLockable", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseSetTokenLockable is a log parse operation binding the contract event 0xa84319f26bafb5bbf71c9a68bd8da164a6bc9cd2596adb54df752f7717faa959.
//
// Solidity: event SetTokenLockable(address[] _tokenList, bool[] _flagList)
func (_Contracts *ContractsFilterer) ParseSetTokenLockable(log types.Log) (*ContractsSetTokenLockable, error) {
	event := new(ContractsSetTokenLockable)
	if err := _Contracts.contract.UnpackLog(event, "SetTokenLockable", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsSettleIterator is returned from FilterSettle and is used to iterate over the raw logs and unpacked data for Settle events raised by the Contracts contract.
type ContractsSettleIterator struct {
	Event *ContractsSettle // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsSettleIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsSettle)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsSettle)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsSettleIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsSettleIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsSettle represents a Settle event raised by the Contracts contract.
type ContractsSettle struct {
	IndexCode string
	To        common.Address
	Token     common.Address
	Amt       *big.Int
	Fee       *big.Int
	Raw       types.Log // Blockchain specific contextual infos
}

// FilterSettle is a free log retrieval operation binding the contract event 0x7fdfc6dd6937d5104e8e5d1ac6673390e47ca95a6cc93bb28fad9c0a7a85e868.
//
// Solidity: event Settle(string _indexCode, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) FilterSettle(opts *bind.FilterOpts) (*ContractsSettleIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "Settle")
	if err != nil {
		return nil, err
	}
	return &ContractsSettleIterator{contract: _Contracts.contract, event: "Settle", logs: logs, sub: sub}, nil
}

// WatchSettle is a free log subscription operation binding the contract event 0x7fdfc6dd6937d5104e8e5d1ac6673390e47ca95a6cc93bb28fad9c0a7a85e868.
//
// Solidity: event Settle(string _indexCode, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) WatchSettle(opts *bind.WatchOpts, sink chan<- *ContractsSettle) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "Settle")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsSettle)
				if err := _Contracts.contract.UnpackLog(event, "Settle", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseSettle is a log parse operation binding the contract event 0x7fdfc6dd6937d5104e8e5d1ac6673390e47ca95a6cc93bb28fad9c0a7a85e868.
//
// Solidity: event Settle(string _indexCode, address _to, address _token, uint256 _amt, uint256 _fee)
func (_Contracts *ContractsFilterer) ParseSettle(log types.Log) (*ContractsSettle, error) {
	event := new(ContractsSettle)
	if err := _Contracts.contract.UnpackLog(event, "Settle", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsUnpausedIterator is returned from FilterUnpaused and is used to iterate over the raw logs and unpacked data for Unpaused events raised by the Contracts contract.
type ContractsUnpausedIterator struct {
	Event *ContractsUnpaused // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsUnpausedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsUnpaused)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsUnpaused)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsUnpausedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsUnpausedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsUnpaused represents a Unpaused event raised by the Contracts contract.
type ContractsUnpaused struct {
	Account common.Address
	Raw     types.Log // Blockchain specific contextual infos
}

// FilterUnpaused is a free log retrieval operation binding the contract event 0x5db9ee0a495bf2e6ff9c91a7834c1ba4fdd244a5e8aa4e537bd38aeae4b073aa.
//
// Solidity: event Unpaused(address account)
func (_Contracts *ContractsFilterer) FilterUnpaused(opts *bind.FilterOpts) (*ContractsUnpausedIterator, error) {

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "Unpaused")
	if err != nil {
		return nil, err
	}
	return &ContractsUnpausedIterator{contract: _Contracts.contract, event: "Unpaused", logs: logs, sub: sub}, nil
}

// WatchUnpaused is a free log subscription operation binding the contract event 0x5db9ee0a495bf2e6ff9c91a7834c1ba4fdd244a5e8aa4e537bd38aeae4b073aa.
//
// Solidity: event Unpaused(address account)
func (_Contracts *ContractsFilterer) WatchUnpaused(opts *bind.WatchOpts, sink chan<- *ContractsUnpaused) (event.Subscription, error) {

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "Unpaused")
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsUnpaused)
				if err := _Contracts.contract.UnpackLog(event, "Unpaused", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseUnpaused is a log parse operation binding the contract event 0x5db9ee0a495bf2e6ff9c91a7834c1ba4fdd244a5e8aa4e537bd38aeae4b073aa.
//
// Solidity: event Unpaused(address account)
func (_Contracts *ContractsFilterer) ParseUnpaused(log types.Log) (*ContractsUnpaused, error) {
	event := new(ContractsUnpaused)
	if err := _Contracts.contract.UnpackLog(event, "Unpaused", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}

// ContractsUpgradedIterator is returned from FilterUpgraded and is used to iterate over the raw logs and unpacked data for Upgraded events raised by the Contracts contract.
type ContractsUpgradedIterator struct {
	Event *ContractsUpgraded // Event containing the contract specifics and raw log

	contract *bind.BoundContract // Generic contract to use for unpacking event data
	event    string              // Event name to use for unpacking event data

	logs chan types.Log        // Log channel receiving the found contract events
	sub  ethereum.Subscription // Subscription for errors, completion and termination
	done bool                  // Whether the subscription completed delivering logs
	fail error                 // Occurred error to stop iteration
}

// Next advances the iterator to the subsequent event, returning whether there
// are any more events found. In case of a retrieval or parsing error, false is
// returned and Error() can be queried for the exact failure.
func (it *ContractsUpgradedIterator) Next() bool {
	// If the iterator failed, stop iterating
	if it.fail != nil {
		return false
	}
	// If the iterator completed, deliver directly whatever's available
	if it.done {
		select {
		case log := <-it.logs:
			it.Event = new(ContractsUpgraded)
			if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
				it.fail = err
				return false
			}
			it.Event.Raw = log
			return true

		default:
			return false
		}
	}
	// Iterator still in progress, wait for either a data or an error event
	select {
	case log := <-it.logs:
		it.Event = new(ContractsUpgraded)
		if err := it.contract.UnpackLog(it.Event, it.event, log); err != nil {
			it.fail = err
			return false
		}
		it.Event.Raw = log
		return true

	case err := <-it.sub.Err():
		it.done = true
		it.fail = err
		return it.Next()
	}
}

// Error returns any retrieval or parsing error occurred during filtering.
func (it *ContractsUpgradedIterator) Error() error {
	return it.fail
}

// Close terminates the iteration process, releasing any pending underlying
// resources.
func (it *ContractsUpgradedIterator) Close() error {
	it.sub.Unsubscribe()
	return nil
}

// ContractsUpgraded represents a Upgraded event raised by the Contracts contract.
type ContractsUpgraded struct {
	Implementation common.Address
	Raw            types.Log // Blockchain specific contextual infos
}

// FilterUpgraded is a free log retrieval operation binding the contract event 0xbc7cd75a20ee27fd9adebab32041f755214dbc6bffa90cc0225b39da2e5c2d3b.
//
// Solidity: event Upgraded(address indexed implementation)
func (_Contracts *ContractsFilterer) FilterUpgraded(opts *bind.FilterOpts, implementation []common.Address) (*ContractsUpgradedIterator, error) {

	var implementationRule []interface{}
	for _, implementationItem := range implementation {
		implementationRule = append(implementationRule, implementationItem)
	}

	logs, sub, err := _Contracts.contract.FilterLogs(opts, "Upgraded", implementationRule)
	if err != nil {
		return nil, err
	}
	return &ContractsUpgradedIterator{contract: _Contracts.contract, event: "Upgraded", logs: logs, sub: sub}, nil
}

// WatchUpgraded is a free log subscription operation binding the contract event 0xbc7cd75a20ee27fd9adebab32041f755214dbc6bffa90cc0225b39da2e5c2d3b.
//
// Solidity: event Upgraded(address indexed implementation)
func (_Contracts *ContractsFilterer) WatchUpgraded(opts *bind.WatchOpts, sink chan<- *ContractsUpgraded, implementation []common.Address) (event.Subscription, error) {

	var implementationRule []interface{}
	for _, implementationItem := range implementation {
		implementationRule = append(implementationRule, implementationItem)
	}

	logs, sub, err := _Contracts.contract.WatchLogs(opts, "Upgraded", implementationRule)
	if err != nil {
		return nil, err
	}
	return event.NewSubscription(func(quit <-chan struct{}) error {
		defer sub.Unsubscribe()
		for {
			select {
			case log := <-logs:
				// New log arrived, parse the event and forward to the user
				event := new(ContractsUpgraded)
				if err := _Contracts.contract.UnpackLog(event, "Upgraded", log); err != nil {
					return err
				}
				event.Raw = log

				select {
				case sink <- event:
				case err := <-sub.Err():
					return err
				case <-quit:
					return nil
				}
			case err := <-sub.Err():
				return err
			case <-quit:
				return nil
			}
		}
	}), nil
}

// ParseUpgraded is a log parse operation binding the contract event 0xbc7cd75a20ee27fd9adebab32041f755214dbc6bffa90cc0225b39da2e5c2d3b.
//
// Solidity: event Upgraded(address indexed implementation)
func (_Contracts *ContractsFilterer) ParseUpgraded(log types.Log) (*ContractsUpgraded, error) {
	event := new(ContractsUpgraded)
	if err := _Contracts.contract.UnpackLog(event, "Upgraded", log); err != nil {
		return nil, err
	}
	event.Raw = log
	return event, nil
}
