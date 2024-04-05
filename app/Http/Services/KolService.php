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
		$last_insert_id = 0;
		$kol_model = new KolModel;
		if (!$kol_model->insert($token, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, $last_insert_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		$this->res['id'] = $last_insert_id;
		return $this->res;
	}	

    public function kol_list($region_id, $category_id, $language_id, $channel_id, $sort_type, $page, $size)
	{
		$kol_model = new KolModel;
		$kols = $kol_model->list($region_id, $category_id, $language_id, $channel_id, $sort_type, $page, $size);	
		foreach ($kols as $kol)
		{
			$this->res['data']['list'][] = $kol;	
		}
		$this->res['data']['total'] = $kol_model->count($region_id, $category_id, $language_id, $channel_id);	
		return $this->res;
	}

    public function kol_detail($kol_id)
	{
		$kol_model = new KolModel;
		$this->res['data'] = $kol_model->get($kol_id);
		return $this->res;
	}

    public function login($token)
	{
		$kol_model = new KolModel;
		$this->res['data'] = $kol_model->login($token);
		return $this->res;
	}

	public function kol_task_list($kol_id, $status, $page, $size)
	{
		$application_service = new ProjectTaskApplicationService;
		$task_applications = $application_service->kol_task_list($kol_id, $status, $page, $size);	
		$task_ids = [];
		foreach ($task_applications as $application)
		{
			$task_ids[] = $application->task_id;	
		}
		$task_service = new ProjectTaskService;
		$this->res['data']['list'] = $task_service->kol_task_list($task_ids);
		foreach ($this->res['data']['list'] as $key => $task) 
		{
			foreach ($task_applications as $application)
			{
				if ($task['id'] == $application->task_id)
				{
					$this->res['data']['list'][$key]['status'] = $application->status;
					$this->res['data']['list'][$key]['application_id'] = $application->id;
					break;
				}
			}
		}
		$this->res['data']['total'] = $application_service->kol_task_count($kol_id);
		return $this->res;
	}

}
