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
		$twitter_like_count, $twitter_following_count, $twitter_listed_count, $twitter_statuses_count, $twitter_created_at,
		$youtube_user_id, $youtube_user_name, $youtube_avatar, $youtube_custom_url, $youtube_view_count,
		$youtube_subscriber_count, $youtube_video_count, $youtube_created_at,
		$region_id, $category_id, $language_id, $channel_id, $invite_code, &$last_insert_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->twitter_user_id = $twitter_user_id ? $twitter_user_id : 0;
			$this->twitter_user_name = $twitter_user_name;
			$this->twitter_avatar = $twitter_avatar;
			$this->twitter_followers = $twitter_followers;
			$this->twitter_like_count = $twitter_like_count;
			$this->twitter_following_count = $twitter_following_count;
			$this->twitter_listed_count = $twitter_listed_count;
			$this->twitter_statuses_count = $twitter_statuses_count;
			$this->twitter_created_at = $twitter_created_at;
			$this->youtube_user_id = $youtube_user_id ? $youtube_user_id : '';
			$this->youtube_user_name = $youtube_user_name;
			$this->youtube_avatar = $youtube_avatar;
			$this->youtube_custom_url = $youtube_custom_url;
			$this->youtube_view_count = $youtube_view_count;
			$this->youtube_subscriber_count = $youtube_subscriber_count;
			$this->youtube_video_count = $youtube_video_count;
			$this->youtube_created_at = $youtube_created_at;
			$this->region_id = $region_id;
			$this->category_id = $category_id;
			$this->language_id = $language_id;
			$this->channel_id = $channel_id;
			$this->invitee_code = $invite_code;
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

		if ($channel_id != '') {
			$query->where(function ($query) use ($channel_id) {
				$items = explode(",", $channel_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, channel_id) > 0");
				}
			});
		}
		if ($region_id != '') {
			$query->where(function ($query) use ($region_id) {
				$items = explode(",", $region_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, region_id) > 0");
				}
			});
		}
		if ($language_id != '') {
			$query->where(function ($query) use ($language_id) {
				$items = explode(",", $language_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, language_id) > 0");
				}
			});
		}
		if ($category_id != '') {
			$query->where(function ($query) use ($category_id) {
				$items = explode(",", $category_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, category_id) > 0");
				}
			});
		}
		if (1 == $sort_field)
		{
			if (0 == $sort_type)
			{
				$query->orderBy(DB::raw('CAST(composite_score AS FLOAT)'));	
			}
			else{
				$query->orderByDesc(DB::raw('CAST(composite_score AS FLOAT)'));	
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
		else if (3 == $sort_field)
		{
			if (0 == $sort_type)
			{
				$query->orderBy('youtube_subscriber_count');	
			}
			else {
				$query->orderByDesc('youtube_subscriber_count');	
			}
		}
		return $query->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($region_id, $category_id, $language_id, $channel_id)
	{
		$query = DB::table($this->table);

		if ($channel_id != '') {
			$query->where(function ($query) use ($channel_id) {
				$items = explode(",", $channel_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, channel_id) > 0");
				}
			});
		}
		if ($region_id != '') {
			$query->where(function ($query) use ($region_id) {
				$items = explode(",", $region_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, region_id) > 0");
				}
			});
		}
		if ($language_id != '') {
			$query->where(function ($query) use ($language_id) {
				$items = explode(",", $language_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, language_id) > 0");
				}
			});
		}
		if ($category_id != '') {
			$query->where(function ($query) use ($category_id) {
				$items = explode(",", $category_id);
				foreach ($items as $item) {
					$query->orWhereRaw("FIND_IN_SET($item, category_id) > 0");
				}
			});
		}

		return $query->count();
	}

	public function get($kol_id)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_id', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 'twitter_created_at', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count', 'youtube_created_at',
			'youtube_subscriber_count', 'youtube_view_count', 'youtube_video_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			->where('id', $kol_id)->first();
	}

	public function login($token)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			->where('token', $token)->first();
	}

	public function setting($kol_detail)
	{
		return $this->where('id', $kol_detail['id'])->update([
			'email' => $kol_detail['email'], 
			'region_id' => $kol_detail['region_id'], 
			'category_id' => $kol_detail['category_id'], 
			'language_id' => $kol_detail['language_id'], 
			'channel_id' => $kol_detail['channel_id'], 
			'twitter_user_id' => $kol_detail['twitter_user_id'], 
			'twitter_user_name' => $kol_detail['twitter_user_name'], 
			'twitter_avatar' => $kol_detail['twitter_avatar'], 
			'twitter_followers' => $kol_detail['twitter_followers'], 
			'twitter_like_count' => $kol_detail['twitter_like_count'], 
			'twitter_following_count' => $kol_detail['twitter_following_count'], 
			'twitter_listed_count' => $kol_detail['twitter_listed_count'], 
			'twitter_statuses_count' => $kol_detail['twitter_statuses_count'], 
			'twitter_created_at' => $kol_detail['twitter_created_at'], 
			'youtube_user_id' => $kol_detail['youtube_user_id'], 
			'youtube_user_name' => $kol_detail['youtube_user_name'], 
			'youtube_avatar' => $kol_detail['youtube_avatar'], 
			'youtube_custom_url' => $kol_detail['youtube_custom_url'], 
			'youtube_subscriber_count' => $kol_detail['youtube_subscriber_count'], 
			'youtube_view_count' => $kol_detail['youtube_view_count'], 
			'youtube_video_count' => $kol_detail['youtube_video_count'], 
			'youtube_created_at' => $kol_detail['youtube_created_at']]);
	}

	public function get_by_twitter_user_id($twitter_user_id)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			->orderByDesc('id')
			->where('twitter_user_id', $twitter_user_id)->first();
	}

	public function insert_twitter_user($twitter_user)
	{
		try {
			$this->token = base64_encode(openssl_random_pseudo_bytes(32));;
			$this->twitter_user_id = $twitter_user['user_id'];
			$this->twitter_user_name = $twitter_user['screen_name'];
			$this->twitter_avatar = $twitter_user['profile_image_url'];
			$this->monetary_score = $twitter_user['monetary_score'];
			$this->engagement_score = $twitter_user['engagement_score'];
			$this->age_score = $twitter_user['age_score'];
			$this->composite_score = $twitter_user['composite_score'];
			$this->twitter_followers = $twitter_user['followers_count'];
			$this->twitter_like_count = $twitter_user['like_count'];
			$this->twitter_following_count = $twitter_user['following_count'];
			$this->twitter_listed_count = $twitter_user['listed_count'];
			$this->twitter_statuses_count = $twitter_user['statuses_count'];
			$this->twitter_created_at = $twitter_user['created_at'];
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
			'monetary_score' => $twitter_user['monetary_score'], 
			'engagement_score' => $twitter_user['engagement_score'], 
			'age_score' => $twitter_user['age_score'], 
			'composite_score' => $twitter_user['composite_score'], 
			'twitter_followers' => $twitter_user['followers_count'], 
			'twitter_like_count' => $twitter_user['like_count'], 
			'twitter_following_count' => $twitter_user['following_count'], 
			'twitter_listed_count' => $twitter_user['listed_count'], 
			'twitter_statuses_count' => $twitter_user['statuses_count']]);
	}

	public function token_count()
	{
		return $this->select('id') 
			->where('token', 'like', '0x%')
			->count();
	}

	public function get_tokens($page, $size)
	{
		return $this->select('token') 
			->where('token', 'like', '0x%')
			->skip($page * $size)
			->take($size)
			->get();
	
	}

	public function update_invite_code($kol_id, $invite_code)
	{
		return $this->where('id', $kol_id)->update([
			'invite_code' => $invite_code 
		]);
	}

	public function get_id_by_invite_code($invite_code)
	{
		if ('' == $invite_code)
		{
			return array();
		}
		return $this->select('id')
			->where('invite_code', $invite_code)->first();
	}

	public function get_inviter_kol_by_invitee_code($invitee_code)
	{
		if ('' == $invitee_code)
		{
			return array();
		}
		return $this->select('id', 'twitter_user_name')
			->where('invite_code', $invitee_code)->first();
	}

	public function invited_friend_num($invitee_code)
	{
		if ('' == $invitee_code)
		{
			return 0;
		}
		return $this->select('id') 
			->where('invitee_code', $invitee_code)
			->count();
	}

	public function inc_xp($kol_id, $xp)
	{
		$kol = $this->find($kol_id);
		$kol->xp += $xp;
		$kol->save();
	}

	public function get_kols($kol_ids)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			->whereIn('id', $kol_ids)
			->orderByDesc('updated_at')
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

	public function update_score($kol_id, $engagement_score, $age_score, $monetary_score, $composite_score)
	{
		return $this->where('id', $kol_id)->update([
			'engagement_score' => $engagement_score, 
			'age_score' => $age_score, 
			'monetary_score' => $monetary_score, 
			'composite_score' => $composite_score 
		]);
	}

	public function get_users($page, $size)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_id', 'twitter_user_name', 'twitter_avatar', 'twitter_tweet_summarize', 'twitter_created_at', 
			'twitter_listed_count', 'twitter_like_count', 'twitter_following_count', 'twitter_statuses_count',
			'twitter_favorite_count_total', 'twitter_reply_count_total', 'twitter_retweet_count_total', 'twitter_view_count_total',
			'twitter_followers', 'region_id', 'language_id', 'category_id', 'monetary_score', 
			'youtube_user_id', 'youtube_user_name', 'youtube_avatar', 'youtube_custom_url', 'youtube_subscriber_count', 'youtube_created_at',
			'youtube_subscriber_count', 'youtube_view_count', 'youtube_video_count',
			'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 
			'invite_code', 'xp')
			// ->where('email', '!=', '')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function get_users_count()
	{
		return $this->select('id')->count();
	}

	public function update_twitter_data($kol_id, $twitter_user)
	{
		return $this->where('id', $kol_id)->update([
			'twitter_followers' => $twitter_user['public_metrics']['followers_count'], 
			'twitter_like_count' => $twitter_user['public_metrics']['like_count'], 
			'twitter_following_count' => $twitter_user['public_metrics']['following_count'], 
			'twitter_listed_count' => $twitter_user['public_metrics']['listed_count'], 
			'twitter_statuses_count' => $twitter_user['public_metrics']['tweet_count'], 
			'twitter_favorite_count_total' => $twitter_user['public_metrics']['favorite_count_total'], 
			'twitter_reply_count_total' => $twitter_user['public_metrics']['reply_count_total'], 
			'twitter_retweet_count_total' => $twitter_user['public_metrics']['retweet_count_total'], 
			'twitter_view_count_total' => $twitter_user['public_metrics']['view_count_total']]);
	}

	public function update_twitter_tweet_summarize($kol_id, $text)
	{
		try {
			return $this->where('id', $kol_id)->update([
				'twitter_tweet_summarize' => $text
			]);
		}
		catch (QueryException $e)
		{
			Log::error($e->getMessage());
		}
		return false;
	}

}
