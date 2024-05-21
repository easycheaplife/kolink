<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class RewardRecordModel extends Model
{
    use HasFactory;
	protected $table = 'reward_record';
	public function insert($invitee_kol_Id, $invite_kol_id, $xp, $reward_task_id)
	{
		try {
			$this->invitee_kol_Id = $invitee_kol_Id;
			$this->invite_kol_id = $invite_kol_id;
			$this->xp = $xp;
			$this->reward_task_id = $reward_task_id;
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

	public function list($kol_id, $page, $size)
	{
		return $this->select('invitee_kol_id', 'invite_kol_id', 'xp', 'reward_task_id', 'created_at')
			->where('invite_kol_id', $kol_id)
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($kol_id)
	{
		return $this->select('id')
			->where('invite_kol_id', $kol_id)
			->count();
	}

	public function completed_times($kol_id, $reward_task_id)
	{
		return $this->select('id')
			->where('invite_kol_Id', $kol_id)
			->where('reward_task_id', $reward_task_id)
			->count();
	}

}
