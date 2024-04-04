<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class ProjectTaskApplicationModel extends Model
{
    use HasFactory;

	protected $table = 'project_task_application';

	public function insert($kol_id, $task_id, $quotation, $reason)
	{
		try {
			$this->kol_id = $kol_id;
			$this->task_id = $task_id;
			$this->quotation = $quotation;
			$this->reason = $reason;
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function get($application_id)
	{
		return $this->where('id', $application_id)->first();
	}

	public function update_status($application_id, $status)
	{
		return $this->where('id', $application_id)->update(['status' => $status]);
	}

	public function update_quotation_and_reason($application_id, $quotation, $reason)
	{
		return $this->where('id', $application_id)->update(['quotation' => $quotation, 'reason' => $reason]);
	}

	public function update_verification_and_status($application_id, $verification, $status)
	{
		return $this->where('id', $application_id)->update([
			'verification' => $verification, 
			'status' => $status]);
	}

	public function update_comment_and_status($application_id, $comment, $status)
	{
		return $this->where('id', $application_id)->update([
			'comment' => $comment, 
			'status' => $status]);
	}

	public function kol_task_list($kol_id, $page, $size)
	{
		return $this->select('task_id')->where('kol_id', $kol_id)
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function list($task_id)
	{
		return $this->where('task_id', $task_id)->get();
	}

	public function upcoming_task_list($kol_id)
	{
		return $this->where('status', '<', config("config.task_status")['finish'])
			->where('kol_id', $kol_id)
			->get();	
	}

}
