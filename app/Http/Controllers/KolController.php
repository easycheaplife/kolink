<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Http\Services\KolService;


class KolController extends Controller
{
	public function kol_new(Request $request)
	{
		$twitter_user_id = $request->input('twitter_user_id', 0);
		$twitter_user_name = $request->input('twitter_user_name', '');
		$twitter_avatar = $request->input('twitter_avatar', '');
		$twitter_followers = $request->input('twitter_followers', 0);
		$twitter_subscriptions = $request->input('twitter_subscriptions', 0);
		$channel_id = $request->input('channel_id', 0);
		try {
			$validated_data = $request->validate([
				'token' => 'required|string',
				'email' => 'required|email',
				'region_id' => 'required|string',
				'category_id' => 'required|string',
				'language_id' => 'required|string',
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
			$twitter_user_id,
			$twitter_user_name,
			$twitter_avatar,
			$twitter_followers,
			$twitter_subscriptions,
			$validated_data['region_id'],
			$validated_data['category_id'],
			$validated_data['language_id'],
			$channel_id,
			$validated_data['code']
		);
	}

	public function kol_list(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
		$sort_type = $request->input('sort_type', 0);
		$sort_field = $request->input('sort_field', 0);
		$region_id = $request->input('region_id', '');
		$category_id = $request->input('category_id', '');
		$language_id = $request->input('language_id', '');
		$channel_id = $request->input('channel_id', '0');
		$service = new KolService();
		return $service->kol_list(
			$region_id,
			$category_id,
			$language_id,
			$channel_id,
			$sort_type,
			$sort_field,
			$page,
			$size
		);
	}

	public function kol_detail(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new KolService();
		return $service->kol_detail(
			$validated_data['kol_id']
		);
	}

	public function login(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'token' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new KolService();
		return $service->login(
			$validated_data['token']
		);
	}

	public function kol_task_list(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
		$status = $request->input('status', -1);
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new KolService();
		return $service->kol_task_list(
			$validated_data['kol_id'],
			$status,
			$page,
			$size
		);
	}

	public function kol_setting(Request $request)
	{
		$channel_id = $request->input('channel_id', 0);
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'email' => 'required|email',
				'twitter_user_name' => 'required|string',
				'twitter_avatar' => 'required|string',
				'twitter_followers' => 'required|integer',
				'twitter_subscriptions' => 'required|integer',
				'region_id' => 'required|string',
				'category_id' => 'required|string',
				'language_id' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new KolService();
		return $service->kol_setting(
			$validated_data['kol_id'],
			$validated_data['email'],
			$validated_data['twitter_user_name'],
			$validated_data['twitter_avatar'],
			$validated_data['twitter_followers'],
			$validated_data['twitter_subscriptions'],
			$validated_data['region_id'],
			$validated_data['category_id'],
			$validated_data['language_id'],
			$channel_id);
	}


}
