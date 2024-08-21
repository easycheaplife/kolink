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

}
