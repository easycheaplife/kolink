<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\ProjectTaskViewService;

class ProjectTaskViewController extends Controller
{
	public function task_view(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
				'project_id' => 'required|integer',
				'task_id' => 'required|integer',
				'avatar' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new ProjectTaskViewService();
		return $service->task_view(
			$validated_data['kol_id'],
			$validated_data['project_id'],
			$validated_data['task_id'],
			$validated_data['avatar']
		);
	}
}
