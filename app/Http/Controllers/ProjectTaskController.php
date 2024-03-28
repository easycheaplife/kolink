<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\ProjectTaskService;


class ProjectTaskController extends Controller
{
	public function task_new(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'project_id' => 'required|integer',
				'title' => 'required|string',
				'desc' => 'required|string',
				'social_platform_id' => 'required|integer',
				'kol_max' => 'required|integer',
				'kol_min_followers' => 'required|integer',
				'kol_like_min' => 'required|integer',
				'kol_socre_min' => 'required|integer',
				'start_time' => 'required|integer',
				'applition_ddl_time' => 'required|integer',
				'upload_ddl_time' => 'required|integer',
				'blockchain_id' => 'required|integer',
				'token_id' => 'required|integer',
				'reward_min' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskService();
		return $service->task_new(
			$validated_data['project_id'],
			$validated_data['title'],
			$validated_data['desc'],
			$validated_data['social_platform_id'],
			$validated_data['kol_max'],
			$validated_data['kol_min_followers'],
			$validated_data['kol_like_min'],
			$validated_data['kol_socre_min'],
			$validated_data['start_time'],
			$validated_data['applition_ddl_time'],
			$validated_data['upload_ddl_time'],
			$validated_data['blockchain_id'],
			$validated_data['token_id'],
			$validated_data['reward_min']
		);
	}

	public function task_list(Request $request)
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
		$service = new ProjectTaskService();
		return $service->task_list(
			$validated_data['project_id']
		);
	}

	public function task_detail(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'task_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskService();
		return $service->task_detail(
			$validated_data['task_id']
		);
	}
}
