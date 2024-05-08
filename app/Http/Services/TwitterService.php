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
use App\Http\Services\EtherscanService;


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
				return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function auth2($redirect_uri, $code)
	{
		try {
			$url = 'https://api.twitter.com/2/oauth2/token';
			$response = Http::asForm()->post($url, [
				'code' => $code,
				'grant_type' => 'authorization_code',
				'client_id' => config('config.twitter_client_id'),
				'redirect_uri' => $redirect_uri,
				'code_verifier' => 'challenge',
			]);

			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				$this->res['data'] = $data;
			}
			else {
				$error_message = "http post $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($code, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($code, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $e->getMessage());
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
				$data['data']['profile_image_url'] = str_replace('_normal', '', $data['data']['profile_image_url']);
				$data['data']['profile_image_url_https'] = str_replace('_normal', '', $data['data']['profile_image_url_https']);
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
				return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e);
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function user2($access_token)
	{
		$url = "https://api.twitter.com/2/users/me?" . 
			"user.fields=created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified,withheld";
		try {
			$headers = ['Authorization' => "Bearer $access_token"];
			$response = Http::withHeaders($headers)
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				$data['data']['profile_image_url'] = str_replace('_normal', '', $data['data']['profile_image_url']);
				$this->res['data'] = $data['data'];
				$twitter_user_model = new TwitterUserModel;
				$insert_flag = 0;
				if ($twitter_user_model->insert2($data['data']))
				{
					$insert_flag = 1;	
				}
				$twitter_user_data_model = new TwitterUserDataModel;
				$twitter_user_data_model->insert($data['data'], $insert_flag);
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($access_token, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e);
			return $this->error_response($access_token, ErrorCodes::ERROR_CODE_TWITTER_USER_FAILED, $e->getMessage());
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
		$etherscan_service = new EtherscanService;
		$total = $twitter_user_model->count();
		$followers_count_max = $twitter_user_model->get_column_count_max('followers_count');
		$friends_count_max = $twitter_user_model->get_column_count_max('friends_count');
		$listed_count_max = $twitter_user_model->get_column_count_max('listed_count');
		$favourites_count_max = $twitter_user_model->get_column_count_max('favourites_count');
		$media_count_max = $twitter_user_model->get_column_count_max('media_count');
		$twitter_created_at_min = $twitter_user_model->get_column_count_min('created_at');
		$tokon_created_at_min = $etherscan_service->get_column_count_min('created_at');
		$token_count_max = $etherscan_service->get_column_count_min('token_count');
		$nft_count_max = $etherscan_service->get_column_count_min('nft_count');
		Log::debug("total:$total");
		Log::debug("followers_count_max:$followers_count_max");
		Log::debug("friends_count_max:$friends_count_max");
		Log::debug("listed_count_max:$listed_count_max");
		Log::debug("favourites_count_max:$favourites_count_max");
		Log::debug("media_count_max:$media_count_max");
		Log::debug("twitter_created_at_min:$twitter_created_at_min");
		Log::debug("token_created_at_min:$twitter_created_at_min");
		Log::debug("token_count_max:$token_count_max");
		Log::debug("nft_count_max:$nft_count_max");
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$users = $twitter_user_model->get_users($i, $size);
			foreach ($users as $user)
			{
				$kol = $kol_service->get_by_twitter_user_id($user['user_id']);
				$token = empty($kol) ? '' : $kol['token'];
				$token_user = $this->get_token_user($token);
				$user['engagement_score'] = $this->calc_engagement_score($user, 
					$followers_count_max, $listed_count_max, $friends_count_max,
					$favourites_count_max, $media_count_max);
				$user['age_score'] = $this->calc_age_score($user, $token_user, $twitter_created_at_min, $twitter_created_at_min);
				$user['monetary_score'] = $this->calc_monetary_score($token_user, $token_count_max, $nft_count_max);
				$user['composite_score'] = $user['engagement_score'] + $user['age_score'] + $user['monetary_score'];
				if (empty($kol))
				{
					// insert 	
					// $this->insert_kol($user);
				}
				else {
					// update
					$this->update_kol($user, $kol);
				}
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
		Log::debug("engagement_score:$engagement_score");
		return $engagement_score;
	}

	public function calc_age_score($user, $token_user, $twitter_created_at_min, $token_created_at_min)
	{
		$now_time = time();
		$twitter_time_score = 0;
		$twitter_total = $now_time - $twitter_created_at_min;	
		if (!empty($twitter_total))
		{
			$twitter_diff = $now_time - $user['created_at'];
			$twitter_time_score = number_format($twitter_diff / $twitter_total * 5, 2);
			Log::debug("twitter_time_score:$twitter_time_score,twitter_diff:$twitter_diff,twitter_total:$twitter_total");
		}

		$token_time_score = 0;
		$token_total = $now_time - $token_created_at_min;	
		if (!empty($token_user) && !empty($token_total))
		{
			$token_diff = $now_time - $token_user['created_at'];
			$token_time_score = number_format($token_diff / $token_total * 5, 2);
			Log::debug("token_time_score:$token_time_score,token_diff:$token_diff,token_total:$token_total");
		}
		return floatval($twitter_time_score) + floatval($token_time_score);
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
		$monetary_score = number_format($token_user['token_count'] / $token_count_max * 20, 2) 
			+ number_format($token_user['nft_count'] / $nft_count_max * 20, 2);
		Log::debug("monetary_score:$monetary_score");
		return $monetary_score;
	}

	public function sync_all_users()
	{
		$twitter_user_data_model = new TwitterUserDataModel;
		$twitter_user_model = new TwitterUserModel;
		$total = $twitter_user_data_model->count();
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$users = $twitter_user_data_model->get_users($i, $size);
			foreach ($users as $user)
			{
				$json_user = json_decode($user['data'], true);	
				$insert_flag = 0;
				if (isset($json_user['contributors_enabled']))
				{
					if ($twitter_user_model->insert($json_user))
					{
						$insert_flag = 1;
					}	
				}
				else {
					if ($twitter_user_model->insert2($json_user))
					{
						$insert_flag = 1;
					}	
				}
				if ($insert_flag)
				{
					$twitter_user_data_model->update_insert_flag($user['id']);	
				}
			}
		}
	}

}
