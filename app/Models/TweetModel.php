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
		'favorite_count', 'reply_count', 'retweet_count', 'quote_count', 
		'view_count', 'retweeted_tweet_id', 'quote_tweet_id', 'created_at'
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
					'quote_count' => $tweet['quote_count'],
					'quote_tweet_id' => $tweet['quote_tweet_id'],
					'retweeted_tweet_id' => $tweet['retweeted_tweet_id'],
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
		$default_size = config('config.twitter_tweets_default_size');
		return $this->select('tweet_id', 'user_id', 'user_name', 'full_text', 'quote_count',
			'favorite_count', 'retweet_count', 'reply_count', 'view_count', 'quote_tweet_id', 
			'retweeted_tweet_id', 'created_at') 
			->where('user_name', $scree_name)
			->orderByDesc('created_at')
			->take($default_size)
			->get();
	}

}
