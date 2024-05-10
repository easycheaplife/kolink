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
use App\Http\Services\TwitterService;


class KolService extends Service 
{
	public function kol_new($token, $email, $twitter_user_id, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, $code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email, config('config.verification_type')['kol']);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}
		$last_insert_id = 0;
		$kol_model = new KolModel;
		if (!$kol_model->insert($token, $email, $twitter_user_id, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, $last_insert_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		$this->res['data']['id'] = $last_insert_id;
		return $this->res;
	}	

    public function kol_list($region_id, $category_id, $language_id, $channel_id, $sort_type, $sort_field, $page, $size)
	{
		$kol_model = new KolModel;
		$kols = $kol_model->list($region_id, $category_id, $language_id, $channel_id, $sort_type, $sort_field, $page, $size);	
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
		$task_list = $task_service->kol_task_list($task_ids);
		$task_map  = [];
		foreach ($task_list as $key => $task) 
		{
			$task_map[$task['id']]	= $task; 
		}
		foreach ($task_applications as $application)
		{
			$application_task = clone $task_map[$application->task_id];
			$application_task['task_id'] = $application->task_id;
			$application_task['status'] = $application->status;
			$application_task['application_id'] = $application->id;
			$application_task['quotation'] = $application->quotation;
			$application_task['reason'] = $application->reason;
			$application_task['verification'] = $application->verification;
			$application_task['url'] = $application->url;
			$application_task['declined_desc'] = $application->declined_desc;
			$application_result = $application_service->application_eligibility($kol_id, $task['id']);
			$application_task['application_eligibility'] = $application_result['code'] == ErrorCodes::ERROR_CODE_SUCCESS ? 1 : 0;
			$application_task['application_num'] = $application_service->application_kol_num($task['id']);
			$this->res['data']['list'][] = $application_task;
		}
		$this->res['data']['total'] = $application_service->kol_task_list_count($kol_id, $status);
		return $this->res;
	}

	public function kol_setting($kol_id, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id)
	{
		$kol_model = new KolModel;
		if (!$kol_model->setting($kol_id, $email, $twitter_user_name, $twitter_avatar, $twitter_followers,
			$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id))
		{
			return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function get_by_twitter_user_id($twitter_user_id)
	{
		$kol_model = new KolModel;
		return $kol_model->get_by_twitter_user_id($twitter_user_id);
	}
	
	public function insert_twitter_user($twitter_user) 
	{
		$kol_model = new KolModel;
		if (!$kol_model->insert_twitter_user($twitter_user)) 
		{
			return $this->error_response($twitter_user['user_id'], ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
	}	

	public function update_twitter_user($twitter_user) 
	{
		$kol_model = new KolModel;
		if (!$kol_model->update_twitter_user($twitter_user)) 
		{
			return $this->error_response($twitter_user['user_id'], ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
	}	

	public function get_tokens($page, $size)
	{
		$kol_model = new KolModel;
		return $kol_model->get_tokens($page, $size);
	}

	public function token_count()
	{
		$kol_model = new KolModel;
		return $kol_model->token_count();
	}

}
