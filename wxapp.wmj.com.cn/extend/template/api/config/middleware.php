<?php

return [
	'alias' => [
		'JwtAuth'	=>	app\ApplicationName\http\middleware\JwtAuth::class,
		'SmsAuth'	=>	app\ApplicationName\http\middleware\SmsAuth::class,
		'CaptchaAuth'=>	app\ApplicationName\http\middleware\CaptchaAuth::class,
	],	
];
