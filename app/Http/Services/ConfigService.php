<?php

namespace App\Http\Services;

class ConfigService extends Service 
{
    public function list()
	{
		$this->res['data']['region_list'] = config('config.region_list');
		$this->res['data']['language_list'] = config('config.language_list');
		$this->res['data']['category_list'] = config('config.category_list');
		$this->res['data']['channel_list'] = config('config.channel_list');
		$this->res['data']['reward_task_list'] = config('config.reward_task');
		return $this->res;
	}
}
