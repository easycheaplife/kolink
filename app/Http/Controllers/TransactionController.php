<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\TransactionService;

class TransactionController extends Controller
{
	public function transation_hash(Request $request)
	{
		try {
			$validated_data = $request->validate([
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TransactionService();
		return $service->transation_hash();
	}

	public function transation_list(Request $request)
	{
		$page = $request->input('page', 0);
		$size = $request->input('size', config('config.default_page_size'));
		try {
			$validated_data = $request->validate([
				'address' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TransactionService();
		return $service->transation_list($validated_data['address'], $page, $size);
	}

}
