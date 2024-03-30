<?php

// app/Constants/ErrorCodes.php

namespace App\Constants;

class ErrorCodes
{
	const ERROR_CODE_SUCCESS = 0;
	const ERROR_CODE_INPUT_PARAM_ERROR = 1;
	const ERROR_CODE_DB_ERROR = 2;
	const ERROR_CODE_VERIFICATION_CODE_ERROR = 3;
	const ERROR_CODE_TASK_APPLICATION_IS_MISSING = 4;
	const ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS = 5;
}

class ErrorDescs
{
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'input param error!';
	const ERROR_CODE_DB_ERROR = 'db error!';
	const ERROR_CODE_VERIFICATION_CODE_ERROR = 'verification code error!';
	const ERROR_CODE_TASK_APPLICATION_IS_MISSING = 'task application is missing!';
	const ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS = 'task application is not yours, you cann not cancel!';

}

