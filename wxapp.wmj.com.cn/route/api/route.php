<?php

//接口路由文件

use think\facade\Route;

Route::rule('LockAuth/getauthlistbymemid', 'LockAuth/getauthlistbymemid')->middleware(['JwtAuth']);	//根据会员id查询钥匙;
Route::rule('Locktimes/getopentimes', 'Locktimes/getopentimes')->middleware(['JwtAuth']);	//查询可开门时段;
Route::rule('User/update', 'User/update')->middleware(['JwtAuth']);	//修改账户;
Route::rule('User/updatePassword', 'User/updatePassword')->middleware(['JwtAuth']);	//修改密码;
Route::rule('Health/list', 'Health/list')->middleware(['JwtAuth']);	//;
Route::rule('Member/update', 'Member/update')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('Member/view', 'Member/view')->middleware(['JwtAuth']);	//查看用户信息;
Route::rule('Health/view', 'Health/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('Regpoint/update', 'Regpoint/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Regpoint/delete', 'Regpoint/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Regpoint/view', 'Regpoint/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('User/view', 'User/view')->middleware(['JwtAuth']);	//;
Route::rule('Member/viewuserid', 'Member/viewuserid')->middleware(['JwtAuth']);	//查询管理员ID;
Route::rule('Lock/add', 'Lock/add')->middleware(['JwtAuth']);	//添加;
Route::rule('Lock/update', 'Lock/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Lock/delete', 'Lock/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Lock/view', 'Lock/view')->middleware(['JwtAuth']);	//根据lock_id查询锁信息;
Route::rule('Lock/opendoor', 'Lock/opendoor')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('LockAuth/applyauth', 'LockAuth/applyauth')->middleware(['JwtAuth']);	//申请钥匙;
Route::rule('LockAuth/verifyauth', 'LockAuth/verifyauth')->middleware(['JwtAuth']);	//审核钥匙;
Route::rule('LockAuth/delete', 'LockAuth/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockAuth/getauthdetailbyid', 'LockAuth/getauthdetailbyid')->middleware(['JwtAuth']);	//查看数据;
Route::rule('LockLog/add', 'LockLog/add')->middleware(['JwtAuth']);	//添加;
Route::rule('LockLog/update', 'LockLog/update')->middleware(['JwtAuth']);	//修改;
Route::rule('LockLog/delete', 'LockLog/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockLog/view', 'LockLog/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('LockAuth/shareauth', 'LockAuth/shareauth')->middleware(['JwtAuth']);	//生成分享前的临时钥匙;
Route::rule('LockAuth/getkey', 'LockAuth/getkey')->middleware(['JwtAuth']);	//领取钥匙;
Route::rule('Base/Upload', 'Base/Upload')->middleware(['JwtAuth']);	//图片上传;

/*start*/
Route::rule('User/adduser', 'User/adduser')->middleware(['JwtAuth']);	//添加;
/*end*/



