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
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 12;
	const ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT = 13;
	const ERROR_CODE_TASK_IS_IN_PROGRESS = 14;
	const ERROR_CODE_TWITTER_AUTH_URL_FAULED = 15;
	const ERROR_CODE_TWITTER_USER_FAULED = 15;
	
	const ERROR_CODE_DUPLICATE_ENTRY = 1062;
}

class ErrorDescs
{
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'input param error!';
	const ERROR_CODE_DB_ERROR = 'db error!';
	const ERROR_CODE_VERIFICATION_CODE_ERROR = 'The captcha is invalid or has expired.';
	const ERROR_CODE_TASK_APPLICATION_IS_MISSING = 'The task application does not match.!';
	const ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS = 'Task application is not yours, you cann not cancel!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT = 'Current task application status can not edit!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW = 'Current task application status can not review!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR = 'Input param status error, only panding,accept,declined are allowed.';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD = 'Current task application status can not upload!';
	const ERROR_CODE_PROJECT_IS_NOT_YOURS = 'Project is not yours!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH = 'Current task application status can not finish!';
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 'File is not exist!';
	const ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT = 'The task does not belong to the project.';
	const ERROR_CODE_TASK_IS_IN_PROGRESS = 'Task is in progress, can not close the task!';
	const ERROR_CODE_TWITTER_AUTH_URL_FAULED = 'Get twitter auth url failed';
	const ERROR_CODE_TWITTER_USER_FAULED = 'Get twitter use data failed';
}

