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
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT = 6;
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW = 7;
	const ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR = 8;
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD = 9;
	const ERROR_CODE_PROJECT_IS_NOT_YOURS = 10;
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH = 11;
}

class ErrorDescs
{
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'input param error!';
	const ERROR_CODE_DB_ERROR = 'db error!';
	const ERROR_CODE_VERIFICATION_CODE_ERROR = 'verification code error!';
	const ERROR_CODE_TASK_APPLICATION_IS_MISSING = 'task application is missing!';
	const ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS = 'task application is not yours, you cann not cancel!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT = 'current task application status can not edit!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW = 'current task application status can not review!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR = 'input param status error, only panding,accept,declined are allowed.';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD = 'current task application status can not upload!';
	const ERROR_CODE_PROJECT_IS_NOT_YOURS = 'project is not yours!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH = 'current task application status can not finish!';
}

