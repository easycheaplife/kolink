<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;


class AiService extends Service 
{
	public function text_summarize($text)
	{
		try {
			$api_key = config('config.gemini_api_key');
			$url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=$api_key";

			$headers = ['Content-Type' => 'application/json'];
			$response = Http::withHeaders($headers)->post($url, [
				'contents' => [
					[
						'parts' => [
							['text' => $text]
						]
					]
				]
			]);

			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				$this->res['data'] = $data;
			}
			else {
				$error_message = "http post $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($code, ErrorCodes::ERROR_CODE_GEMINI_API_REQUEST_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($code, ErrorCodes::ERROR_CODE_GEMINI_API_REQUEST_FAILED, $e->getMessage());
		}  
		return $this->res;
	}	

}
