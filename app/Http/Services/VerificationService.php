<?php

namespace App\Http\Services;

use App\Constants\ErrorCodes;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;

class VerificationService extends Service 
{
    public function code($email)
	{
		return $this->res;
	}	

}
