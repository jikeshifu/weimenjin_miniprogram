<?php

return [
	'alias' => [
		'JwtAuth'	=>	app\api\http\middleware\JwtAuth::class,
		'SmsAuth'	=>	app\api\http\middleware\SmsAuth::class,
		'CaptchaAuth'=>	app\api\http\middleware\CaptchaAuth::class,
	],	
];
