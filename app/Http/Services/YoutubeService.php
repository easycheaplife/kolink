<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\YoutubeUserModel;


class YoutubeService extends Service 
{
	public function auth($redirect_uri, $code, $debug)
	{
		try {
			$url = 'https://oauth2.googleapis.com/token';
			if ($debug)
			{
				$url = config('config.youtube_service_url_base') . '/youtube/auth';
				$headers = [];
				$response = Http::withHeaders($headers)
				->get($url);
				$data = $response->json();
				return $data;
				$this->res['data'] = $data['data'];
				return $this->res;
			}

			$response = Http::asForm()->post($url, [
				'code' => $code,
				'grant_type' => 'authorization_code',
				'client_id' => config('config.youtube_client_id'),
				'client_secret' => config('config.youtube_client_secret'),
				'redirect_uri' => $redirect_uri,
				'grant_type' => 'authorization_code',
			]);

			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				$this->res['data'] = $data;
			}
			else {
				$error_message = "http post $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($code, ErrorCodes::ERROR_CODE_YOUTUBE_USER_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($code, ErrorCodes::ERROR_CODE_YOUTUBE_USER_FAILED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function user($access_token, $debug)
	{
		$url = "https://youtube.googleapis.com/youtube/v3/channels?part=snippet,statistics&mine=true&key=" . config('config.youtube_client_id'); 
		if ($debug)
		{
			$url = config('config.youtube_service_url_base') . '/youtube/user';
		}
		try {
			$headers = ['Authorization' => "Bearer $access_token"];
			$response = Http::withHeaders($headers)
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				$this->res['data'] = $data['data'];
				$youtube_user_model = new YoutubeUserModel;
				$youtube_user_model->insert($data['data']);
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

}
