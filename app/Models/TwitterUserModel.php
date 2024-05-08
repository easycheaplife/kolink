<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class TwitterUserModel extends Model
{
    use HasFactory;

	protected $table = 'twitter_user';

	public $timestamps = false;

	public function insert($user)
	{
		try {
			$this->user_id = $user['id'];
			$this->name = $user['name'];
			$this->screen_name = $user['screen_name'];
			$this->location = $user['location'];
			$this->description = $user['description'];
			$this->url = is_null($user['url']) ? '' : $user['url'];
			$this->followers_count = $user['followers_count'];
			$this->friends_count = $user['friends_count'];
			$this->listed_count = $user['listed_count'];
			$this->favourites_count = $user['favourites_count'];
			$this->utc_offset = is_null($user['utc_offset']) ? 0 : $user['utc_offset'];
			$this->time_zone = is_null($user['time_zone']) ? '' : $user['time_zone'];
			$this->geo_enabled = $user['geo_enabled'];
			$this->verified = $user['verified'];
			$this->statuses_count = $user['statuses_count'];
			$this->lang = is_null($user['lang']) ? '' : $user['lang'];
			$this->profile_background_image_url = is_null($user['profile_background_image_url']) ? '' : $user['profile_background_image_url'];
			$this->profile_background_image_url_https = is_null($user['profile_background_image_url_https']) ? '' : $user['profile_background_image_url_https'];
			$this->profile_image_url = $user['profile_image_url'];
			$this->profile_image_url_https = $user['profile_image_url_https'];
			$this->created_at = $this->convert_to_unixtime($user['created_at']);
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				Log::error($e->getMessage());
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function convert_to_unixtime($datetimeStr) {
		$datetime = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $datetimeStr);
		if ($datetime === false) {
			$datetime = DateTime::createFromFormat('D M d H:i:s O Y', $datetimeStr);
		}
		if ($datetime !== false) {
			return $datetime->getTimestamp();
		}
		return time();
	}

	public function insert2($user)
	{
		Log::info($user);
		try {
			$this->user_id = $user['id'];
			$this->name = $user['name'];
			$this->screen_name = $user['username'];
			$this->description = $user['description'];
			$this->followers_count = $user['public_metrics']['followers_count'];
			$this->friends_count = $user['public_metrics']['following_count'];
			$this->listed_count = $user['public_metrics']['listed_count'];
			$this->favourites_count = $user['public_metrics']['like_count'];
			$this->statuses_count = $user['public_metrics']['tweet_count'];
			$this->profile_image_url = $user['profile_image_url'];
			$this->created_at = $this->convert_to_unixtime($user['created_at']);
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				Log::error($e->getMessage());
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}


	public function get($user_id)
	{
		return $this->select('user_id', 'name', 'screen_name', 'location', 'description', 'url', 'followers_count', 
			'friends_count', 'listed_count', 'favourites_count', 'following_count', 'media_count', 
			'statuses_count', 'lang', 'profile_image_url')
			->where('user_id', $user_id)
			->first();
	}

	public function count()
	{
		return $this->select('id')->count();
	}

	public function get_users($page, $size)
	{
		return $this->select('user_id', 'name', 'screen_name', 'location', 'description', 'url', 'followers_count', 
			'friends_count', 'listed_count', 'favourites_count', 'following_count', 'media_count', 
			'statuses_count', 'lang', 'profile_image_url', 'created_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function get_column_count_max($column_name)
	{
		return $this->select($column_name)->max($column_name);
	}

	public function get_column_count_min($column_name)
	{
		return $this->select($column_name)->min($column_name);
	}

}	
