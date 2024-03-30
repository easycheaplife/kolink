<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\ProjectTaskApplicationService;


class ProjectTaskApplicationController extends Controller
{
	public function task_application(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'task_id' => 'required|integer',
				'quotation' => 'required|integer',
				'reason' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskApplicationService();
		return $service->task_application(
			$validated_data['kol_id'],
			$validated_data['task_id'],
			$validated_data['quotation'],
			$validated_data['reason']
		);
	}

	public function task_application_detail(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'application_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskApplicationService();
		return $service->task_application_detail(
			$validated_data['application_id']
		);
	}

	public function task_application_cancel(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'application_id' => 'required|integer'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskApplicationService();
		return $service->task_application_cancel(
			$validated_data['kol_id'],
			$validated_data['application_id']
		);
	}

	public function task_application_edit(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'application_id' => 'required|integer',
				'quotation' => 'required|integer',
				'reason' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskApplicationService();
		return $service->task_application_edit(
			$validated_data['kol_id'],
			$validated_data['application_id'],
			$validated_data['quotation'],
			$validated_data['reason']
		);
	}

}
