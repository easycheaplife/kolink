<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterUserDataModel extends Model
{
    use HasFactory;
	protected $table = 'twitter_user_data';

	public function insert($user)
	{
		try {
			$this->user_id = $user['id'];
			$this->data = json_encode($user);
			return $this->save();
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
}
