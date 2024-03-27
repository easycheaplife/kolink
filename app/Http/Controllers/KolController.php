<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\KolService;


class KolController extends Controller
{
	public function kol_new(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'token' => 'required|string',
				'email' => 'required|email',
				'twitter_user_name' => 'required|string',
				'twitter_avatar' => 'required|string',
				'twitter_followers' => 'required|integer',
				'twitter_subscriptions' => 'required|integer',
				'region_id' => 'required|integer',
				'category_id' => 'required|integer',
				'language_id' => 'required|integer',
				'channel_id' => 'required|integer',
				'code' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new KolService();
		return $service->kol_new(
			$validated_data['token'],
			$validated_data['email'],
			$validated_data['twitter_user_name'],
			$validated_data['twitter_avatar'],
			$validated_data['twitter_followers'],
			$validated_data['twitter_subscriptions'],
			$validated_data['region_id'],
			$validated_data['category_id'],
			$validated_data['language_id'],
			$validated_data['channel_id'],
			$validated_data['code']
		);
	}
}
