<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetModel extends Model
{
    use HasFactory;
	protected $table = 'tweet';

	protected $fillable = [
		'tweet_id', 'user_id', 'user_name', 'full_text', 
		'favorite_count', 'reply_count', 'retweet_count', 
		'view_count', 'created_at'
	];

	public function insert($tweet)
	{
		try {
			return $this->updateOrCreate(
				['tweet_id' => $tweet['id']],
				[
					'user_id' => $tweet['user_id'],
					'user_name' => $tweet['user_screen_name'],
					'full_text' => $tweet['full_text'],
					'favorite_count' => $tweet['favorite_count'],
					'reply_count' => $tweet['reply_count'],
					'retweet_count' => $tweet['retweet_count'],
					'view_count' => $tweet['view_count'],
					'created_at' => $tweet['created_at']
			]);
		}
		catch (QueryException $e)
		{
			Log::error($e->getMessage());
		}
		return false;
	}

	public function get($scree_name)
	{
		return $this->select('user_id', 'user_name', 'full_text',
			'favorite_count', 'retweet_count', 'reply_count', 'view_count', 
			'created_at') 
			->where('user_name', $scree_name)->get();
	}

}
