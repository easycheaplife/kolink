<?php

return [
	'task_status' => array(
		'application' => 0,
		'cancel' => 1,
		'pengding' => 2,
		'declined' => 3,
		'accept' => 4,
		'upload' => 5,
		'fail' => 6,
		'finish' => 7,
		'close' => 8
	),
	'category_list' => array(
		'All' => 0,
		'Gamefi' => 1,
		'SocialFi' => 2,
		'DEX' => 3,
		'CEX' => 4,
		'DeFi' => 5,
		'InFra' => 6,
		'Safety' => 7,
		'DAO' => 8,
		'Tool' => 9,
		'Others' => 10,
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
		'Other' => 8
	),
	'language_list' => array(
		'All' => 0,
		'English' => 1,
		'French' => 2,
		'Other' => 3
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
	'http_timeout' => 3,
	'verification_code_valid_time' => 300,
];
