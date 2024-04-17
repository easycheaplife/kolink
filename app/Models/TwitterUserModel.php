<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class TwitterUserModel extends Model
{
    use HasFactory;

	protected $table = 'twitter_user';

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
			$this->created_at = $user['created_at'];
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
}
