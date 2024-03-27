<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\ProjectService;


class ProjectController extends Controller
{
	public function project_new(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'token' => 'required|string',
				'email' => 'required|email',
				'logo' => 'required|string',
				'twitter_user_name' => 'required|string',
				'name' => 'required|string',
				'desc' => 'required|string',
				'category_id' => 'required|integer',
				'website' => 'required|string',
				'code' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectService();
		return $service->project_new(
			$validated_data['token'],
			$validated_data['email'],
			$validated_data['logo'],
			$validated_data['twitter_user_name'],
			$validated_data['name'],
			$validated_data['desc'],
			$validated_data['category_id'],
			$validated_data['website'],
			$validated_data['code']
		);
	}

	public function find_kol(Request $request)
	{
		$region_id = $request->input('$region_id', 0);
		$category_id = $request->input('$category_id', 0);
		$language_id = $request->input('$language_id', 0);
		$channel_id = $request->input('$channel_id', 0);
		$service = new ProjectService();
		return $service->find_kol(
			$region_id,
			$language_id,
			$category_id,
			$channel_id
		);
	}
}
