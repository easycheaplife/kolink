<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class EtherscanModel extends Model
{
    use HasFactory;

	protected $table = 'etherscan';

	public $timestamps = false;

	public function insert($address, $created_at, $token_count, $nft_count)
	{
		try {
			$this->address = $address;
			$this->created_at = $created_at;
			$this->token_count = $token_count;
			$this->nft_count = $nft_count;
			$this->updated_at = time();
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				$this->update_count($address, $token_count, $nft_count);
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function update_count($address, $token_count, $nft_count)
	{
		return $this->where('address', $address)->update([
			'updated_at' => time(), 
			'token_count' => $token_count, 
			'nft_count' => $nft_count 
		]);	
	}

	public function get($address)
	{
		return $this->where('address', $address)
			->first();
	}

	public function get_column_count_max($column_name)
	{
		return $this->select($column_name)->max($column_name);
	}

	public function get_column_count_min($column_name)
	{
		return $this->select($column_name)->min($column_name);
	}

}
