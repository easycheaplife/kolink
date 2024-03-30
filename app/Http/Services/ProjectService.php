<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectModel;


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

}
