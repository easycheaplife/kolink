<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\RewardService;


class RewardController extends Controller
{
	public function reward_list(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new RewardService();
		return $service->reward_list(
			$validated_data['kol_id'],
			$page, 
			$size
		);
	}

	public function reward_task_detail(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'kol_id' => 'required|integer',
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new RewardService();
		return $service->reward_task_detail(
			$validated_data['kol_id']
		);
	}

}
