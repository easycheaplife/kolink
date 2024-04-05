<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskApplicationModel;
use App\Http\Services\ProjectTaskService;


class ProjectTaskApplicationService extends Service 
{
    public function task_application_new($kol_id, $task_id, $quotation, $reason)
	{
		$application_model = new ProjectTaskApplicationModel;
		if (!$application_model->insert($kol_id, $task_id, $quotation, $reason))
		{
			return $this->error_response($task_id, ErrorCodes::ERROR_CODE_DB_ERROR,
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
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($kol_id != $application_detail['kol_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS);		
		}
		if (!$application_model->update_status($application_id, config('config.task_status')['cancel']))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_edit($kol_id, $application_id, $quotation, $reason)
	{
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->get($application_id);	
		if (empty($application_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($kol_id != $application_detail['kol_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS);		
		}
		if ($application_detail['status'] >= config('config.task_status')['accept'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_EDIT);		
		}
		if (!$application_model->update_quotation_and_reason($application_id, $quotation, $reason))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_review($project_id, $application_id, $status)
	{
		if (!in_array($status, [
			config('config.task_status')['pengding'], 
			config('config.task_status')['declined'], 
			config('config.task_status')['accept']])
		)
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CODE_ERROR);		
		}
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->get($application_id);	
		if (empty($application_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		$task_service = new ProjectTaskService;
		$task_detail = $task_service->task_detail($application_detail['task_id']);
		if (empty($task_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($project_id != $task_detail['data']['project_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_PROJECT_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_PROJECT_IS_NOT_YOURS);		
		}
		if ($application_detail['status'] != config('config.task_status')['application'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW);		
		}
		if (!$application_model->update_status($application_id, $status))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_upload($kol_id, $application_id, $verification)
	{
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->get($application_id);	
		if (empty($application_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($kol_id != $application_detail['kol_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_NOT_YOURS);		
		}
		if ($application_detail['status'] != config('config.task_status')['accept'])
		{
			return $this->error_response($application_id, ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_UPLOAD);		
		}
		if (!$application_model->update_verification_and_status($application_id, $verification, config('config.task_status')['upload']))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_finish($project_id, $application_id, $comment)
	{
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->get($application_id);	
		if (empty($application_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		$task_service = new ProjectTaskService;
		$task_detail = $task_service->task_detail($application_detail['task_id']);
		if (empty($task_detail))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($project_id != $task_detail['data']['project_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_PROJECT_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_PROJECT_IS_NOT_YOURS);		
		}
		if ($application_detail['status'] != config('config.task_status')['upload'])
		{
			return $this->error_response($application_id, ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH);		
		}
		if (!$application_model->update_comment_and_status($application_id, $comment,  config('config.task_status')['finish']))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function kol_task_list($kol_id, $status, $page, $size)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->kol_task_list($kol_id, $status, $page, $size);	
	}

	public function kol_task_count($kol_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->kol_task_count($kol_id);	
	}

	public function task_list($task_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->list($task_id);	
	}

	public function upcoming_task_list($kol_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->upcoming_task_list($kol_id);	
	}

}
