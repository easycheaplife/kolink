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

	public function unsend_code()
	{
		return $this->select('id', 'email', 'code', 'try_times')
			->where('send_flag', 0)
			->where('try_times', '<', config('config.mail_try_times'))
			->orderBy('created_at', 'asc')
			->first();	
	}

	public function update_send_flag($id)
	{
		return $this->where('id', $id)
			->update(['send_flag' => 1]);
	}

	public function inc_try_times($id)
	{
		$verification_code = $this->find($id);
		if (empty($verification_code))
		{
			return;
		}
		$verification_code->try_times += 1;
		return $verification_code->save();
	}
}
