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

	public function project_detail(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'project_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new projectService();
		return $service->project_detail(
			$validated_data['project_id']
		);
	}

}
