<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendTaskModel extends Model
{
    use HasFactory;
	protected $table = 'recommend_task';

	public function list()
	{
		return $this->select('task_id', 'url')
			->where('enable', '=', 1)
			->orderByDesc('id')
			->get();
	}

}
