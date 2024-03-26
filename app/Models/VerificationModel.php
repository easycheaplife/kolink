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
			$this->save();
		}
		catch (UniqueConstraintViolationException $e)
		{
			Log::info($e->getMessage());
		}
	}

}
