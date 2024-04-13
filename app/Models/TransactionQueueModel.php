<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Constants\ErrorCodes;


class TransactionQueueModel extends Model
{
    use HasFactory;
	protected $table = 'transaction_queue';
	public function insert($web3_hash, $transaction_type)
	{
		try {
			$this->index_node = $web3_hash;
			$this->transaction_type = $transaction_type;
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

}
