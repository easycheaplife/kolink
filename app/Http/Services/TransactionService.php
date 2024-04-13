<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\TransactionModel;


class TransactionService extends Service 
{
    public function transation_hash()
	{
		$this->res['data']['web3_hash'] = Str::uuid()->toString();
		return $this->res;
	}	

	public function transation_list($address, $page, $size)
	{
		$transation_model = new TransactionModel;
		$this->res['data']['list'] = $transation_model->list($address, $page, $size);
		$this->res['data']['count'] = $transation_model->count($address);
		return $this->res;
	}

}
