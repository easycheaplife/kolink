<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Http\Services\KolService;
use App\Models\EtherscanModel;


class EtherscanService extends Service 
{
	public function load_all_tokens()
	{
		$kol_service = new KolService;
		$total = $kol_service->token_count();
		Log::info("total:$total");
		$size = config('config.default_page_size');
		$page = $total / $size;
		for ($i = 0; $i <= $page; ++$i)
		{
			$tokens = $kol_service->get_tokens($i, $size);
			foreach ($tokens as $token)
			{
				$this->address_info($token['token']);
			}
		}
	}

	public function address_info($address)
	{
		$created_at = time();
		$token_count = 0;
		$nft_count = 0;
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
			Log::info($url);
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				if (is_array($data['result']) && !empty($data['result']))
				{
					$created_at = $data['result'][0]['timeStamp'];
				}
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAILED, $error_message);
			}
			$contractaddress = config('config.contractaddress');
			$offset = 9999;
			$url = "$etherscan_url_base?module=account&action=tokentx" .
				"&address=$address" . 
				"&page=$page&offset=$offset&startblock=$start_block" . 
				"&endblock=$end_block&sort=asc&apikey=$etherscan_api_key";
			Log::info($url);
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			if ($response->successful()) {
				$data = $response->json();
				// Log::info($data);
				if (is_array($data['result']) && !empty($data['result']))
				{
					$token_count = count($data['result']);
				}
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAILED, $error_message);
			}

			$url = "$etherscan_url_base?module=account&action=tokennfttx" . 
				"&address=$address" .
				"&page=$page&offset=$offset&startblock=$start_block&endblock=$end_block" . 
				"&sort=asc&apikey=$etherscan_api_key";
			$response = Http::withHeaders($headers)
				->timeout(config('config.http_timeout'))
				->get($url);
			// Log::info($url);
			if ($response->successful()) {
				$data = $response->json();
				Log::info($data);
				if (is_array($data['result']) && !empty($data['result']))
				{
					$nft_count = count($data['result']);
				}
				$etherscan_service = new EtherscanModel;
				$etherscan_service->insert($address, $created_at, $token_count, $nft_count);
				Log::info("address_info===address:$address,created_at:$created_at,token_count:$token_count,nft_count:$nft_count");
			}
			else {
				$error_message = "http get $url failed, status:" . $response->status() . ' ' . $response->body();
				Log::error($error_message);
				return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAILED, $error_message);
			}
		} catch (\Exception $e) 
		{   
			Log::error($e->getMessage());
			return $this->error_response($address, ErrorCodes::ERROR_CODE_ETHERSCAN_API_FAILED, $e->getMessage());
		}  
	}

	public function get_token($address)
	{
		$etherscan_service = new EtherscanModel;
		return $etherscan_service->get($address);
	}

	public function get_column_count_max($column_name)
	{
		$etherscan_model = new EtherscanModel;
		return $etherscan_model->get_column_count_max($column_name);
	}

	public function get_column_count_min($column_name)
	{
		$etherscan_model = new EtherscanModel;
		return $etherscan_model->get_column_count_min($column_name);
	}

}
