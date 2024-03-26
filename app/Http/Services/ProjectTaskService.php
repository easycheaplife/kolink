<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskModel;


class ProjectTaskService extends Service 
{
	public function project_new($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers, 
		$kol_like_min, $kol_socre_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
		$token_id, $reward_min)
	{
		$project_task_model = new ProjectTaskModel;
		if (!$project_task_model->insert($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers, 
			$kol_like_min, $kol_socre_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
			$token_id, $reward_min))
		{
			return $this->error_response($project_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

}
