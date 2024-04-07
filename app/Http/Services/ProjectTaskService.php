<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskModel;
use App\Http\Services\ProjectTaskService;
use App\Http\Services\ProjectTaskViewService;
use App\Http\Services\ProjectService;


class ProjectTaskService extends Service 
{
	public function task_new($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers, 
		$kol_like_min, $kol_score_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
		$token_id, $reward_min)
	{
		$project_task_model = new ProjectTaskModel;
		if (!$project_task_model->insert($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers, 
			$kol_like_min, $kol_score_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
			$token_id, $reward_min))
		{
			return $this->error_response($project_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

	public function task_list($project_id, $page, $size)
	{
		$project_task_model = new ProjectTaskModel;
		$tasks = $project_task_model->list($project_id, $page, $size);
		foreach($tasks as $task)
		{
			$this->res['data']['list'][] = $task;
		}
		$this->res['data']['total'] = $project_task_model->count($project_id);
		return $this->res;
	}

	public function task_detail($task_id)
	{
		$project_task_model = new ProjectTaskModel;
		$task = $project_task_model->detail($task_id);

		$task_view_service = new ProjectTaskViewService;
		$task['viewer'] = $task_view_service->get_task_viewer($task['id']);

		$task_application_service = new ProjectTaskApplicationService;
		$task['application'] = $task_application_service->task_list($task['id']);

		$this->res['data'] = $task;
		return $this->res;
	}

	public function kol_task_list($task_ids)
	{
		$project_task_model = new ProjectTaskModel;
		$tasks = $project_task_model->get_tasks($task_ids);
		return $tasks;
	}

	public function upcoming_task()
	{
		$project_task_model = new ProjectTaskModel;
		$tasks = $project_task_model->upcoming_task();
		return $tasks;
	}

	public function trending_task()
	{
		$project_task_model = new ProjectTaskModel;
		$tasks = $project_task_model->trending_task();
		return $tasks;
	}

	public function all_task($kol_id, $task_type, $page, $size)
	{
		$task_type_all = 0;					
		$task_type_ongoing = 1;					
		$task_type_upcoming = 2;					
		$project_task_model = new ProjectTaskModel;
		$project_service = new ProjectService;
		$project_taks_view_service = new ProjectTaskViewService;
		if ($task_type == $task_type_all)
		{
			$this->res['data']['list'] = $project_task_model->all_task($page, $size);
			$this->res['data']['total'] = $project_task_model->all_task_count();
		}
		else if ($task_type == $task_type_ongoing)
		{
			$this->res['data']['list'] = $project_task_model->ongoing_task($page, $size);
			$this->res['data']['total'] = $project_task_model->oongoing_task_count();
		}	
		else if ($task_type == $task_type_upcoming)
		{
			$this->res['data']['list'] = $project_task_model->upcoming_task($page, $size);
			$this->res['data']['total'] = $project_task_model->upcoming_task_count();
		}
		foreach ($this->res['data']['list'] as $key => $task)
		{
			$project_detail = $project_service->project_detail($task->project_id);	
			$this->res['data']['list'][$key]['project_detail'] = $project_detail['data']; 
			$this->res['data']['list'][$key]['viewer_count'] = $project_taks_view_service->get_task_viewer_count($task->id);
		}
		return $this->res;
	}

}
