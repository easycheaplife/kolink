<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;


class EtherscanService extends Service 
{
	public function address_info($address)
	{
		$created_at = time();
		$etherscan_api_key = config('config.etherscan_api_key');
		$etherscan_url_base = config('config.etherscan_url_base');
		$headers = [];
		try {
			$start_block = 0;
			$end_block = 99999999;
			$page = 1;
			$offset = 1;
			$url = "$etherscan_url_base?module=account&action=txlist" .
				"&address=$address&startblock=$start_block&endblock=$end_block" .
				"&page=$page&offset=$offset&sort=asc&apikey=$etherscan_api_key";
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				if (!empty($data))
				{
					$created_at = $data['result']['timeStamp'];
				}
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAULED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAULED, $e->getMessage());
		}  

	}
}
