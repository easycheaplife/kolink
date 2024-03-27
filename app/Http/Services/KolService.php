<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\KolModel;
use App\Http\Services\VerificationService;


class KolService extends Service 
{
	public function kol_new($token, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
		$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id, $code)
	{
		$verification_service = new VerificationService;
		$verification_code = $verification_service->get_code($email);
		if ($code != $verification_code)
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_VERIFICATION_CODE_ERROR,
				ErrorDescs::ERROR_CODE_VERIFICATION_CODE_ERROR);		
		}
		$kol_model = new KolModel;
		if (!$kol_model->insert($token, $email, $twitter_user_name, $twitter_avatar, $twitter_followers, 
			$twitter_subscriptions, $region_id, $category_id, $language_id, $channel_id))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_DB_ERROR,
				ErrorDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

    public function find_kol($region_id, $category_id, $language_id, $channel_id)
	{
		$kol_model = new KolModel;
		$kols = $kol_model->get($region_id, $category_id, $language_id, $channel_id);	
		foreach ($kols as $kol)
		{
			$this->res['data'][] = $kol;	
		}
		return $this->res;
	}

}
