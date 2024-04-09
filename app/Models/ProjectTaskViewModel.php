<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class ProjectTaskViewModel extends Model
{
    use HasFactory;

	protected $table = 'project_task_viewer';

	public function insert($kol_id, $project_id, $task_id, $avatar)
	{
		try {
			$this->kol_id = $kol_id;
			$this->project_id = $project_id;
			$this->task_id = $task_id;
			$this->avatar = $avatar;
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

	public function get($task_id)
	{
		return $this->where('task_id', $task_id)->get();
	}

	public function get_task_count($task_id)
	{
		return $this->where('task_id', $task_id)->count();
	}

	public function get_project_count($project_id)
	{
		return $this->where('project_id', $project_id)->count();
	}

	public function trending_task()
	{
		return DB::table($this->table)
			->select('task_id', DB::raw('COUNT(task_id) as view_count'))
			->groupBy('task_id')
			->orderByDesc('view_count')
			->get();	
	}

}
