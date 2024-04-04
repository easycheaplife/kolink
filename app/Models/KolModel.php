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

	public function insert($token, $email, $twitter_user_name, $twitter_avatar,  $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, &$last_insert_id)
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

	public function list($region_id, $category_id, $language_id, $channel_id, $page, $size)
	{
		$query = DB::table($this->table);
		if ($region_id != 0) {
			$query->where('region_id', $region_id);
		}
		if ($language_id != '') {
			$query->where('language_id', $language_id);
		}
		if ($channel_id != 0) {
			$query->where('channel_id', $channel_id);
		}
		return $query->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($region_id, $category_id, $language_id, $channel_id)
	{
		$query = DB::table($this->table);
		if ($region_id != 0) {
			$query->where('region_id', $region_id);
		}
		if ($language_id != '') {
			$query->where('language_id', $language_id);
		}
		if ($channel_id != 0) {
			$query->where('channel_id', $channel_id);
		}
		return $query->count();
	}

	public function get($kol_id)
	{
		return $this->where('id', $kol_id)->first();
	}

	public function login($token)
	{
		return $this->where('token', $token)->first();
	}

}
