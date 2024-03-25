<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Constants\ErrorCodes;
use App\Http\Services\VerificationService;

class VerificationController extends Controller
{
	public function code(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'email' => 'required|string',
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new VerificationService();
		return $service->code($validated_data['email']);
	}
}
