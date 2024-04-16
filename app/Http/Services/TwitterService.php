<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\TwitterModel;


class TwitterService extends Service 
{
	public function auth()
	{
		$session_id = Str::uuid();
		$url = config('config.twitter_url_base') . "/twitter/auth?session_id=$session_id";
		try {
			$headers = [];
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				$this->res['data']['session_id'] = $data['data']['session_id'];
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $e->getMessage());
		}  
		return $this->res;
	}	

	public function user($session_id, $oauth_verifier)
	{
		$url = config('config.twitter_url_base') . "/twitter/user?session_id=$session_id&oauth_verifier=$oauth_verifier";
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
			Log::error($e->getMessage());
			return $this->error_response($session_id, ErrorCodes::ERROR_CODE_TWITTER_USER_FAULED, $e->getMessage());
		}  
		return $this->res;
	}	

}
