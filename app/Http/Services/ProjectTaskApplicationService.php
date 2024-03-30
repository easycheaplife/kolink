<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskApplicationModel;


class ProjectTaskApplicationService extends Service 
{
    public function task_application($kol_id, $task_id, $quotation, $reason)
	{
		$application_model = new ProjectTaskApplicationModel;
		if (!$application_model->insert($kol_id, $task_id, $quotation, $reason))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

	public function task_application_detail($application_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->get($application_id);	
	}

	public function task_application_cancel($kol_id, $application_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->get($application_id);	
		if (empty($application_detail))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($kol_id != $application_detail['kol_id'])
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS);		
		}
		return $application_model->update_status($application_id, config('config.task_status')['cancel']);
	}
}
