<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\TwitterUserModel;
use App\Models\TwitterUserDataModel;
use App\Models\TweetModel;
use App\Models\TwitterContentRelevanceModel;
use App\Http\Services\KolService;
use App\Http\Services\EtherscanService;
use App\Http\Services\RewardService;
use App\Http\Services\AiService;


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

	public function auth2($redirect_uri, $code, $debug)
	{
		try {
			$url = 'https://api.twitter.com/2/oauth2/token';
			if ($debug)
			{
				$url = config('config.twitter_url_base') . '/twitter/auth2';
				$headers = [];
				$response = Http::withHeaders($headers)
				->get($url);
				$data = $response->json();
				$this->res['data'] = $data['data'];
				return $this->res;
			}

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

	public function user2($access_token, $debug)
	{
		$url = "https://api.twitter.com/2/users/me?" . 
			"user.fields=created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified,withheld";
		if ($debug)
		{
			$url = config('config.twitter_url_base') . '/twitter/user2';
		}
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
		return $twitter_user_model->get($user_id);
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
		$like_count_max = $twitter_user_model->get_column_count_max('like_count');
		$media_count_max = $twitter_user_model->get_column_count_max('media_count');
		$twitter_created_at_min = $twitter_user_model->get_column_count_min('created_at');
		$tokon_created_at_min = $etherscan_service->get_column_count_min('created_at');
		$token_count_max = $etherscan_service->get_column_count_max('token_count');
		$nft_count_max = $etherscan_service->get_column_count_max('nft_count');
		Log::debug("total:$total");
		Log::debug("followers_count_max:$followers_count_max");
		Log::debug("friends_count_max:$friends_count_max");
		Log::debug("listed_count_max:$listed_count_max");
		Log::debug("like_count_max:$like_count_max");
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
				Log::debug("twitter_user_id:" . $user['user_id']);
				$kol = $kol_service->get_by_twitter_user_id($user['user_id']);
				$token = empty($kol) ? '' : $kol['token'];
				$token_user = $this->get_token_user($token);
				$user['engagement_score'] = $this->calc_engagement_score($user, 
					$followers_count_max, $listed_count_max, $friends_count_max,
					$like_count_max, $media_count_max);
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
		Log::debug('insert twitter_user_id:' . $twitter_user['user_id']);
	}

	public function update_kol($twitter_user, $kol_user)
	{
		$kol_service = new KolService;
		$kol_service->update_twitter_user($twitter_user);
		Log::debug('update twitter_user_id:' . $twitter_user['user_id']);
	}

	public function calc_engagement_score($user, $followers_count_max, 
		$listed_count_max, $friends_count_max, $like_count_max, $media_count_max)
	{
		$followers_count_max = $followers_count_max > 0 ? $followers_count_max : 1; 
		$listed_count_max = $listed_count_max > 0 ? $listed_count_max : 1; 
		$friends_count_max = $friends_count_max > 0 ? $friends_count_max : 1; 
		$like_count_max = $like_count_max > 0 ? $like_count_max : 1; 
		$media_count_max = $media_count_max > 0 ? $media_count_max : 1; 
		$engagement_score = number_format($user['followers_count'] / $followers_count_max * 20, 2)
			+ number_format($user['listed_count'] / $listed_count_max * 20, 2)	
			+ number_format($user['friends_count'] / $friends_count_max * 10, 2)	
			+ number_format($user['like_count'] / $like_count_max * 10, 2)
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
		$monetary_score = number_format($token_user['token_count'] / $token_count_max * 10, 2) 
			+ number_format($token_user['nft_count'] / $nft_count_max * 10, 2);
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

	public function calc_user_score($user, $token)
	{
		$kol_service = new KolService;
		$twitter_user_model = new TwitterUserModel;
		$etherscan_service = new EtherscanService;
		$total = $twitter_user_model->count();
		$followers_count_max = $twitter_user_model->get_column_count_max('followers_count');
		$friends_count_max = $twitter_user_model->get_column_count_max('friends_count');
		$listed_count_max = $twitter_user_model->get_column_count_max('listed_count');
		$like_count_max = $twitter_user_model->get_column_count_max('like_count');
		$media_count_max = $twitter_user_model->get_column_count_max('media_count');
		$twitter_created_at_min = $twitter_user_model->get_column_count_min('created_at');
		$tokon_created_at_min = $etherscan_service->get_column_count_min('created_at');
		$token_count_max = $etherscan_service->get_column_count_min('token_count');
		$nft_count_max = $etherscan_service->get_column_count_min('nft_count');
		$user['engagement_score'] = $this->calc_engagement_score($user, 
			$followers_count_max, $listed_count_max, $friends_count_max,
			$like_count_max, $media_count_max);
		$token_user = $this->get_token_user($token);
		$user['age_score'] = $this->calc_age_score($user, $token_user, $twitter_created_at_min, $twitter_created_at_min);
		$user['monetary_score'] = $this->calc_monetary_score($token_user, $token_count_max, $nft_count_max);
		$user['composite_score'] = $user['engagement_score'] + $user['age_score'] + $user['monetary_score'];
	}

	public function insert_user_from_xlsx($screen_name)
	{
		$url = config('config.twitter_service_url_base') . "/twitter/get_user?screen_name=$screen_name" ;
		try {
			$headers = [];
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
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e);
		}  
	}

	public function get_user_followers()
	{
		$url = config('config.twitter_service_url_base') . '/twitter/get_user_followers';	
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->get($url);
			$reward_service = new RewardService;
			if ($response->successful()) {
				$data = $response->json();
				foreach ($data['data']['list'] as $user)
				{
					$reward_service->add_twitter_follower_reward($user['user_id']);
				}
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
			}
		} catch (\Exception $e) 
		{   
			if (strpos($e->getMessage(), "" . ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY) !== false) {
				return $this->res;	
			}
			Log::error($e);
		}  
	}

	public function get_user_data($screen_name)
	{
		$url = config('config.twitter_service_url_base') . "/twitter/get_user_data?screen_name=$screen_name" ;
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				$data['data']['profile_image_url'] = str_replace('_normal', '', $data['data']['profile_image_url']);
				$this->res['data'] = $data['data'];
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				$this->res['data'] = array();
				Log::error($error_message);
			}
		} catch (\Exception $e) 
		{   
			$this->res['data'] = array();
			Log::error($e);
		}  
		return $this->res;
	}

	public function get_user_tweets($user_id)
	{
		$url = config('config.twitter_service_url_base') . "/twitter/get_user_tweets?user_id=$user_id" ;
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				$this->res['data'] = $data['data'];
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				$this->res['data'] = array();
				Log::error($error_message);
			}
		} catch (\Exception $e) 
		{   
			$this->res['data'] = array();
			Log::error($e);
		}  
		return $this->res;
	}

	public function insert_tweet($tweet)
	{
		$tweet_model = new TweetModel;
		return $tweet_model->insert($tweet);
	}

    public function tweets($screen_name)
	{
		$tweet_model = new TweetModel;
		$this->res['data'] = $tweet_model->get($screen_name);
		return $this->res;
	}

	public function tweets_content_relevance($screen_name, $keywords)
	{
		$ai_service = new AiService;
		$prompt = "You are a Twitter data analyst capable of analyzing a user's recent tweets to determine the fields they focus on." . 
			"You are fluent in multiple languages and can translate text from various languages into English." .
			"You are provided with a set of keywords related to a specific field and the content of a user's recent tweets." .
			"Attempt to determine the relevance between the keywords and the content, and assign a score between 0 and 100." .
			"Please output pretty format. Maybe json format:" .
			"{\"user_name\":\"bob\",\"keywords\":\"defi\",\"relevance_score\":66,\"explanation\":\"\"}" .
			"Explanation for the analysis for obtaining scores, three or four aspects are generally listed." .
			"keywords:$keywords;content:";
		$tweets = $this->tweets($screen_name);
		if (empty($tweets['data']))
		{
			return $this->res;
		}
		$summarize_res = $ai_service->gemini_generate_content($prompt . json_encode($tweets['data']));
		if (!empty($summarize_res['data']))
		{
			if (!isset($summarize_res['data']['candidates'][0]['content']))
			{
				return $this->res;
			}
			$text_summarize = $summarize_res['data']['candidates'][0]['content']['parts'][0]['text'];
			$text_summarize = str_replace('```json', '', $text_summarize);
			$text_summarize = str_replace('```', '', $text_summarize);
			$this->res['data'] = json_decode($text_summarize);
		}
		return $this->res;
	}

	public function metric_data(&$data)
	{
		$tweet_model = new TweetModel;
		$tweets = $tweet_model->get($data['twitter_user_name']);
		$tweet_count = count($tweets);
		if (!$tweet_count)
		{
			return;
		}
		$total_tweet_views = 0;
		$total_tweet_favorite_count = 0;
		$total_tweet_retweet_count = 0;
		$total_tweet_reply_count = 0;
		foreach ($tweets as $tweet)
		{
			$total_tweet_views += $tweet['view_count'];	
			$total_tweet_favorite_count += $tweet['favorite_count'];	
			$total_tweet_retweet_count += $tweet['retweet_count'];	
			$total_tweet_reply_count += $tweet['reply_count'];	
		}
		$data['twitter_average_post_reach'] = round($total_tweet_views / $tweet_count, 2);

		$data['twitter_interaction_rate'] = round(($total_tweet_favorite_count 
			+ $total_tweet_retweet_count
			+ $total_tweet_reply_count) / $tweet_count, 2);

		if ($data['twitter_following_count']) 
		{
			$data['twitter_content_likability'] = round($data['twitter_interaction_rate'] * $data['twitter_average_post_reach'] 
				/ $data['twitter_following_count'] , 2);
		}
		else 
		{
			$data['twitter_content_likability'] = 0.0;
		}
		$data['twitter_average_likes_per_post'] = round($total_tweet_favorite_count / $tweet_count, 2);
		$data['twitter_average_comments_per_post'] = round($total_tweet_reply_count / $tweet_count, 2);
		$data['twitter_average_retweets_per_post'] = round($total_tweet_retweet_count / $tweet_count, 2);
		$tweet_diff_day = 1;
		if ($tweet_count >= 2)
		{
			$date_start = new \DateTime($tweets[$tweet_count - 1]['created_at']);
			$date_end = new \DateTime($tweets[0]['created_at']);
			$interval = $date_start->diff($date_end);
			$tweet_diff_day = $interval->days;
		}
		$data['twitter_content_presence'] = round($tweet_diff_day / $tweet_count, 2);
		$data['twitter_content_web3_relevance'] = 0.0;
		$twitter_content_relevance_service = new TwitterContentRelevanceModel();	
		$res_content_relevance = $twitter_content_relevance_service->get($data['twitter_user_id'], 13);
		if (!empty($res_content_relevance))
		{
			$data['twitter_content_web3_relevance'] = $res_content_relevance['score'];			
		}

		$max_vals = array(
			"twitter_average_post_reach" => Redis::get('max_twitter_average_post_reach'),
			"twitter_interaction_rate" => Redis::get('max_twitter_interaction_rate'),
			"twitter_content_likability" => Redis::get('max_twitter_content_likability'),
			"twitter_average_likes_per_post" => Redis::get('max_twitter_average_likes_per_post'),
			"twitter_average_comments_per_post" => Redis::get('max_twitter_average_comments_per_post'),
			"twitter_average_retweets_per_post" => Redis::get('max_twitter_average_retweets_per_post'),
			"twitter_content_presence" => Redis::get('max_twitter_content_likability')
		);
		$weights = array(
			"twitter_average_post_reach" => 0.25,
			"twitter_interaction_rate" => 0.20,
			"twitter_content_likability" => 0.15,
			"twitter_average_likes_per_post" => 0.10,
			"twitter_average_comments_per_post" => 0.10,
			"twitter_average_retweets_per_post" => 0.15,
			"twitter_content_presence" => 0.05
		);
		$data['twitter_metric_max'] = $max_vals;
		$data['twitter_impact_score'] = round($data['twitter_average_post_reach'] / $max_vals['twitter_average_post_reach'] * $weights['twitter_average_post_reach'] 
			+ $data['twitter_interaction_rate'] / $max_vals['twitter_interaction_rate'] * $weights['twitter_interaction_rate']
			+ $data['twitter_content_likability'] / $max_vals['twitter_content_likability'] * $weights['twitter_content_likability']
			+ $data['twitter_average_likes_per_post'] / $max_vals['twitter_average_likes_per_post'] * $weights['twitter_average_likes_per_post']
			+ $data['twitter_average_comments_per_post'] / $max_vals['twitter_average_comments_per_post'] * $weights['twitter_average_comments_per_post']
			+ $data['twitter_average_retweets_per_post'] / $max_vals['twitter_average_retweets_per_post'] * $weights['twitter_average_retweets_per_post']
			+ $data['twitter_content_presence'] / $max_vals['twitter_content_presence'] * $weights['twitter_content_presence'], 2);
		$data['content_relevance'] = $twitter_content_relevance_service->top($data['twitter_user_id']);
	}

	public function update_twitter_content_relevance($user_id, $user_name, $category_id, $score, $explanation)
	{
		$twitter_content_relevance_service = new TwitterContentRelevanceModel();	
		return $twitter_content_relevance_service->insert($user_id, $user_name, $category_id, $score, $explanation);
	}

}
