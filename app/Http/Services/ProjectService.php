<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectModel;
use App\Http\Services\ProjectTaskApplicationService;


class ProjectService extends Service 
{
    public function project_new($token, $email, $logo, $twitter_user_name, $name, $desc, $category_id, $website, $code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}
		$project_model = new ProjectModel;
		if (!$project_model->insert($token, $email, $logo, $twitter_user_name, 
			$name, $desc, $category_id, $website))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

    public function project_detail($project_id)
	{
		$project_model = new ProjectModel;
		$this->res['data'] = $project_model->get($project_id);
		return $this->res;
	}

    public function project_list($token)
	{
		$project_model = new ProjectModel;
		$this->res['data'] = $project_model->list($token);
		return $this->res;
	}

	public function project_index($kol_id, $days)
	{
		$application_service = new ProjectTaskApplicationService;				
		$this->res['data']['upcoming_task_list'] = $application_service->upcoming_task_list($kol_id);
		$project_model = new ProjectModel;
		$this->res['data']['top_project'] = $project_model->top_project();
		return $this->res;
	}

	public function project_setting($project_id, $name, $desc, $logo, $email)
	{
		$project_model = new ProjectModel;
		if (!$project_model->setting($project_id, $name, $desc, $logo, $email))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

}
