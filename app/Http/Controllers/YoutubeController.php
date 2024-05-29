<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Constants\ErrorCodes;
use App\Http\Services\YoutubeService;


class YoutubeController extends Controller
{
	public function auth(Request $request)
	{
		$debug = $request->input('debug',0);
		$redirect_uri = $request->input('redirect_uri', config('config.twitter_redirect_uri'));
		try {
			$validated_data = $request->validate([
				'code' => 'required|string',
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new YoutubeService();
		return $service->auth($redirect_uri, $validated_data['code'], $debug);
	}

	public function user(Request $request)
	{
		$debug = $request->input('debug',0);
		try {
			$validated_data = $request->validate([
				'access_token' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new YoutubeService();
		return $service->user($validated_data['access_token'], $debug);
	}

}
