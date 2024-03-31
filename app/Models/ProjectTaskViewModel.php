<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ProjectTaskViewModel extends Model
{
    use HasFactory;

	protected $table = 'project_task_viewer';

	public function insert($kol_id, $task_id, $avatar)
	{
		try {
			$this->kol_id = $kol_id;
			$this->task_id = $task_id;
			$this->avatar = $avatar;
			return $this->save();
		}
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

	public function get($task_id)
	{
		return $this->where('task_id', $task_id)->get();
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
