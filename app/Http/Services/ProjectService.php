<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectModel;
use App\Http\Services\ProjectTaskApplicationService;
use App\Http\Services\ProjectTaskViewService;


class ProjectService extends Service 
{
    public function project_new($token, $email, $logo, $twitter_user_id, $twitter_user_name, $name, $desc, $category_id, $website, $code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email, config('config.verification_type')['project']);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}
		$project_model = new ProjectModel;
		$last_insert_id = 0;
		if (!$project_model->insert($token, $email, $logo, $twitter_user_id, $twitter_user_name, 
			$name, $desc, $category_id, $website, $last_insert_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		$this->res['data']['id'] = $last_insert_id;
		return $this->res;
	}	

    public function project_detail($project_id)
	{
		$project_model = new ProjectModel;
		$this->res['data'] = $project_model->get($project_id);
		return $this->res;
	}

    public function login($token)
	{
		$project_model = new ProjectModel;
		$data = $project_model->login($token);
		if (empty($data))
		{
			$this->res['data'] = array();
		}
		else{
			$this->res['data'] = $data;
		}
		return $this->res;
	}

    public function project_list($token, $page, $size)
	{
		$project_model = new ProjectModel;
		$this->res['data']['list'] = $project_model->list($token, $page, $size);
		$this->res['data']['total'] = $project_model->count($token);
		return $this->res;
	}

	public function project_index($kol_id, $days)
	{
		$task_service = new ProjectTaskService;				
		$this->res['data']['upcoming_task'] = $task_service->upcoming_task();
		$project_model = new ProjectModel;
		$this->res['data']['top_project'] = $project_model->top_project();
		$view_service = new ProjectTaskViewService;
		foreach ($this->res['data']['top_project'] as $key => $project)
		{
			$this->res['data']['top_project'][$key]['view_count'] = $view_service->get_project_viewer_count($project['id']);	
		}
		$application_service = new ProjectTaskApplicationService;
		$trending_task = $view_service->trending_task();
		$task_ids = [];
		$trending_task_tmp = [];
		if (count($trending_task))
		{
			foreach ($trending_task as $task)
			{
				$task_ids[] = $task->task_id;	
				$trending_task_tmp[$task->task_id] = $task->view_count;
			}
			$tasks = $task_service->kol_task_list($task_ids);
			foreach ($tasks as $task)
			{
				$task['view_count'] = $trending_task_tmp[$task['id']];
			}
			$this->res['data']['trending_task'] = $tasks;
		}
		else
		{
			$this->res['data']['trending_task'] = $task_service->trending_task();		
		}
		foreach ($this->res['data']['trending_task'] as $key => $task)
		{
			$application = $application_service->kol_task_status($kol_id, $task->id);
			if (!empty($application))
			{
				$this->res['data']['trending_task'][$key]['status'] = $application['status'];
				$this->res['data']['trending_task'][$key]['application'] = $application;
			}
			else
			{
				$this->res['data']['trending_task'][$key]['status'] = -1;
				$this->res['data']['trending_task'][$key]['application'] = array();
			}
			$this->res['data']['trending_task'][$key]['project_detail'] = $project_model->get($task->project_id);
			$application_result = $application_service->application_eligibility($kol_id, $task->id);
			$this->res['data']['trending_task'][$key]['application_eligibility'] = $application_result['code'] == ErrorCodes::ERROR_CODE_SUCCESS ? 1 : 0;
			$this->res['data']['trending_task'][$key]['application_num'] = $application_service->application_kol_num($task->id);
		}
		foreach ($this->res['data']['upcoming_task'] as $key => $task)
		{
			$application_result = $application_service->application_eligibility($kol_id, $task->id);
			$this->res['data']['upcoming_task'][$key]['application_eligibility'] = $application_result['code'] == ErrorCodes::ERROR_CODE_SUCCESS ? 1 : 0;
			$this->res['data']['upcoming_task'][$key]['application_num'] = $application_service->application_kol_num($task->id);
		}
		return $this->res;
	}

	public function project_setting($project_id, $name, $desc, $logo, $email)
	{
		$project_model = new ProjectModel;
		if (!$project_model->setting($project_id, $name, $desc, $logo, $email))
		{
			return $this->error_response($project_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

}
