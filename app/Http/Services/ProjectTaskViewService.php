<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskViewModel;


class ProjectTaskViewService extends Service 
{
    public function task_view($kol_id, $task_id, $avatar)
	{
		$view_model = new ProjectTaskViewModel;
		if (!$view_model->insert($kol_id, $task_id, $avatar))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

	public function get_task_viewer($task_id)
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->get($task_id);	
	}

	public function trending_task()
	{
		$view_model = new ProjectTaskViewModel;
		return $view_model->trending_task();	
	}

}
