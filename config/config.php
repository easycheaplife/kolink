<?php

return [
	'task_status' => array(
		'application' => 0,
		'cancel' => 1,
		'pending' => 2,
		'declined' => 3,
		'accept' => 4,
		'upload' => 5,
		'fail' => 6,
		'finish' => 7,
		'close' => 8,
		'lock_pending' => 9,
		'cancel_pending' => 10,
		'settle_pending' => 11,
		'delegate_settle_pending' => 12,
		'upload_timeout_cancel_pending' => 13,
		'upload_timeout_cancel' => 14,
	),
	'category_list' => array(
		'All' => 0,
		'GameFi' => 1,
		'SocialFi' => 2,
		'DEX' => 3,
		'CEX' => 4,
		'DeFi' => 5,
		'InFra' => 6,
		'Safety' => 7,
		'DAO' => 8,
		'Tool' => 9,
		'AI' => 10,
		'RWA' => 11,
		'Meme' => 12,
		'DePin' => 13,
		'Other' => 99,
	),
	'region_list' => array(
		'All' => 0,
		'Europe' => 1,
		'Asia' => 2,
		'North And South America' => 3,
		'Southeast Asia' => 4,
		'South Asia' => 5,
		'Africa' => 6,
		'CIS' => 7,
		'Other' => 99
	),
	'language_list' => array(
		'All' => 0,
		'English' => 1,
		'French' => 2,
		'Chinese' => 3,
		'Spanish' => 4,
		'German' => 5,
		'Russian' => 6,
		'Portuguese' => 7,
		'Hindi' => 8,
		'Turkish' => 9,
		'Filipino' => 10,
		'Indonesian' => 11,
		'Vietnamese' => 12,
		'Arabic' => 13,
		'Japanese' => 14,
		'Thai' => 15,
		'Pakistan' => 16,
		'Italian' => 17,
		'Ukrainian' => 18,
		'Urdu' => 19,
		'Other' => 99
	),
	'transaction_type' => array(
		'lock_assert' => 0,
		'settle' => 1,
		'delegate_settle' => 2,
		'cancel_lock' => 3
	),
	'default_page_size' => 10,
	'mail_try_times' => 3,
	'twitter_url_base' => 'http://localhost:8010',
	'http_timeout' => 10,
	'verification_code_valid_time' => 300,
	'verification_type' => array('kol' => 0, 'project' => 1), 
	'verification_subject' => array(0 => 'KOLink - Confirm Your Email Address', 1 => 'KOLink - Confirm Your Email Address'), 
	'verification_body' => array(
		0 => 
	"Thank you for joining KOLink! We're excited to have you onboard as we work together to redefine content creation and influencer marketing.<br><br>" .
	"<span style='font-size: 20px;'>Your verification code is: <strong>%s</strong></span><br><br>" .
	"If you did not initiate this request, please ignore this message.<br><br>" .
	"We look forward to seeing the amazing content you'll create and the connections you'll build.<br><br>" .
	"Warm regards,<br>" .
	"The KOLink Team", 
		1 => 
	"Welcome to KOLink, the hub where projects meet top-tier influencers! Please confirm your email to begin your journey: <br><br>" .
	"<span style='font-size: 20px;'>Verification code: <strong>%s</strong></span><br><br>" .
	"If you did not initiate this request, please ignore this message. <br><br>" .
	"Thank you for choosing KOLink. <br><br>" .
	"Warm regards,<br>" .
	"The KOLink Team"
	), 
	'task_accept_timeout' => 7,
	'task_review_timeout' => 7,
	'etherscan_api_key' => '3IEU6UYCNQN43DFVF5BJM9SP32HH5PZHH8',
	'etherscan_url_base' => 'https://api.etherscan.io/api',
	'contractaddress' => '0xD7aAdD7BD1d12ee13E1f4Db8BB56458882796bE4',
	'twitter_client_id' => 'emNmLUt4WEt4SlFWekpCMjNxSWw6MTpjaQ',
	'twitter_redirect_uri' => 'http://localhost:8888/oauth',
];
