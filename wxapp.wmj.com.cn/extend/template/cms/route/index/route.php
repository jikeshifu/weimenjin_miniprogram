<?php

//接口路由文件

use think\facade\Route;

Route::rule('about/:class_id','ApplicationName/About/index');
Route::rule('view/:content_id','ApplicationName/View/index');

