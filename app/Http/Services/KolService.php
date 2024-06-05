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
use App\Http\Services\EtherscanService;


class KolService extends Service 
{
	public function kol_new($token, $email, $twitter_user_id, $youtube_user_id, 
		$region_id, $category_id, $language_id, $channel_id, $code, $invite_code)
	{
		if (empty($invite_code))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE,
				ErrorDescs::ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE);		
		}

		$kol_model = new KolModel;
		$invite_kol = $kol_model->get_id_by_invite_code($invite_code);
		if (empty($invite_kol))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE,
				ErrorDescs::ERROR_CODE_ONLY_INVITED_USER_CAN_CREATE);		
		}

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
		$twitter_service = new TwitterService;
		$twitter_user = $twitter_service->get_user($twitter_user_id);
		if (!empty($twitter_user))
		{
			$twitter_user_name = $twitter_user['screen_name'];			
			$twitter_avatar = $twitter_user['profile_image_url'];			
			$twitter_followers = $twitter_user['followers_count'];			
			$twitter_like_count = $twitter_user['like_count'];			
			$twitter_following_count = $twitter_user['following_count'];			
			$twitter_listed_count = $twitter_user['listed_count'];
			$twitter_statuses_count = $twitter_user['statuses_count'];
			$twitter_created_at = $twitter_user['created_at'];			
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
		if (!$kol_model->insert($token, $email, $twitter_user_id, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_like_count, $twitter_following_count, $twitter_listed_count, $twitter_statuses_count, $twitter_created_at,
			$youtube_user_id, $youtube_user_name, $youtube_avatar, $youtube_custom_url, $youtube_view_count,
			$youtube_subscriber_count, $youtube_video_count, $youtube_created_at,
			$region_id, $category_id, $language_id, $channel_id, $invite_code, $last_insert_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}

		$reward_service = new RewardService;
		$reward_service->add_self_reward($last_insert_id, config('config.reward_task')['auth_twitter']['xp'],config('config.reward_task')['auth_twitter']['id']);
		$reward_service->add_invite_reward($last_insert_id, config('config.reward_task')['invite_friend']['xp'],config('config.reward_task')['invite_friend']['id']);

		$this->res['data']['id'] = $last_insert_id;

		if ($last_insert_id)
		{
			$kol = $kol_model->get($last_insert_id);
			$this->calc_user_score(array($kol));
		}
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
			$engagement = round($likes / $followers * 100, 2);	
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

	public function kol_setting($kol_id, $twitter_user_id, $youtube_user_id, $email, $region_id, $category_id, $language_id, $channel_id)
	{
		$kol_model = new KolModel;
		$kol_detail = $kol_model->get($kol_id);
		if (empty($kol_detail))
		{
			return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_KOL_IS_NOT_EXIST,
				ErrorDescs::ERROR_CODE_KOL_IS_NOT_EXIST);		
		}
		$kol_detail['email'] = $email;
		$kol_detail['region_id'] = $region_id;
		$kol_detail['category_id'] = $category_id;
		$kol_detail['language_id'] = $language_id;
		$kol_detail['channel_id'] = $channel_id;
		$kol_detail['twitter_user_id'] = is_null($twitter_user_id) ? $kol_detail['twitter_user_id'] : $twitter_user_id;
		$kol_detail['youtube_user_id'] = is_null($youtube_user_id) ? $kol_detail['youtube_user_id'] : $youtube_user_id;
		$twitter_service = new TwitterService;
		$twitter_user = $twitter_service->get_user($twitter_user_id);
		if (!empty($twitter_user))
		{
			$kol_detail['twitter_user_id'] = $twitter_user_id;	
			$kol_detail['twitter_user_name'] = $twitter_user['screen_name'];			
			$kol_detail['twitter_avatar'] = $twitter_user['profile_image_url'];			
			$kol_detail['twitter_followers'] = $twitter_user['followers_count'];			
			$kol_detail['twitter_like_count'] = $twitter_user['like_count'];			
			$kol_detail['twitter_following_count'] = $twitter_user['following_count'];			
			$kol_detail['twitter_listed_count'] = $twitter_user['listed_count'];
			$kol_detail['twitter_statuses_count'] = $twitter_user['statuses_count'];
			$kol_detail['twitter_created_at'] = $twitter_user['created_at'];			
		}

		$youtube_service = new YoutubeService;
		$youtube_user = $youtube_service->get_user($youtube_user_id);
		if (!empty($youtube_user))
		{
			$kol_detail['youtube_user_id'] = $youtube_user_id;		
			$kol_detail['youtube_user_name'] = $youtube_user['title'];		
			$kol_detail['youtube_avatar'] = $youtube_user['profile_image_url'];		
			$kol_detail['youtube_custom_url'] = $youtube_user['custom_url'];		
			$kol_detail['youtube_subscriber_count'] = $youtube_user['subscriber_count'];		
			$kol_detail['youtube_view_count'] = $youtube_user['view_count'];		
			$kol_detail['youtube_video_count'] = $youtube_user['video_count'];		
			$kol_detail['youtube_created_at'] = $youtube_user['created_at'];		
		}

		if (!$kol_model->setting($kol_detail))
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

	public function calc_user_score($kols)
	{
		$kol_model = new KolModel;
		$twitter_followers_count_max = $kol_model->get_column_count_max('twitter_followers');
		$twitter_following_count_max = $kol_model->get_column_count_max('twitter_following_count');
		$twitter_listed_count_max = $kol_model->get_column_count_max('twitter_listed_count');
		$twitter_like_count_max = $kol_model->get_column_count_max('twitter_like_count');
		$twitter_statuses_count_max = $kol_model->get_column_count_max('twitter_statuses_count');
		$twitter_created_at_min = $kol_model->get_column_count_min('twitter_created_at');

		$youtube_subscriber_count_max = $kol_model->get_column_count_max('youtube_subscriber_count');
		$youtube_view_count_max = $kol_model->get_column_count_max('youtube_view_count');
		$youtube_video_count_max = $kol_model->get_column_count_max('youtube_video_count');
		$youtube_created_at_min = $kol_model->get_column_count_min('youtube_created_at');

		$etherscan_service = new EtherscanService;
		$token_count_max = $etherscan_service->get_column_count_max('token_count');
		$nft_count_max = $etherscan_service->get_column_count_max('nft_count');
		$tokon_created_at_min = $etherscan_service->get_column_count_min('created_at');

		foreach ($kols as $kol)
		{
			$token_user = $this->get_token_user($kol['token']);
			$twitter_engagement_score = $this->calc_twitter_engagement_score(
				$kol, $twitter_followers_count_max, $twitter_listed_count_max,
				$twitter_following_count_max, $twitter_like_count_max, $twitter_statuses_count_max
			);	
			$youtube_engagement_score = $this->calc_youtube_engagement_score(
				$kol, $youtube_subscriber_count_max, $youtube_view_count_max, $youtube_video_count_max
			);	
			$age_score = $this->calc_age_score($kol, $token_user, $twitter_created_at_min, $twitter_created_at_min, $youtube_created_at_min);
			$monetary_score = $this->calc_monetary_score($token_user, $token_count_max, $nft_count_max);
			$composite_score = $twitter_engagement_score + $youtube_engagement_score + $age_score + $monetary_score;
			$kol_model->update_score($kol['id'], $twitter_engagement_score + $youtube_engagement_score,
				$age_score, $monetary_score, $composite_score);
			Log::info(strval('kol_id:' . $kol['id']) . " twitter_engagement_score:$twitter_engagement_score,"
				. "youtube_engagement_score:$youtube_engagement_score,age_score:$age_score,monetary_score:$monetary_score");
		}
	}

	public function calc_twitter_engagement_score($user, $followers_count_max, 
		$listed_count_max, $following_count_max, $like_count_max, $statuses_count_max)
	{
		$followers_count_max = $followers_count_max > 0 ? $followers_count_max : 1; 
		$listed_count_max = $listed_count_max > 0 ? $listed_count_max : 1; 
		$following_count_max = $following_count_max > 0 ? $following_count_max : 1; 
		$like_count_max = $like_count_max > 0 ? $like_count_max : 1; 
		$statuses_count_max = $statuses_count_max > 0 ? $statuses_count_max : 1; 
		$engagement_score = round($user['twitter_followers'] / $followers_count_max * 10, 2)
			+ round($user['twitter_listed_count'] / $listed_count_max * 10, 2)	
			+ round($user['twitter_following_count'] / $following_count_max * 5, 2)	
			+ round($user['twitter_like_count'] / $like_count_max * 5, 2)
			+ round($user['twitter_statuses_count'] / $statuses_count_max * 5, 2);	
		return $engagement_score;
	}

	public function calc_youtube_engagement_score($user, $subscriber_count_max, 
		$view_count_max, $video_count_max)
	{
		$subscriber_count_max = $subscriber_count_max > 0 ? $subscriber_count_max : 1; 
		$view_count_max = $view_count_max > 0 ? $view_count_max : 1; 
		$video_count_max = $video_count_max > 0 ? $video_count_max : 1; 
		$engagement_score = round($user['youtube_subscriber_count'] / $subscriber_count_max * 10, 2)
			+ round($user['youtube_view_count'] / $view_count_max * 20, 2)
			+ round($user['youtube_video_count'] / $video_count_max * 5, 2);	
		return $engagement_score;
	}

	public function calc_age_score($user, $token_user, $twitter_created_at_min, $token_created_at_min, $youtube_created_at_min)
	{
		$now_time = time();
		$twitter_time_score = 0;
		$twitter_total = $now_time - $twitter_created_at_min;	
		if (!empty($twitter_total))
		{
			$twitter_diff = $now_time - $user['twitter_created_at'];
			$twitter_time_score = round($twitter_diff / $twitter_total * 3, 2);
		}

		$youtube_time_score = 0;
		$youtube_total = $now_time - $youtube_created_at_min;	
		if (!empty($youtube_total))
		{
			$youtube_diff = $now_time - $user['youtube_created_at'];
			$youtube_time_score = round($youtube_diff / $youtube_total * 3, 2);
		}

		$token_time_score = 0;
		$token_total = $now_time - $token_created_at_min;	
		if (!empty($token_user) && !empty($token_total))
		{
			$token_diff = $now_time - $token_user['created_at'];
			$token_time_score = round($token_diff / $token_total * 4, 2);
		}
		return floatval($twitter_time_score) + floatval($youtube_time_score) + floatval($token_time_score);
	}

	public function get_token_user($token)
	{
		if ('' == $token)
		{
			return array();
		}
		$etherscan_service = new EtherscanService; 
		return $etherscan_service->get_token($token);
	}

	public function calc_monetary_score($token_user, $token_count_max, $nft_count_max)
	{
		if (empty($token_user))
		{
			return 0;
		}
		$token_count_max = $token_count_max > 0 ? $token_count_max : 1; 
		$nft_count_max = $nft_count_max > 0 ? $nft_count_max : 1; 
		$token_score = round($token_user['token_count'] / $token_count_max * 10, 2);
		$nft_score = round($token_user['nft_count'] / $nft_count_max * 10, 2);
		return $token_score + $nft_score;
	}

	public function update_all_user_data()
	{
		$kol_model = new KolModel;
		$total = $kol_model->get_users_count(); 
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$kols = $kol_model->get_users($i, $size);
			sleep(60);
		}
	}

	public function calc_all_user_score()
	{
		$kol_model = new KolModel;
		$total = $kol_model->get_users_count(); 
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$kols = $kol_model->get_users($i, $size);
			$this->calc_user_score($kols);
		}
	}

}
