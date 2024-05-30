<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class ProjectModel extends Model
{
    use HasFactory;

	protected $table = 'project';
	public function insert($token, $email, $logo, $twitter_user_id, $twitter_user_name, $name, $desc, $category_id, $website, &$last_insert_id)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->logo = $logo;
			$this->twitter_user_id = $twitter_user_id;
			$this->twitter_user_name = $twitter_user_name;
			$this->name = $name;
			$this->desc = $desc;
			$this->category_id = $category_id;
			$this->website = $website;
			$ret = $this->save();
			$last_insert_id = DB::connection()->getPdo()->lastInsertId();
			return $ret;
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function get($project_id)
	{
		return $this->select('id', 'token', 'email', 'logo', 'twitter_user_name', 'twitter_user_id', 'name', 'desc', 'website', 'category_id')
			->where('id', $project_id)->first();
	}

	public function login($token)
	{
		return $this->select('id', 'token', 'email', 'logo', 'twitter_user_name', 'twitter_user_id', 'name', 'desc', 'website', 'category_id')
			->where('token', $token)->first();
	}

	public function list($token, $page, $size)
	{
		return $this->select('id', 'token', 'email', 'logo', 'twitter_user_name', 'twitter_user_id', 'name', 'desc', 'website', 'category_id')
			->where('token', $token)
			->orderByDesc('updated_at')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function count($token)
	{
		return $this->where('token', $token)->count();
	}

	public function top_project()
	{
		return $this->take(config('config.default_page_size'))
			->orderByDesc('updated_at')
			->get();
	}

	public function setting($project_id, $name, $desc, $logo, $email)
	{
		return $this->where('id', $project_id)->update([
			'desc' => $desc, 
			'name' => $name, 
			'logo' => $logo, 
			'email' => $email]);
	}

}
