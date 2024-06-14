<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;
use App\Models\RewardRecordModel;
use App\Http\Services\KolService;


class RewardService extends Service 
{

	public function generate_invite_code()
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijllmnopqrstuvwxyz';
		$invite_code = '';
		for ($i = 0; $i < 10; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$invite_code .= $characters[$index];
		}
		return $invite_code;	
	}

    public function reward_list($kol_id, $page, $size)
	{
		$kol_service = new KolService;
		$kol_detail = $kol_service->kol_detail($kol_id);
		$invite_code = '';
		if (empty($kol_detail['data']['invite_code']))
		{
			$invite_code = $this->generate_invite_code();	
			$kol_service->update_invite_code($kol_id, $invite_code);
		}
		else 
		{
			$invite_code = $kol_detail['data']['invite_code'];
		}
		$reward_record_model = new RewardRecordModel;
		$this->res['data']['list'] = $reward_record_model->list($kol_id, $page, $size);
		$this->res['data']['invite_code'] = $invite_code;
		if (!empty($kol_detail['data']['invite_code']))  
		{
			$this->res['data']['invited_friend_num'] = $kol_service->invited_friend_num($kol_detail['data']['invite_code']);
		}
		else{
			$this->res['data']['invited_friend_num'] = 0;
		}

		$kol_ids = array();
		foreach ($this->res['data']['list'] as $record)
		{
			$kol_ids[] = $record['invitee_kol_id'];	
		}
		$kols = $kol_service->get_kols($kol_ids);
		foreach ($this->res['data']['list'] as $key => $record)
		{
			foreach ($kols as $kol)
			{
				if ($kol['id'] == $record['invitee_kol_id'])
				{
					$this->res['data']['list'][$key]['token'] = $kol['token'];	
					$this->res['data']['list'][$key]['twitter_avatar'] = $kol['twitter_avatar'];	
					$this->res['data']['list'][$key]['twitter_user_name'] = $kol['twitter_user_name'];	
				}
			}
		}
		$this->res['data']['total'] = $this->completed_num($kol_id);
		return $this->res;
	}	

	public function completed_num($kol_id)
	{
		$reward_record_model = new RewardRecordModel;
		return $reward_record_model->count($kol_id);	
	}	

    public function reward_task_detail($kol_id)
	{
		$kol_service = new KolService;
		$kol_detail = $kol_service->kol_detail($kol_id);
		if (empty($kol_detail['data']))
		{
			return $this->error_response($kol_id, ErrorCodes::ERROR_CODE_KOL_IS_NOT_EXIST,
				ErrorDescs::ERROR_CODE_KOL_IS_NOT_EXIST);		
		}
		$this->res['data']['list'] = config('config.reward_task');
		$reward_record_model = new RewardRecordModel;
		foreach ($this->res['data']['list'] as $key => $reward_task)
		{
			$this->res['data']['list'][$key]['finish_times'] = $reward_record_model->completed_times($kol_id, $reward_task['id']);
		}
		return $this->res;
	}	

	public function insert_record($invitee_kol_id, $invite_kol_id, $xp, $reward_task_id)
	{
		$reward_record_model = new RewardRecordModel;
		return $reward_record_model->insert($invitee_kol_id, $invite_kol_id, $xp, $reward_task_id);	
	}

	// deprecated
	public function add_reward($kol_id, $xp, $reward_task_id)
	{
		if (!$kol_id)
		{
			return;
		}
		$kol_service = new KolService;
		$kol_detail = $kol_service->kol_detail($kol_id);
		$this->insert_record($kol_id, $kol_id, $xp, $reward_task_id);				
		$kol_service->inc_xp($kol_id, $xp);
		if (!empty($kol_detail['data']['invitee_code']))
		{
			$invite_kol_data = $kol_service->get_id_by_invite_code($kol_detail['data']['invitee_code']);
			if (!empty($invite_kol_data))
			{
				$this->insert_record($kol_id, $invite_kol_data['id'], $xp, $reward_task_id);				
				$kol_service->inc_xp($invite_kol_data['id'], $xp);
			}
		}
	}

	public function add_self_reward($kol_id, $xp, $reward_task_id)
	{
		if (!$kol_id)
		{
			return;
		}
		$this->insert_record($kol_id, $kol_id, $xp, $reward_task_id);				
		$kol_service = new KolService;
		$kol_service->inc_xp($kol_id, $xp);
	}

	public function add_invite_reward($kol_id, $xp, $reward_task_id)
	{
		if (!$kol_id)
		{
			return;
		}
		$kol_service = new KolService;
		$kol_detail = $kol_service->kol_detail($kol_id);
		if (!empty($kol_detail['data']['invitee_code']))
		{
			$invite_kol_data = $kol_service->get_id_by_invite_code($kol_detail['data']['invitee_code']);
			if (!empty($invite_kol_data))
			{
				$this->insert_record($kol_id, $invite_kol_data['id'], $xp, $reward_task_id);				
				$kol_service->inc_xp($invite_kol_data['id'], $xp);
			}
		}
	}

	public function add_twitter_follower_reward($twitter_user_id)
	{
		$kol_service = new KolService;
		$kol = $kol_service->get_by_twitter_user_id($twitter_user_id);
		if (empty($kol))
		{
			return;
		}
		$reward_record_model = new RewardRecordModel;
		if ($reward_record_model->completed_times($kol['id'], config('config.reward_task')['follow_twitter']['id']))
		{
			return;
		}
		$this->add_self_reward($kol['id'], config('config.reward_task')['follow_twitter']['xp'], config('config.reward_task')['follow_twitter']['id']);	
	}

    public function reward_telegram($token)
	{
		$kol_service = new KolService;
		$kol_detail = $kol_service->login($token);
		if (empty($kol_detail['data']))
		{
			return $this->error_response($token, ErrorCodes::ERROR_CODE_KOL_IS_NOT_EXIST,
				ErrorDescs::ERROR_CODE_KOL_IS_NOT_EXIST);		
		}
		$reward_record_model = new RewardRecordModel;
		$finish_times = $reward_record_model->completed_times($kol_detail['data']['id'],  config('config.reward_task')['join_telgram']['id']);
		if (!$finish_times)
		{
			$this->add_self_reward($kol_detail['data']['id'], config('config.reward_task')['join_telgram']['xp'], config('config.reward_task')['join_telgram']['id']);	
		}
		return $this->res;
	}	

}
