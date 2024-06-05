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
		$youtube_user_id = $request->input('youtube_user_id', '');
		$channel_id = $request->input('channel_id', '');
		$invite_code = $request->input('invite_code', '');
		try {
			$validated_data = $request->validate([
				'twitter_user_id' => 'required_without:youtube_user_id',
				'youtube_user_id' => 'required_without:twitter_user_id',
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
			$youtube_user_id,
			$validated_data['region_id'],
			$validated_data['category_id'],
			$validated_data['language_id'],
			$channel_id,
			$validated_data['code'],
			$invite_code
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
		$channel_id = $request->input('channel_id', '');
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
		$channel_id = $request->input('channel_id', '');
		$twitter_user_id = $request->input('twitter_user_id', 0);
		$youtube_user_id = $request->input('youtube_user_id', 0);
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'email' => 'required|email',
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
			$twitter_user_id,
			$youtube_user_id,
			$validated_data['email'],
			$validated_data['region_id'],
			$validated_data['category_id'],
			$validated_data['language_id'],
			$channel_id);
	}

}
