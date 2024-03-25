<?php

namespace App\Http\Services;

use App\Constants\ErrorCodes;
use Illuminate\Support\Facades\Log;

class Service 
{
	protected $res;

	function __construct() {
		$code = ErrorCodes::ERROR_CODE_SUCCESS;
		$this->res = array('code' => $code, 'message' => '', 'data' => array());
	}

	protected function error_response($open_id, $error_code, $error_message)
	{
		$this->res['code'] = $error_code;	
		$this->res['message'] = $error_message;	
		Log::error("$open_id:" . $error_message);
		return $this->res;
	}
}
