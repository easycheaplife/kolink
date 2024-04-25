<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\TwitterUserModel;
use App\Models\TwitterUserDataModel;
use App\Http\Services\KolService;


class TwitterService extends Service 
{
	public function auth($redirect_uri)
	{
		$session_id = Str::uuid();
		$url = config('config.twitter_url_base') . "/twitter/auth?session_id=$session_id&redirect_uri=$redirect_uri";
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				$this->res['data'] = $data['data'];
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e->getMessage());
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function user($session_id, $oauth_verifier, $redirect_uri)
	{
		$url = config('config.twitter_url_base') . "/twitter/user?session_id=$session_id&oauth_verifier=$oauth_verifier&redirect_uri=$redirect_uri";
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				$this->res['data'] = $data['data'];
				$twitter_user_model = new TwitterUserModel;
				$insert_flag = 0;
				if ($twitter_user_model->insert($data['data']))
				{
					$insert_flag = 1;	
				}
				$twitter_user_data_model = new TwitterUserDataModel;
				$twitter_user_data_model->insert($data['data'], $insert_flag);
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e);
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function get_user($user_id)
	{
		$twitter_user_model = new TwitterUserModel;
		return $twitter_user_model->get_user($user_id);
	}

	public function load_all_users()
	{
		$kol_service = new KolService;
		$twitter_user_model = new TwitterUserModel;
		$total = $twitter_user_model->count();
		$followers_count_max = $twitter_user_model->get_column_count_max('followers_count');
		$friends_count_max = $twitter_user_model->get_column_count_max('friends_count');
		$listed_count_max = $twitter_user_model->get_column_count_max('listed_count');
		$favourites_count_max = $twitter_user_model->get_column_count_max('favourites_count');
		$media_count_max = $twitter_user_model->get_column_count_max('media_count');
		$created_at_min = $twitter_user_model->get_column_count_min('created_at');
		Log::info("total:$total");
		Log::info("followers_count_max:$followers_count_max");
		Log::info("friends_count_max:$friends_count_max");
		Log::info("listed_count_max:$listed_count_max");
		Log::info("favourites_count_max:$favourites_count_max");
		Log::info("media_count_max:$media_count_max");
		Log::info("created_at_min:$created_at_min");
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$users = $twitter_user_model->get_users($i, $size);
			foreach ($users as $user)
			{
				$user['engagement_score'] = $this->calc_engagement_score($user, 
					$followers_count_max, $listed_count_max, $friends_count_max,
					$favourites_count_max, $media_count_max);
				$user['age_score'] = $this->calc_age_score($user, $created_at_min);
				$user['composite_score'] = $user['engagement_score'] + $user['age_score'];
				$kol = $kol_service->get_by_twitter_user_id($user['user_id']);
				if (empty($kol))
				{
					// insert 	
					$this->insert_kol($user);
				}
				else {
					// update
					$this->update_kol($user, $kol);
				}
				sleep(1);
			}
		}
	}

	public function insert_kol($twitter_user)
	{
		$kol_service = new KolService;
		$kol_service->insert_twitter_user($twitter_user);
		Log::info('insert twitter_user_id:' . $twitter_user['user_id']);
	}

	public function update_kol($twitter_user, $kol_user)
	{
		$kol_service = new KolService;
		$kol_service->update_twitter_user($twitter_user);
		Log::info('update twitter_user_id:' . $twitter_user['user_id']);
	}

	public function calc_engagement_score($user, $followers_count_max, 
		$listed_count_max, $friends_count_max, $favourites_count_max, $media_count_max)
	{
		$followers_count_max = $followers_count_max > 0 ? $followers_count_max : 1; 
		$listed_count_max = $listed_count_max > 0 ? $listed_count_max : 1; 
		$friends_count_max = $friends_count_max > 0 ? $friends_count_max : 1; 
		$favourites_count_max = $favourites_count_max > 0 ? $favourites_count_max : 1; 
		$media_count_max = $media_count_max > 0 ? $media_count_max : 1; 
		$engagement_score = number_format($user['followers_count'] / $followers_count_max * 20, 2)
			+ number_format($user['listed_count'] / $listed_count_max * 20, 2)	
			+ number_format($user['friends_count'] / $friends_count_max * 10, 2)	
			+ number_format($user['favourites_count'] / $favourites_count_max * 10, 2)
			+ number_format($user['media_count'] / $media_count_max * 10, 2);	
		Log::info("engagement_score:$engagement_score");
		return $engagement_score;
	}

	public function calc_age_score($user, $twitter_created_at_min)
	{
		$now_time = time();
		$twitter_total = $now_time - $twitter_created_at_min;	
		$twitter_diff = $now_time - strtotime($user['created_at']);
		$twitter_time_score = number_format($twitter_diff / $twitter_total * 10, 2);
		Log::info("twitter_time_score:$twitter_time_score");
		return $twitter_time_score;
	}

}
