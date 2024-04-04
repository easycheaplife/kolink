<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class VerificationModel extends Model
{
    use HasFactory;

	protected $table = 'verification_code';

	public function insert($email, $code)
	{
		try {
			$this->email = $email;
			$this->code = $code;
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

	public function get($email)
	{
		return $this->select('code')
			->where('email', $email)
			->orderByDesc('created_at')
			->first();	
	}
}
