<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;
use App\Models\ProjectModel;

class ProjectService extends Service 
{
    public function project_new($token, $email, $logo, $twitter_user_name, $name, $desc, $category_id, $website)
	{
		$project_model = new ProjectModel;
		if ($project_model->insert($token, $email, $logo, $twitter_user_name, 
			$name, $desc, $category_id, $website))
		{
			return $this->error_response($openid, ErrorCodes::ERROR_CODE_DB_ERROR,
				EerrDescs::ERROR_CODE_DB_ERROR);		
		}
		return $this->res;
	}	

}
