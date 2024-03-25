<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
	public function index()
	{   
		$data = [ 
			'message' => 'Hello, world!',
			'timestamp' => now()
		];  

		return response()->json($data);
	}   
}
