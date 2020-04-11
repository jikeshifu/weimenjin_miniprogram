<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::post('Menu/add', 'Menu/add')->middleware(['SetTable']);	//创建数据表
Route::post('Menu/update', 'Menu/update')->middleware('UpTable');	//更新数据表
Route::post('Menu/delete', 'Menu/delete')->middleware('DeleteMenu');	//删除菜单
Route::post('Field/add', 'Field/add')->middleware('SetField');	//创建字段
Route::post('Field/update', 'Field/update')->middleware('UpField');	//修改字段
Route::post('Field/delete', 'Field/delete')->middleware('DeleteField');	//删除字段
Route::post('Application/delete', 'Application/delete')->middleware('DeleteApplication');	//删除应用
