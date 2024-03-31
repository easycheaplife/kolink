<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\KolModel;
use App\Http\Services\VerificationService;
use App\Http\Services\ProjectTaskApplicationService;
use App\Http\Services\ProjectTaskService;


class KolService extends Service 
{
	public function kol_new($token, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, $code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}
		$kol_model = new KolModel;
		if (!$kol_model->insert($token, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

    public function kol_list($region_id, $category_id, $language_id, $channel_id)
	{
		$kol_model = new KolModel;
		$kols = $kol_model->list($region_id, $category_id, $language_id, $channel_id);	
		foreach ($kols as $kol)
		{
			$this->res['data'][] = $kol;	
		}
		return $this->res;
	}

    public function kol_detail($kol_id)
	{
		$kol_model = new KolModel;
		$this->res['data'] = $kol_model->get($kol_id);
		return $this->res;
	}

	public function kol_task_list($kol_id)
	{
		$application_service = new ProjectTaskApplicationService;
		$tasks = $application_service->kol_task_list($kol_id);	
		$task_ids = [];
		foreach ($tasks as $task)
		{
			$task_ids[] = $task['task_id'];	
		}
		$task_service = new ProjectTaskService;
		$this->res['data'] = $task_service->kol_task_list($task_ids);
		return $this->res;
	}

}
