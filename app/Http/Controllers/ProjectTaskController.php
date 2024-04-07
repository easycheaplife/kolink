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
		$kol_max = $request->input('kol_max', 0);
		$kol_min_followers = $request->input('kol_min_followers', 0);
		$kol_like_min = $request->input('kol_like_min', 0);
		$kol_score_min = $request->input('kol_score_min', 0);
		$applition_ddl_time = $request->input('applition_ddl_time', 0);
		try {
			$validated_data = $request->validate([
				'project_id' => 'required|integer',
				'title' => 'required|string',
				'desc' => 'required|string',
				'social_platform_id' => 'required|integer',
				'start_time' => 'required|integer',
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
			$kol_max,
			$kol_min_followers,
			$kol_like_min,
			$kol_score_min,
			$validated_data['start_time'],
			$applition_ddl_time,
			$validated_data['upload_ddl_time'],
			$validated_data['blockchain_id'],
			$validated_data['token_id'],
			$validated_data['reward_min']
		);
	}

	public function task_list(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
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
			$validated_data['project_id'],
			$page,
			$size
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

	public function task_all(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
		$task_type = $request->input('task_type', 0);
		$kol_id = $request->input('kol_id', 0);
		try {
			$validated_data = $request->validate([
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskService();
		return $service->all_task(
			$kol_id,
			$task_type,
			$page,
			$size
		);
	}

	public function task_setting(Request $request)
	{
		$kol_max = $request->input('kol_max', 0);
		$kol_min_followers = $request->input('kol_min_followers', 0);
		$kol_like_min = $request->input('kol_like_min', 0);
		$kol_score_min = $request->input('kol_score_min', 0);
		$applition_ddl_time = $request->input('applition_ddl_time', 0);
		try {
			$validated_data = $request->validate([
				'task_id' => 'required|integer',
				'title' => 'required|string',
				'desc' => 'required|string',
				'social_platform_id' => 'required|integer',
				'start_time' => 'required|integer',
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
		return $service->task_setting(
			$validated_data['task_id'],
			$validated_data['title'],
			$validated_data['desc'],
			$validated_data['social_platform_id'],
			$kol_max,
			$kol_min_followers,
			$kol_like_min,
			$kol_score_min,
			$validated_data['start_time'],
			$applition_ddl_time,
			$validated_data['upload_ddl_time'],
			$validated_data['blockchain_id'],
			$validated_data['token_id'],
			$validated_data['reward_min']
		);
	}

}
