<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

	public function get($email)
	{
		return $this->select('code')
			->where('email', $email)
			->first();	
	}
}
