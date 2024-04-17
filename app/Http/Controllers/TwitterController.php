<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Constants\ErrorCodes;
use App\Http\Services\TwitterService;


class TwitterController extends Controller
{
	public function auth(Request $request)
	{
		$redirect_uri = $request->input('redirect_uri','');
		try {
			$validated_data = $request->validate([
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->auth($redirect_uri);
	}

	public function user(Request $request)
	{
		$redirect_uri = $request->input('redirect_uri','');
		try {
			$validated_data = $request->validate([
				'session_id' => 'required|string',
				'oauth_verifier' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->user($validated_data['session_id'],
			$validated_data['oauth_verifier'],
			$redirect_uri);
	}

}
