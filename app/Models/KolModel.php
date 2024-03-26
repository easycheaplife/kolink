<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolModel extends Model
{
    use HasFactory;

	protected $table = 'kol';
	public function insert($token, $email, $twitter_user_name, $twitter_followers, $twitter_subscriptions, 
		$region_id, $category_id, $website, $language_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->twitter_user_name = $twitter_user_name;
			$this->twitter_followers = $twitter_followers;
			$this->twitter_subscriptions = $twitter_subscriptions;
			$this->region_id = $region_id;
			$this->category_id = $category_id;
			$this->website = $website;
			$this->language_id = $language_id;
			return $this->save();
		}
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

}
