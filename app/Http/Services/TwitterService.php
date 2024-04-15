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
		$url = "http://localhost:8000/twitter/auth";
		try {
			$response = Http::withHeaders([
				'Accept' => 'application/json',
			])->get($url, [
				'session_id' => $session_id
			]);
			if ($response->successful()) {
				$data = $response->json();
				$this->res['data'] = $data;
				Log::info($data);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
		}  
		return $this->res;
	}	

}
