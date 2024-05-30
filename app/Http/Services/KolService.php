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
use App\Http\Services\YoutubeService;
use App\Http\Services\RewardService;


class KolService extends Service 
{
	public function kol_new($token, $email, $twitter_user_id, $youtube_user_id, 
		$region_id, $category_id, $language_id, $channel_id, $code, $invite_code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email, config('config.verification_type')['kol']);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}

		$twitter_user_name = '';
		$twitter_avatar = '';
		$twitter_followers = 0;
		$twitter_like_count = 0;
		$twitter_following_count = 0;
		$twitter_listed_count = 0;
		$twitter_statuses_count = 0;
		$twitter_created_at = 0;
		$monetary_score = 0;
		$engagement_score = 0;
		$age_score = 0;
		$composite_score = 0;
		$twitter_service = new TwitterService;
		$twitter_user = $twitter_service->get_user($twitter_user_id);
		if (!empty($twitter_user))
		{
			$twitter_service->calc_user_score($twitter_user, $token);
			$twitter_user_name = $twitter_user['screen_name'];			
			$twitter_avatar = $twitter_user['profile_image_url'];			
			$twitter_followers = $twitter_user['followers_count'];			
			$twitter_like_count = $twitter_user['like_count'];			
			$twitter_following_count = $twitter_user['following_count'];			
			$twitter_listed_count = $twitter_user['listed_count'];
			$twitter_statuses_count = $twitter_user['statuses_count'];
			$twitter_created_at = $twitter_user['created_at'];			
			$monetary_score = $twitter_user['monetary_score'];
			$engagement_score = $twitter_user['engagement_score'];
			$age_score = $twitter_user['age_score'];
			$composite_score = $twitter_user['composite_score'];
		}
		
		$youtube_user_name = '';
		$youtube_avatar = '';
		$youtube_custom_url = '';
		$youtube_subscriber_count = 0;
		$youtube_view_count = 0;
		$youtube_video_count = 0;
		$youtube_created_at = 0;
		$youtube_service = new YoutubeService;
		$youtube_user = $youtube_service->get_user($youtube_user_id);
		if (!empty($youtube_user))
		{
			$youtube_user_name = $youtube_user['title'];		
			$youtube_avatar = $youtube_user['profile_image_url'];		
			$youtube_custom_url = $youtube_user['custom_url'];		
			$youtube_subscriber_count = $youtube_user['subscriber_count'];		
			$youtube_view_count = $youtube_user['view_count'];		
			$youtube_video_count = $youtube_user['video_count'];		
			$youtube_created_at = $youtube_user['created_at'];		
		}

		$last_insert_id = 0;
		$kol_model = new KolModel;
		if (!$kol_model->insert($token, $email, $twitter_user_id, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_like_count, $twitter_following_count, $twitter_listed_count, $twitter_statuses_count, $twitter_created_at,
			$youtube_user_id, $youtube_user_name, $youtube_avatar, $youtube_custom_url, $youtube_view_count,
			$youtube_subscriber_count, $youtube_video_count, $youtube_created_at,
			$monetary_score, $engagement_score, $age_score, $composite_score,
			$region_id, $category_id, $language_id, $channel_id, $invite_code, $last_insert_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}

		$reward_service = new RewardService;
		$reward_service->add_self_reward($last_insert_id, config('config.reward_task')['auth_twitter']['xp'],config('config.reward_task')['auth_twitter']['id']);
		$reward_service->add_invite_reward($last_insert_id, config('config.reward_task')['invite_friend']['xp'],config('config.reward_task')['invite_friend']['id']);

/*
		if (0 != $last_insert_id)
		{
			if (!empty($invite_code))
			{
				$invite_kol_data = $kol_model->get_id_by_invite_code($invite_code);
				if (!empty($invite_kol_data))
				{
					$reward_service->insert_record($last_insert_id, $invite_kol_data['id'], config('config.reward_task')['invite_friend']['xp'],config('config.reward_task')['invite_friend']['id']); 
				}
			}
			$reward_service->insert_record($last_insert_id, $last_insert_id, config('config.reward_task')['auth_twitter']['xp'],config('config.reward_task')['auth_twitter']['id']); 
		}
 */

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
		if (!empty($this->res['data']))
		{
			$this->res['data']['engagement'] = $this->engagement_score($this->res['data']);
			$this->res['data']['monetary_score'] = empty($this->res['data']['monetary_score']) ? 0 : $this->res['data']['monetary_score'];
		}
		return $this->res;
	}

	public function engagement_score($kol_detail)
	{
		if (empty($kol_detail))
		{
			return 0;
		}
		$engagement = 1;
		$followers = $kol_detail['twitter_followers'];
		$likes = $kol_detail['twitter_like_count'];
		if ($followers > 0 && $likes > 0)
		{
			$engagement = number_format($likes / $followers * 100, 2);	
		}
		return $engagement;
	}

    public function login($token)
	{
		$kol_model = new KolModel;
		$this->res['data'] = $kol_model->login($token);
		if (!empty($this->res['data']))
		{
			$this->res['data']['engagement'] = $this->engagement_score($this->res['data']);
			$this->res['data']['inviter_twitter_user_name'] = '';
			$inviter_kol_data = $kol_model->get_inviter_kol_by_invitee_code($this->res['data']['invitee_code']);
			if (!empty($inviter_kol_data))
			{
				$this->res['data']['inviter_twitter_user_name'] = $inviter_kol_data['twitter_user_name'];
			}
			$reward_service = new RewardService;
			$this->res['data']['reward_task_completed_num'] = $reward_service->completed_num($this->res['data']['id']);
		}
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
			$application_task['updated_at'] = $application->updated_at;
			$application_result = $application_service->application_eligibility($kol_id, $task['id']);
			$application_task['application_eligibility'] = $application_result['code'] == ErrorCodes::ERROR_CODE_SUCCESS ? 1 : 0;
			$application_task['application_eligibility_desc'] = $application_result['message'];
			$application_task['application_num'] = $application_service->application_kol_num($task['id']);
			$this->res['data']['list'][] = $application_task;
		}
		$this->res['data']['total'] = $application_service->kol_task_list_count($kol_id, $status);
		return $this->res;
	}

	public function kol_setting($kol_id, $email, $region_id, $category_id, $language_id, $channel_id)
	{
		$kol_model = new KolModel;
		if (!$kol_model->setting($kol_id, $email, $region_id, $category_id, $language_id, $channel_id))
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

	public function update_invite_code($kol_id, $invite_code)
	{
		$kol_model = new KolModel;
		return $kol_model->update_invite_code($kol_id, $invite_code);
	}

	public function invited_friend_num($invitee_code)
	{
		$kol_model = new KolModel;
		return $kol_model->invited_friend_num($invitee_code);
	}

	public function get_id_by_invite_code($invite_code)
	{
		$kol_model = new KolModel;
		return $kol_model->get_id_by_invite_code($invite_code);
	}

	public function inc_xp($kol_id, $xp)
	{
		$kol_model = new KolModel;
		return $kol_model->inc_xp($kol_id, $xp);
	}

	public function get_kols($kol_ids)
	{
		$kol_model = new KolModel;
		return $kol_model->get_kols($kol_ids);
	}

}
