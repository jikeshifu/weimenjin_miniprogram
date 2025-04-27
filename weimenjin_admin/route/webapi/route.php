<?php

//接口路由文件

use think\facade\Route;

Route::post('webapi/sendSms', 'webapi.SmsApi/sendSms');


