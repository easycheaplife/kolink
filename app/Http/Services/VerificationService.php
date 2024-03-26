<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Models\VerificationModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class VerificationService extends Service 
{
    public function code($email)
	{
		$verification_model = new VerificationModel;
		$code  = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
		$headers = array('From' => env('MAIL_FROM_ADDRESS'));
		mail($email, 'Verification Code', "$code", $headers);
		return $this->res;
	}	

}
