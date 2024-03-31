<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;

	protected $table = 'project';
	public function insert($token, $email, $logo, $twitter_user_name, $name, $desc, $category_id, $website)
	{
		try {
			$this->token = $token;
			$this->email = $email;
			$this->logo = $logo;
			$this->twitter_user_name = $twitter_user_name;
			$this->name = $name;
			$this->desc = $desc;
			$this->category_id = $category_id;
			$this->website = $website;
			return $this->save();
		}
		catch (Exception $e)
		{
			Log::info($e->getMessage());
		}
		return false;
	}

	public function get($project_id)
	{
		return $this->where('id', $project_id)->first();
	}

	public function list($token)
	{
		return $this->where('token', $token)->get();
	}

	public function top_project()
	{
		return $this->all();
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
