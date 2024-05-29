<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;


class YoutubeUserModel extends Model
{
    use HasFactory;

	protected $table = 'youtube_user';

	public $timestamps = false;

	public function convert_to_unixtime($datetimeStr) {
		$datetime = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $datetimeStr);
		if ($datetime === false) {
			$datetime = DateTime::createFromFormat('D M d H:i:s O Y', $datetimeStr);
		}
		if ($datetime !== false) {
			return $datetime->getTimestamp();
		}
		return time();
	}

	public function insert($user)
	{
		try {
			$this->user_id = $user['items'][0]['id'];
			$this->title = $user['items'][0]['snippet']['title'];
			$this->description = $user['items'][0]['snippet']['title'];
			$this->custom_url = $user['items'][0]['snippet']['customUrl'];
			$this->view_count = $user['items'][0]['statistics']['viewCount'];
			$this->subscriber_count = $user['items'][0]['statistics']['subscriberCount'];
			$this->video_count = $user['items'][0]['statistics']['videoCount'];
			$this->created_at = $this->convert_to_unixtime($user['items'][0]['snippet']['publishedAt']);
			$this->updated_at = $this->created_at;
			return $this->save();
		}
		catch (QueryException $e)
		{
			if ($e->errorInfo[1] == ErrorCodes::ERROR_CODE_DUPLICATE_ENTRY)
			{
				return $this->update_user($user);
			}
			Log::error($e->getMessage());
		}
		return false;
	}

	public function update_user($user)
	{
		return $this->where('user_id', $user['items'][0]['id'])->update([
			'title' => $user['items'][0]['snippet']['title'], 
			'description' => $user['items'][0]['snippet']['title'],
			'custom_url' => $user['items'][0]['snippet']['customUrl'],
			'view_count' => $user['items'][0]['statistics']['viewCount'],
			'subscriber_count' => $user['items'][0]['statistics']['subscriberCount'],
			'video_count' => $user['items'][0]['statistics']['videoCount'],
			'updated_at' => time()]);
	}

}
