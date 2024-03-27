<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class KolModel extends Model
{
    use HasFactory;

	protected $table = 'kol';

	public function insert($token, $email, $twitter_user_name, $twitter_avatar,  $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->twitter_user_name = $twitter_user_name;
			$this->twitter_avatar = $twitter_avatar;
			$this->twitter_followers = $twitter_followers;
			$this->twitter_subscriptions = $twitter_subscriptions;
			$this->region_id = $region_id;
			$this->category_id = $category_id;
			$this->language_id = $language_id;
			$this->channel_id = $channel_id;
			return $this->save();
		}
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

	public function get($region_id, $category_id, $language_id, $channel_id)
	{
		$query = DB::table($this->table);
		if ($region_id != 0) {
			$query->where('region_id', $regionId);
		}
		if ($category_id != 0) {
			$query->where('category_id', $category_id);
		}
		if ($language_id != 0) {
			$query->where('language_id', $language_id);
		}
		if ($channel_id != 0) {
			$query->where('channel_id', $channel_id);
		}
		return $query->orderByDesc('updated_at')->get();
	}

}
