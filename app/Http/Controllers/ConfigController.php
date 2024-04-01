<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ConfigService;

class ConfigController extends Controller
{
	public function list(Request $request)
	{
		$service = new ConfigService();
		return $service->list();
	}
}
