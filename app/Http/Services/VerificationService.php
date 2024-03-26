<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\VerificationModel;

class VerificationService extends Service 
{
    public function code($email)
	{
		$verification_model = new VerificationModel;
		$code  = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
		if (!$verification_model->insert($email, $code))
		{
			return $this->error_response($email, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		$headers = array('From' => env('MAIL_FROM_ADDRESS'));
		mail($email, 'Verification Code', "$code", $headers);
		return $this->res;
	}	

	public function get_code($email)
	{
		$verification_model = new VerificationModel;
		$data = $verification_model->get($email);	
		if (empty($data))
		{
			return 0;
		}
		return $data['code'];
	}

}
