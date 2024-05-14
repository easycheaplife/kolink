<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\TransactionQueueModel;


class TransactionQueueService extends Service 
{
	public function push($web3_hash, $transaction_type, $blockchain_id)
	{
		if ('' == $web3_hash)
		{
			return;
		}

		if (0 == $blockchain_id)
		{
			return;
		}
		$transation_queue_model = new TransactionQueueModel;
		if (!$transation_queue_model->insert($web3_hash, $transaction_type, $blockchain_id))
		{
			return $this->error_response($web3_hash, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

}
