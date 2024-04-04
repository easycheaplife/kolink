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
		if ($this->send_mail_new($data['email'], $data['code']))
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

	public function send_mail_new($email, $code)
	{
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.protonmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'kolnksystem@protonmail.comm';
			$mail->Password = 'F0BYKDqw7';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->setFrom('kolinksystem@protonmail.com', 'kolinksystem');
			$mail->addAddress($email, 'Dear');
			$mail->Subject = 'Verification Code';
			$mail->Body = "Your verification code is $code.";
			return $mail->send();
		} catch (Exception $e) {
			Log::error("Email could not be sent. Error: " . $mail->ErrorInfo);
		}
		return false;
	}

}
