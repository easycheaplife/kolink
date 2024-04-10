<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskViewModel;
use App\Http\Services\ProjectTaskService;


class ProjectTaskViewService extends Service 
{
    public function task_view($kol_id, $project_id, $task_id, $avatar)
	{
		$task_service = new ProjectTaskService;
		$task_detail = $task_service->task_detail($task_id);
		Log::info($task_detail);
		if (!empty($task_detail['data']))
		{
			if ($project_id != $task_detail['data']['project_id'])
			{
				return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT,
					ErrorDescs::ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT);		
			}
		}
		else {
			return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT,
				ErrorDescs::ERROR_CODE_TASK_NOT_BELONG_TO_PROJECT);		
		}
		$view_model = new ProjectTaskViewModel;
		if (!$view_model->insert($kol_id, $project_id, $task_id, $avatar))
		{
			return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

	public function get_task_viewer($task_id)
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->get($task_id);	
	}

	public function get_task_viewer_count($task_id)
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->get_task_count($task_id);	
	}

	public function get_project_viewer_count($task_id)
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->get_project_count($task_id);	
	}

	public function trending_task()
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->trending_task();	
	}

}
