<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class ProjectTaskModel extends Model
{
    use HasFactory;
	protected $table = 'project_task';
	public function insert($project_id, $title, $desc, $social_platform_id, $kol_max, $kol_min_followers,
		$kol_like_min, $kol_socre_min, $start_time, $applition_ddl_time, $upload_ddl_time, $blockchain_id,
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
			$this->kol_socre_min = $kol_socre_min;
			$this->start_time = $start_time;
			$this->applition_ddl_time = $applition_ddl_time;
			$this->upload_ddl_time = $upload_ddl_time;
			$this->blockchain_id = $blockchain_id;
			$this->token_id = $token_id;
			$this->reward_min = $reward_min;
			return $this->save();
		}
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

	public function get($project_id)
	{
		return $this->where('project_id', $project_id)->get();
	}

	public function get_tasks($task_ids)
	{
		return $this->whereIn('id', $task_ids)->get();
	}

	public function detail($task_id)
	{
		return $this->where('id', $task_id)->first();
	}

}
