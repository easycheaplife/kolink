<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Services\VerificationService;


class MailService extends Service 
{
    public function mail_task()
	{
		$verification_service = new VerificationService;
		$data = $verification_service->unsend_code();
		if (empty($data))
		{
			return;
		}
		Log::info('email:' . $data['email'] . ',code:' . $data['code']);	
		if ($this->send_mail_new($data['email'], $data['code'], $data['type']))
		{
			$verification_service->update_send_flag($data['id']);	
			Log::info("send mail success!");	
		}
		else 
		{
			Log::info("send mail failed!");	
		}
		$verification_service->inc_try_times($data['id']);	
	}	

	public function send_mail($email, $code)
	{
		$headers = array('From' => env('MAIL_FROM_ADDRESS'));
		return mail($email, 'Verification Code', "$code", $headers);
	}

	public function send_mail_new($email, $code, $type)
	{
		$mail = new PHPMailer(true);
		try {
			$mail->isHTML(true);
			$mail->isSMTP();
			$mail->Host = env('MAIL_HOST');
			$mail->SMTPAuth = true;
			$mail->Username = env('MAIL_USERNAME');
			$mail->Password = env('MAIL_PASSWORD');
			$mail->SMTPSecure = env('MAIL_ENCRYPTION');
			$mail->Port = env('MAIL_PORT');
			$mail->setFrom(env('MAIL_FROM_ADDRESS'));
			$mail->addAddress($email, 'Dear');
			$mail->Subject = config('config.verification_subject')[$type];
			$mail->Body = sprintf(config('config.verification_body')[$type], strval($code));
			return $mail->send();
		} catch (Exception $e) {
			Log::error("Email could not be sent. Error: " . $mail->ErrorInfo);
		}
		return false;
	}

}
