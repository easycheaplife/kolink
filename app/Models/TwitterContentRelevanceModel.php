<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterContentRelevanceModel extends Model
{
    use HasFactory;
	protected $table = 'twitter_content_relevance';
	protected $fillable = [
		'user_id', 'user_name', 'category_id', 'score', 'explanation' 
	];

	public function insert($user_id, $user_name, $category_id, $score, $explanation)
	{
		try {
			return $this->updateOrCreate(
				['user_id' => $user_id, 'category_id' => $category_id],
				[
					'user_id' => $user_id,
					'user_name' => $user_name,
					'category_id' => $category_id,
					'score' => $score,
					'explanation' => $explanation,
				]);
		}
		catch (QueryException $e)
		{
			Log::error($e->getMessage());
		}
		return false;
	}

	public function get($user_id, $category_id)
	{
		return $this->select('user_id', 'user_name', 'category_id', 'score', 'explanation') 
			->where('user_id', $user_id)
			->where('category_id', $category_id)
			->first();
	}

	public function top($user_id, $top_n = 6)
	{
		return $this->select('category_id', 'score', 'explanation') 
			->where('user_id', $user_id)
			->where('category_id', '!=', config('config.category_list')['Web3'] ) 
			->orderByDesc('score')
			->take($top_n)
			->get();
	}

	public function get_column_count_max($column_name)
	{
		return $this->select($column_name)->max($column_name);
	}

}
