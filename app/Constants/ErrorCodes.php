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
	const ERROR_CODE_TWITTER_AUTH_URL_FAILED = 15;
	const ERROR_CODE_TWITTER_USER_FAILED = 16;
	const ERROR_CODE_ETHERSCAN_API_FAILED = 17;
	const ERROR_CODE_TASK_IS_NOT_EXIST = 18;
	const ERROR_CODE_KOL_IS_NOT_EXIST = 19;
	const ERROR_CODE_TASK_APPLICATION_REACH_MAX_KOL_UPLIMIT = 20;
	const ERROR_CODE_TASK_APPLICATION_KOL_FOLLOWERS_IS_NOT_ENOUGH = 21;
	const ERROR_CODE_TASK_APPLICATION_KOL_ENGAGEMENT_IS_NOT_ENOUGH = 22;
	const ERROR_CODE_TASK_APPLICATION_KOL_SCORE_IS_NOT_ENOUGH = 23;
	const ERROR_CODE_TASK_APPLICATION_DDL_TIMEOUT = 24;
	const ERROR_CODE_TASK_UPLOAD_DDL_TIMEOUT = 25;
	const ERROR_CODE_YOUTUBE_AUTH_URL_FAILED = 26;
	const ERROR_CODE_YOUTUBE_USER_FAILED = 27;
	const ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE = 28;
	
	const ERROR_CODE_DUPLICATE_ENTRY = 1062;
}

class ErrorDescs {
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'Input parameter error!';
	const ERROR_CODE_DB_ERROR = 'Database error!';
	const ERROR_CODE_VERIFICATION_CODE_ERROR = 'The captcha is invalid or has expired!';
	const ERROR_CODE_TASK_APPLICATION_IS_MISSING = 'The task application does not match!';
	const ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS = 'Task application does not belong to you!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT = 'Current task application status cannot be edited!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW = 'Current task application status cannot be reviewed!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR = 'Invalid input parameter for status, only "pending," "accept," or "declined" are allowed.';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD = 'Current task application status cannot be uploaded!';
	const ERROR_CODE_PROJECT_IS_NOT_YOURS = 'Project does not belong to you!';
	const ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH = 'Current task application status cannot be finished!';
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 'File does not exist!';
	const ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT = 'The task does not belong to the project.';
	const ERROR_CODE_TASK_IS_IN_PROGRESS = 'Task is in progress, cannot close the task!';
	const ERROR_CODE_TWITTER_AUTH_URL_FAILED = 'Failed to get Twitter authentication URL!';
	const ERROR_CODE_TWITTER_USER_FAILED = 'Failed to get Twitter user data!';
	const ERROR_CODE_ETHERSCAN_API_FAILED = 'Failed to retrieve data from Etherscan API!';
	const ERROR_CODE_TASK_IS_NOT_EXIST = 'Task does not exist!';
	const ERROR_CODE_KOL_IS_NOT_EXIST = 'KOL does not exist!';
	const ERROR_CODE_TASK_APPLICATION_REACH_MAX_KOL_UPLIMIT = 'Task application has reached the maximum KOL limit!';
	const ERROR_CODE_TASK_APPLICATION_KOL_FOLLOWERS_IS_NOT_ENOUGH = "KOL's followers are not enough!";
	const ERROR_CODE_TASK_APPLICATION_KOL_ENGAGEMENT_IS_NOT_ENOUGH = "KOL's engagement is not enough!";
	const ERROR_CODE_TASK_APPLICATION_KOL_SCORE_IS_NOT_ENOUGH = "KOL's score is not enough!";
	const ERROR_CODE_TASK_APPLICATION_DDL_TIMEOUT = 'The current time has exceeded the application deadline.';
	const ERROR_CODE_TASK_UPLOAD_DDL_TIMEOUT= 'The current time has exceeded the upload deadline.';
	const ERROR_CODE_YOUTUBE_AUTH_URL_FAILED = 'Failed to get Youtobe authentication URL';
	const ERROR_CODE_YOUTUBE_USER_FAILED = 'Failed to get Youtobe user data!';
	const ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE = 'Only invited users can create.';
}
