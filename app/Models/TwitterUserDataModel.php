<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterUserDataModel extends Model
{
    use HasFactory;
	protected $table = 'twitter_user_data';

	public function insert($user, $insert_flag)
	{
		try {
			$this->user_id = $user['id'];
			$this->data = json_encode($user);
			$this->insert_flag = $insert_flag;
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				Log::error($e->getMessage());
				return true;	
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function count()
	{
		return $this->select('id')
			  ->where('insert_flag', 0)
			  ->count();
	}

	public function get_users($page, $size)
	{
		return $this->select('id', 'data')
			->skip($page * $size)
			->take($size)
			->get();
	}

	public function update_insert_flag($id)
	{
		return $this->where('id', $id)
			->update(['insert_flag' => 1]);
	}

}
