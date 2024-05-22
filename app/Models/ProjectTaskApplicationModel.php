<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class ProjectTaskApplicationModel extends Model
{
    use HasFactory;

	protected $table = 'project_task_application';

	public function insert($kol_id, $task_id, $quotation, $reason, &$last_insert_id)
	{
		try {
			$this->kol_id = $kol_id;
			$this->task_id = $task_id;
			$this->quotation = $quotation;
			$this->reason = $reason;
			$ret = $this->save();
			$last_insert_id = DB::connection()->getPdo()->lastInsertId();
			return $ret;
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
		return $this->select('id', 'task_id', 'kol_id', 'quotation', 'status', 'reason', 'comment', 'verification', 'url', 'web3_hash', 'declined_desc', 'created_at', 'updated_at')
			->where('id', $application_id)->first();
	}

	public function update_status($application_id, $status)
	{
		return $this->where('id', $application_id)->update(['status' => $status]);
	}

	public function update_quotation_and_reason($application_id, $quotation, $reason)
	{
		return $this->where('id', $application_id)->update(['quotation' => $quotation, 'reason' => $reason]);
	}

	public function update_verification_and_status($application_id, $verification, $url, $status)
	{
		return $this->where('id', $application_id)->update([
			'verification' => $verification, 
			'url' => $url, 
			'status' => $status]);
	}

	public function update_comment_and_status($application_id, $comment, $status)
	{
		return $this->where('id', $application_id)->update([
			'comment' => $comment,
			'status' => $status]);
	}

	public function update_web3_hash_and_status($application_id, $web3_hash, $status, $declined_desc)
	{
		return $this->where('id', $application_id)->update([
			'web3_hash' => $web3_hash,
			'declined_desc' => $declined_desc,
			'status' => $status]);
	}

	public function kol_task_list($kol_id, $status, $page, $size)
	{
		/*
		return $this->select('task_id', 'status')
			->where('kol_id', $kol_id)
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();

		 */
		$query = DB::table($this->table);
		if (-1 != $status)
		{
			$query->where('status', $status);
		}
		return $query->select('id', 'task_id', 'kol_id', 'quotation', 'status', 'reason', 'comment', 'verification', 'url', 'web3_hash', 'declined_desc', 'updated_at')
			->where('kol_id', $kol_id)
			->whereIn('id', function ($query) use ($kol_id) {
				$query->select(DB::raw('MAX(id)'))
					->from('project_task_application')
					->where('kol_id', $kol_id)
					->groupBy('task_id');
			   })
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function kol_task_list_count($kol_id, $status)
	{
		$query = DB::table($this->table);
		if (-1 != $status)
		{
			$query->where('status', $status);
		}
		return $query->select('id')
			->where('kol_id', $kol_id)
			->whereIn('id', function ($query) {
				$query->select(DB::raw('MAX(id)'))
					->from('project_task_application')
					->where('kol_id', 1)
					->groupBy('task_id');
			   })
			->count();
	}

	public function kol_task_count($kol_id)
	{
		return $this->where('kol_id', $kol_id)
			->count();
	}

	public function list($task_id)
	{
		return $this->select('id', 'task_id', 'kol_id', 'quotation', 'status', 'reason', 'comment', 'verification', 'url', 'web3_hash', 'declined_desc', 'updated_at')
			->where('task_id', $task_id)
			->orderByDesc('updated_at')
			->get();
	}

	public function kol_task_status($kol_id, $task_id)
	{
		return $this->select('id', 'task_id', 'kol_id', 'quotation', 'status', 'reason', 'comment', 'verification', 'url', 'web3_hash', 'declined_desc', 'updated_at')
			->where('kol_id', $kol_id)
			->where('task_id', $task_id)   
			->orderByDesc('updated_at')
			->first();
	}

	public function task_close($task_id)
	{
		return $this->select('id', 'task_id', 'kol_id', 'quotation', 'status', 'reason', 'comment', 'verification', 'url', 'web3_hash', 'declined_desc', 'updated_at')
			->where('task_id', $task_id)->update([
			'status' => config('config.task_status')['close']]);
	}

	public function task_in_progross($task_id)
	{
		return $this->where('task_id', $task_id)   
			->count();
	}

	public function task_review_timeout()
	{
		$timeout_days = config('config.task_review_timeout');
		return $this->select('id', 'web3_hash', 'task_id')
			->where('status', config('config.task_status')['upload'])
			->where('web3_hash', '!=', '')
			->whereRaw("updated_at + INTERVAL $timeout_days DAY <= NOW()")
			->orderBy('updated_at', 'asc')
			->first();
	}

	// SELECT * FROM project_task_application WHERE web3_hash != '' AND status = 4 AND updated_at + INTERVAL (SELECT upload_ddl_time FROM project_task WHERE id = project_task_application.task_id) DAY <= NOW()
	public function task_upload_timeout()
	{
		return $this->select('id', 'web3_hash', 'task_id')
			->where('status', config('config.task_status')['accept'])
			->where('web3_hash', '!=', '')
			->whereRaw('updated_at + INTERVAL (SELECT upload_ddl_time FROM project_task WHERE id = project_task_application.task_id and upload_ddl_time != 0) DAY <= NOW()')
			->orderBy('updated_at', 'asc')
			->first();
	}

	public function application_kol_num($task_id)
	{
		$task_status = array(
			config('config.task_status')['accept'],
			config('config.task_status')['upload'],
			config('config.task_status')['finish'],
			config('config.task_status')['lock_pending'],
			config('config.task_status')['settle_pending'],
			config('config.task_status')['delegate_settle_pending'],
		);
		return $this->where('task_id', $task_id)   
			->whereIn('status', $task_status)
			->count();
	}

}
