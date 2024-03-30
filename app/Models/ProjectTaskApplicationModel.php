<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
		catch (Exception $e)
		{
			Log::info($e->getMessage());
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

	public function update_verification_and_comment_and_status($application_id, $verification, $comment, $status)
	{
		return $this->where('id', $application_id)->update([
			'verification' => $verification, 
			'comment' => $comment,
			'status' => $status]);
	}

}
