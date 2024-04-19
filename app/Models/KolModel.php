<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class KolModel extends Model
{
    use HasFactory;

	protected $table = 'kol';

	public function insert($token, $email, $twitter_user_id, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, &$last_insert_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->twitter_user_id = $twitter_user_id;
			$this->twitter_user_name = $twitter_user_name;
			$this->twitter_avatar = $twitter_avatar;
			$this->twitter_followers = $twitter_followers;
			$this->twitter_subscriptions = $twitter_subscriptions;
			$this->region_id = $region_id;
			$this->category_id = $category_id;
			$this->language_id = $language_id;
			$this->channel_id = $channel_id;
			$ret = $this->save();
			$last_insert_id = DB::connection()->getPdo()->lastInsertId();
			return $ret;
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

	public function list($region_id, $category_id, $language_id, $channel_id, $sort_type, $sort_field, $page, $size)
	{
		$query = DB::table($this->table);
		if ($region_id != '0') {
			$query->whereIn('region_id', explode(",", $region_id));
		}
		if ($language_id != '0') {
			$query->whereIn('language_id', explode(",", $language_id));
		}
		if ($channel_id != '0') {
			$query->whereIn('channel_id', explode(",", $channel_id));
		}
		if (1 == $sort_field)
		{
			if (0 == $sort_type)
			{
				$query->orderBy('composite_score');	
			}
			else{
				$query->orderByDesc('composite_score');	
			}
		}
		else if (2 == $sort_field)
		{
			if (0 == $sort_type)
			{
				$query->orderBy('twitter_followers');	
			}
			else {
				$query->orderByDesc('twitter_followers');	
			}
		}
		return $query->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score')
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($region_id, $category_id, $language_id, $channel_id)
	{
		$query = DB::table($this->table);
		if ($region_id != '0') {
			$query->whereIn('region_id', explode(",", $region_id));
		}
		if ($language_id != '0') {
			$query->whereIn('language_id', explode(",", $language_id));
		}
		if ($channel_id != '0') {
			$query->whereIn('channel_id', explode(",", $channel_id));
		}
		return $query->count();
	}

	public function get($kol_id)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score')
			->where('id', $kol_id)->first();
	}

	public function login($token)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score')
			->where('token', $token)->first();
	}

	public function setting($kol_id, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id)
	{
		return $this->where('id', $kol_id)->update([
			'email' => $email, 
			'twitter_user_name' => $twitter_user_name, 
			'twitter_avatar' => $twitter_avatar, 
			'twitter_subscriptions' => $twitter_subscriptions, 
			'region_id' => $region_id, 
			'category_id' => $category_id, 
			'language_id' => $language_id, 
			'channel_id' => $channel_id]);
	}

	public function get_by_twitter_user_id($twitter_user_id)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_id', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score')
			->where('twitter_user_id', $twitter_user_id)->first();
	}

	public function insert_twitter_user($twitter_user)
	{
		try {
			$this->token = base64_encode(openssl_random_pseudo_bytes(32));;
			$this->twitter_user_id = $twitter_user['user_id'];
			$this->twitter_user_name = $twitter_user['screen_name'];
			$this->twitter_avatar = $twitter_user['profile_image_url'];
			$this->twitter_followers = $twitter_user['followers_count'];
			$this->twitter_subscriptions = $twitter_user['following_count'];
			$this->twitter_friends_count = $twitter_user['friends_count'];
			$this->twitter_listed_count = $twitter_user['listed_count'];
			$this->twitter_statuses_count = $twitter_user['statuses_count'];
			$this->twitter_favourites_count = $twitter_user['favourites_count'];
			$this->twitter_media_count = $twitter_user['media_count'];
			$ret = $this->save();
			return $ret;
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

	public function update_twitter_user($twitter_user)
	{
		return $this->where('twitter_user_id', $twitter_user['user_id'])->update([
			'twitter_user_name' => $twitter_user['screen_name'], 
			'twitter_avatar' => $twitter_user['profile_image_url'], 
			'twitter_followers' => $twitter_user['followers_count'], 
			'twitter_subscriptions' => $twitter_user['following_count'], 
			'twitter_friends_count' => $twitter_user['friends_count'], 
			'twitter_listed_count' => $twitter_user['listed_count'], 
			'twitter_statuses_count' => $twitter_user['statuses_count'], 
			'twitter_favourites_count' => $twitter_user['favourites_count'], 
			'twitter_media_count' => $twitter_user['media_count']]);
	}

}
