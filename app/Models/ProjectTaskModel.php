<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class ProjectTaskModel extends Model
{
    use HasFactory;
	protected $table = 'project_task';
	public function insert($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers,
		$kol_like_min, $kol_score_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
		$token_id, $reward_min)
	{
		try {
			$this->project_id = $project_id;
			$this->title = $title;
			$this->desc = $desc;
			$this->social_platform_id = $social_platform_id;
			$this->kol_max = $kol_max;
			$this->kol_min_followers = $kol_min_followers;
			$this->kol_like_min = $kol_like_min;
			$this->kol_score_min = $kol_score_min;
			$this->start_time = $start_time;
			$this->applition_ddl_time = $applition_ddl_time;
			$this->upload_ddl_time = $upload_ddl_time;
			$this->blockchain_id = $blockchain_id;
			$this->token_id = $token_id;
			$this->reward_min = $reward_min;
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

	public function list($project_id, $page, $size)
	{
		return $this->where('project_id', $project_id)
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($project_id)
	{
		return $this->where('project_id', $project_id)
			->count();
	}

	public function get_tasks($task_ids)
	{
		return $this->whereIn('id', $task_ids)
			->orderByDesc('updated_at')
			->get();
	}

	public function upcoming_task()
	{
		return $this->where('applition_ddl_time', '>=', time())
			->orderByDesc('updated_at')
			->get();
	}

	public function trending_task()
	{
		return $this->where('applition_ddl_time', '<', time())
			->orderByDesc('updated_at')
			->get();
	}

	public function detail($task_id)
	{
		return $this->where('id', $task_id)->first();
	}

}
