<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\ProjectTaskApplicationModel;
use App\Http\Services\KolService;
use App\Http\Services\ProjectTaskService;
use App\Http\Services\TransactionQueueService;


class ProjectTaskApplicationService extends Service 
{
    public function task_application_new($kol_id, $task_id, $quotation, $reason)
	{
		$application_result = $this->application_eligibility($kol_id, $task_id);
		if ($application_result['code'] != ErrorCodes::ERROR_CODE_SUCCESS)
		{
			return $application_result;	
		}
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
/*
		$transaction_queue_service = new TransactionQueueService;
		$transaction_queue_service->push($application_detail['web3_hash'], config('config.transaction_type')['cancel_lock']);
*/

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

	public function task_application_review($project_id, $application_id, $status, $web3_hash, $declined_desc)
	{
		if (!in_array($status, [
			config('config.task_status')['pending'], 
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
		if (empty($task_detail['data']))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_IS_MISSING,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_IS_MISSING);		
		}
		if ($project_id != $task_detail['data']['project_id'])
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_PROJECT_IS_NOT_YOURS,
				ErrorDescs::ERROR_CODE_PROJECT_IS_NOT_YOURS);		
		}
		if (!in_array($application_detail['status'], [
			config('config.task_status')['pending'], 
			config('config.task_status')['application']])
		)
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_REVIEW);		
		}
		if ($status == config('config.task_status')['accept'])
		{
			$status = config('config.task_status')['lock_pending'];
		}
		if (!$application_model->update_web3_hash_and_status($application_id, $web3_hash, $status, $declined_desc))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_upload($kol_id, $application_id, $verification, $url)
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
		if (!$application_model->update_verification_and_status($application_id, $verification, $url, config('config.task_status')['upload']))
		{
			return $this->error_response($application_id, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}

	public function task_application_finish($project_id, $application_id, $comment, $status)
	{
		if (!in_array($status, [
			config('config.task_status')['finish'], 
			config('config.task_status')['fail']])
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
		if ($application_detail['status'] != config('config.task_status')['upload'])
		{
			return $this->error_response($application_id, ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH,
				ErrorDescs::ERROR_CODE_TASK_APPLICATION_STATUS_CAN_NOT_FINISH);		
		}
		if ($status == config('config.task_status')['finish'])
		{
			$status = config('config.task_status')['settle_pending'];
		}
		if (!$application_model->update_comment_and_status($application_id, $comment, $status))
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

	public function kol_task_list_count($kol_id, $status)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->kol_task_list_count($kol_id, $status);	
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

	public function kol_task_status($kol_id, $task_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->kol_task_status($kol_id, $task_id);	
	}

	public function task_close($task_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->task_close($task_id);	
	}

	public function task_in_progross($task_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->task_in_progross($task_id);	
	}

	public function tansaction_timeout_check()
	{
		$application_model = new ProjectTaskApplicationModel;
		$application_detail = $application_model->task_review_timeout();	
		if (empty($application_detail))
		{
			return;
		}
		$transaction_queue_service = new TransactionQueueService;
		$transaction_queue_service->push($application_detail['web3_hash'], config('config.transaction_type')['delegate_settle']);
		Log::info($application_detail);
	}

	public function application_kol_num($task_id)
	{
		$application_model = new ProjectTaskApplicationModel;
		return $application_model->application_kol_num($task_id);
	}

	public function application_eligibility($kol_id, $task_id)
	{
		$task_service = new ProjectTaskService;
		$task_detail = $task_service->task_detail($task_id);
		if (empty($task_detail['data']))
		{
			return $this->error_response($task_id, ErrorCodes::ERROR_CODE_TASK_IS_NOT_EXIST,
				ErrorDescs::ERROR_CODE_TASK_IS_NOT_EXIST);		
		}
		$max_kol_num = $task_detail['data']['kol_max'];
		if ($max_kol_num > 0)
		{
			$application_kol_num = $this->application_kol_num($task_id);	
			if ($application_kol_num >= $max_kol_num)
			{
				return $this->error_response($task_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_REACH_MAX_KOL_UPLIMIT,
					ErrorDescs::ERROR_CODE_TASK_APPLICATION_REACH_MAX_KOL_UPLIMIT);		
			}
		}

		$kol_service = new KolService;
		$kol_detail = $kol_service->kol_detail($kol_id);
		if (empty($kol_detail['data']))
		{
			return $this->error_response($task_id, ErrorCodes::ERROR_CODE_KOL_IS_NOT_EXIST,
				ErrorDescs::ERROR_CODE_KOL_IS_NOT_EXIST);		
		}
		$kol_min_followers = $task_detail['data']['kol_min_followers'];
		if ($kol_min_followers > 0)
		{
			$followers = $kol_detail['data']['twitter_followers'];	
			if ($followers < $kol_min_followers)
			{
				return $this->error_response($task_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_KOL_FOLLOWERS_IS_NOT_ENOUGH,
					ErrorDescs::ERROR_CODE_TASK_APPLICATION_KOL_FOLLOWERS_IS_NOT_ENOUGH);		
			}
		}

		$kol_score_min = $task_detail['data']['kol_score_min'];
		if ($kol_min_followers > 0)
		{
			$score = $kol_detail['data']['composite_score'];	
			if ($score < $kol_score_min)
			{
				return $this->error_response($task_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_KOL_SCORE_IS_NOT_ENOUGH,
					ErrorDescs::ERROR_CODE_TASK_APPLICATION_KOL_SCORE_IS_NOT_ENOUGH);		
			}
		}

		$kol_engagement_min = $task_detail['data']['kol_like_min'];
		if ($kol_engagement_min > 0)
		{
			$engagement = 1;
			$followers = $kol_detail['data']['twitter_followers'];
			$likes = $kol_detail['data']['twitter_subscriptions'];
			if ($followers > 0 && $likes > 0)
			{
				$engagement = number_format($likes / $followers * 100, 2);	
			}
			if ($engagement < $kol_engagement_min)
			{
				return $this->error_response($task_id, ErrorCodes::ERROR_CODE_TASK_APPLICATION_KOL_ENGAGEMENT_IS_NOT_ENOUGH,
					ErrorDescs::ERROR_CODE_TASK_APPLICATION_KOL_ENGAGEMENT_IS_NOT_ENOUGH);		
			}
		}
		$this->res['code'] = ErrorCodes::ERROR_CODE_SUCCESS;
		$this->res['message'] = '';
		$this->res['data'] = [];
		return $this->res;
	}

}
