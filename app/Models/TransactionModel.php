<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

	protected $table = 'transaction';
	public function list($address, $page, $size)
	{
		return $this->select('index_code','transaction_type', 'token', 'from_address','to_address','amt','fee','transaction_time')
			->where('from_address', $address)
			->Orwhere('to_address', $address)
			->orderByDesc('transaction_time')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($address)
	{
		return $this->select('id')
			->where('from_address', $address)
			->Orwhere('to_address', $address)
			->count();
	}

}
