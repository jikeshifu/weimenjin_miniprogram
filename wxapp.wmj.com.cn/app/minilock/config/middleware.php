<?php

return [
	'alias' => [
		'JwtAuth'	=>	app\minilock\http\middleware\JwtAuth::class,
		'SmsAuth'	=>	app\minilock\http\middleware\SmsAuth::class,
		'CaptchaAuth'=>	app\minilock\http\middleware\CaptchaAuth::class,
	],	
];
