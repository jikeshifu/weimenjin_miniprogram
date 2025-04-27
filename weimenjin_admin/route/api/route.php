<?php

//接口路由文件

use think\facade\Route;

Route::rule('LockAuth/getauthlistbymemid', 'LockAuth/getauthlistbymemid')->middleware(['JwtAuth']);	//根据会员id查询钥匙;
Route::rule('LockLog/getopenlog', 'LockLog/getopenlog')->middleware(['JwtAuth']);	//获取开门日志;
Route::rule('Locktimes/getopentimes', 'Locktimes/getopentimes')->middleware(['JwtAuth']);	//查询可开门时段;
Route::rule('LockCard/getcardlistbylockid', 'LockCard/getcardlistbylockid')->middleware(['JwtAuth']);	//获取锁下卡列表;
Route::rule('User/update', 'User/update')->middleware(['JwtAuth']);	//修改账户;
Route::rule('User/updatePassword', 'User/updatePassword')->middleware(['JwtAuth']);	//修改密码;
Route::rule('Health/list', 'Health/list')->middleware(['JwtAuth']);	//;
//Route::rule('Member/update', 'Member/update')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('Member/view', 'Member/view')->middleware(['JwtAuth']);	//查看用户信息;
Route::rule('device.LockAuth/applyAuth', 'device.LockAuth/applyAuth')->middleware(['JwtAuth']);	//申请钥匙;
Route::rule('device.Device/qrOpenLock', 'device.Device/qrOpenLock')->middleware(['JwtAuth']);	//二维码开门;
Route::rule('device.Device/openLock', 'device.Device/openLock')->middleware(['JwtAuth']);	//开门;
Route::rule('Health/view', 'Health/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('Regpoint/update', 'Regpoint/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Regpoint/delete', 'Regpoint/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Regpoint/view', 'Regpoint/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('User/view', 'User/view')->middleware(['JwtAuth']);	//;
Route::rule('Member/viewuserid', 'Member/viewuserid')->middleware(['JwtAuth']);	//查询管理员ID;
Route::rule('Lock/update', 'Lock/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Lock/delete', 'Lock/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Lock/view', 'Lock/view')->middleware(['JwtAuth']);	//根据lock_id查询锁信息;
//Route::rule('Lock/opendoor', 'Lock/opendoor')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('LockAuth/applyauth', 'LockAuth/applyauth')->middleware(['JwtAuth']);	//申请钥匙;
Route::rule('LockAuth/verifyauth', 'LockAuth/verifyauth')->middleware(['JwtAuth']);	//审核钥匙;
Route::rule('LockAuth/delete', 'LockAuth/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockLog/add', 'LockLog/add')->middleware(['JwtAuth']);	//添加;
Route::rule('LockLog/update', 'LockLog/update')->middleware(['JwtAuth']);	//修改;
Route::rule('LockLog/delete', 'LockLog/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockLog/view', 'LockLog/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('LockAuth/shareauth', 'LockAuth/shareauth')->middleware(['JwtAuth']);	//生成分享前的临时钥匙;
Route::rule('LockAuth/getkey', 'LockAuth/getkey')->middleware(['JwtAuth']);	//领取钥匙;
Route::rule('LockAuth/getauthlistbylockid', 'LockAuth/getauthlistbylockid')->middleware(['JwtAuth']);	//;
Route::rule('LockLog/getopenlogbylockid', 'LockLog/getopenlogbylockid')->middleware(['JwtAuth']);	//;
Route::rule('LockCard/addauthcard', 'LockCard/addauthcard')->middleware(['JwtAuth']);	//添加钥匙下的卡;
Route::rule('LockCard/updatecard', 'LockCard/updatecard')->middleware(['JwtAuth']);	//更新卡;
Route::rule('LockCard/delcard', 'LockCard/delcard')->middleware(['JwtAuth']);	//删除卡;
Route::rule('LockCard/viewcarddetail', 'LockCard/viewcarddetail')->middleware(['JwtAuth']);	//查看卡数据;
Route::rule('Lock/configaudio', 'Lock/configaudio')->middleware(['JwtAuth']);	//修改语音设置;
Route::rule('Lock/configlcd', 'Lock/configlcd')->middleware(['JwtAuth']);	//配置显示屏二维码;
Route::rule('Member/getuserbymobile', 'Member/getuserbymobile')->middleware(['JwtAuth']);	//根据手机号查询用户;
Route::rule('device.Face/add', 'device.Face/add')->middleware(['JwtAuth']);	//根据手机号查询用户;
Route::rule('Base/Upload', 'Base/Upload')->middleware(['JwtAuth']);	//图片上传;
Route::rule('Lock/add', 'Lock/add')->middleware(['JwtAuth']);	//添加设备;
Route::rule('Member/loginQrCode', 'Member/loginQrCode')->middleware(['JwtAuth']);	//添加设备;
Route::rule('device.Device/list', 'device.Device/list')->middleware(['JwtAuth']);


/*start*/
Route::rule('User/adduser', 'User/adduser')->middleware(['JwtAuth']);	//添加;
//Route::rule('Member/getphonenumber', 'Member/getphonenumber')->middleware(['JwtAuth']);	//添加;

Route::rule('device.Device/electricityStop', 'device.Device/electricityStop')->middleware(['JwtAuth']);	//添加;
Route::rule('device.Device/electricityStart', 'device.Device/electricityStart')->middleware(['JwtAuth']);	//添加;


//分组管理
Route::rule('device.DeviceGroup/all', 'device.DeviceGroup/all')->middleware(['JwtAuth']);
Route::rule('device.DeviceGroup/add', 'device.DeviceGroup/add')->middleware(['JwtAuth']);
/*end*/



