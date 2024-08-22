<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Constants\ErrorCodes;
use App\Http\Services\TwitterService;


class TwitterController extends Controller
{
	public function auth(Request $request)
	{
		$redirect_uri = $request->input('redirect_uri','');
		try {
			$validated_data = $request->validate([
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->auth($redirect_uri);
	}

	public function auth2(Request $request)
	{
		$debug = $request->input('debug',0);
		$redirect_uri = $request->input('redirect_uri', config('config.twitter_redirect_uri'));
		try {
			$validated_data = $request->validate([
				'code' => 'required|string',
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->auth2($redirect_uri, $validated_data['code'], $debug);
	}

	public function user(Request $request)
	{
		$redirect_uri = $request->input('redirect_uri','');
		try {
			$validated_data = $request->validate([
				'session_id' => 'required|string',
				'oauth_verifier' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->user($validated_data['session_id'],
			$validated_data['oauth_verifier'],
			$redirect_uri);
	}

	public function user2(Request $request)
	{
		$debug = $request->input('debug',0);
		try {
			$validated_data = $request->validate([
				'access_token' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->user2($validated_data['access_token'], $debug);
	}

	public function tweets(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'screen_name' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->tweets($validated_data['screen_name']);
	}

	public function tweets_content_relevance(Request $request)
	{
		try {
			$validated_data = $request->validate([
				'screen_name' => 'required|string',
				'keywords' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->tweets_content_relevance($validated_data['screen_name'],
			$validated_data['keywords']);
	}

	public function tweets_analysis(Request $request)
	{
		$default_size = config('config.twitter_tweets_default_size');
		$posts = $request->input('posts', $default_size);
		if (!in_array($posts, [7,30]))
		{
			$posts = $default_size;
		}
		try {
			$validated_data = $request->validate([
				'screen_name' => 'required|string'
			]);
		}
		catch (ValidationException $e)
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_INPUT_PARAM_ERROR, $e->getMessage());
		}
		$service = new TwitterService();
		return $service->tweets_analysis($validated_data['screen_name'],
			$posts);
	
	}

}
