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
		$twitter_subscriptions, $twitter_like_count, $twitter_following_count,
		$monetary_score, $engagement_score, $age_score, $composite_score,
		$region_id, $category_id, $language_id, $channel_id, $invite_code, &$last_insert_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->twitter_user_id = $twitter_user_id;
			$this->twitter_user_name = $twitter_user_name;
			$this->twitter_avatar = $twitter_avatar;
			$this->twitter_followers = $twitter_followers;
			$this->twitter_subscriptions = $twitter_subscriptions;
			$this->twitter_like_count = $twitter_like_count;
			$this->twitter_following_count = $twitter_following_count;
			$this->monetary_score = $monetary_score;
			$this->engagement_score = $engagement_score;
			$this->age_score = $age_score;
			$this->composite_score = $composite_score;
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
		if ($channel_id != '0') {
			$query->whereIn('channel_id', explode(",", $channel_id));
		}
/*
		if ($region_id != '') {
			$items = explode(",", $region_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, region_id) > 0");
			}
		}

		if ($language_id != '') {
			$items = explode(",", $language_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, language_id) > 0");
			}
		}

		if ($category_id != '') {
			$items = explode(",", $category_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, category_id) > 0");
			}
		}
 */
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
		return $query->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 'invite_code', 'xp')
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($region_id, $category_id, $language_id, $channel_id)
	{
		$query = DB::table($this->table);

		if ($channel_id != 0) {
			$query->whereIn('channel_id', explode(",", $channel_id));
		}

/*
		if ($region_id != '') {
			$items = explode(",", $region_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, region_id) > 0");
			}
		}

		if ($language_id != '') {
			$items = explode(",", $language_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, language_id) > 0");
			}
		}

		if ($category_id != '') {
			$items = explode(",", $category_id);
			foreach ($items as $item) {
				$query->orWhereRaw("FIND_IN_SET($item, category_id) > 0");
			}
		}
*/
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
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 'invite_code', 'xp')
			->where('id', $kol_id)->first();
	}

	public function login($token)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 'invite_code', 'xp')
			->where('token', $token)->first();
	}

	public function setting($kol_id, $email, $region_id, $category_id, $language_id, $channel_id)
	{
		return $this->where('id', $kol_id)->update([
			'email' => $email, 
			'region_id' => $region_id, 
			'category_id' => $category_id, 
			'language_id' => $language_id, 
			'channel_id' => $channel_id]);
	}

	public function get_by_twitter_user_id($twitter_user_id)
	{
		return $this->select('id', 'token', 'email', 'twitter_user_id', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 'invite_code', 'xp')
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
			$this->twitter_friends_count = $twitter_user['friends_count'];
			$this->twitter_listed_count = $twitter_user['listed_count'];
			$this->twitter_statuses_count = $twitter_user['statuses_count'];
			$this->twitter_favourites_count = $twitter_user['favourites_count'];
			$this->twitter_media_count = $twitter_user['media_count'];
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
		// like_count(new version), favourites_count(old version) are the same meaning, twitter_subscriptions is deprecated.
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
			'twitter_friends_count' => $twitter_user['friends_count'], 
			'twitter_listed_count' => $twitter_user['listed_count'], 
			'twitter_statuses_count' => $twitter_user['statuses_count'], 
			'twitter_favourites_count' => $twitter_user['favourites_count'], 
			'twitter_media_count' => $twitter_user['media_count']]);
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
		return $this->select('id', 'token', 'email', 'twitter_user_name', 'twitter_avatar', 'twitter_followers', 'twitter_subscriptions', 'region_id', 'language_id', 'category_id', 'monetary_score', 'engagement_score', 'age_score', 'composite_score', 'twitter_like_count', 'invitee_code', 'invite_code', 'xp')
			->whereIn('id', $kol_ids)
			->orderByDesc('updated_at')
			->get();
	}

}
