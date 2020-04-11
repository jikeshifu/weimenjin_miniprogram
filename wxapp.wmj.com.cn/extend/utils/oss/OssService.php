<?php

namespace utils\oss;


class OssService
{
	
	
	private static $filepath;	//文件存储路径
	
	/**
	 * 设置本地存储路径
	 * @param  string type 业务号
	 * @return string 
	 */
	public static function setFilepath(){
		self::$filepath = app('http')->getName().'/'.date(config('my.upload_subdir'));
		return self::$filepath;
	}
	
	
	/**
	 * 返回本地存储完整文件路径 后台的
	 * @param  string type 业务号
	 * @return string 
	 */
	public static function getAdminFileName($filename){
		if(config('xhadmin.domain')){
			$url = config('xhadmin.domain').'/'.self::$filepath.'/'.$filename;
		}else{
			$url = ltrim(config('my.upload_dir'),'.').'/'.self::$filepath.'/'.$filename;
		}
		return $url;
	}
	
	/**
	 * 返回本地存储完整文件路径 api的
	 * @param  string type 业务号
	 * @return string 
	 */
	public static function getApiFileName($filename){
		if(config('my.api_upload_domain')){
			$url = config('my.api_upload_domain').'/'.self::$filepath.'/'.$filename;
		}else{
			$url = ltrim(config('my.upload_dir'),'.').'/'.self::$filepath.'/'.$filename;
		}
		return $url;
	}
	
	/**
	 * 图片oss存储路径
	 * @param  string type 业务号
	 * @return string 
	 */
	public static function setKey($type,$tmpInfo){
		$filepath = app('http')->getName().'/'.date(config('my.upload_subdir')).'/'.doOrderSn($type).'.'.$tmpInfo['extension']; //上传路径
		return $filepath;
	}
	
	
	/**
	 * oss开始上传
	 * @param  string tmpInfo 图片临时文件信息
	 * @return string oss返回图片完整路径
	 */
	public static function OssUpload($tmpInfo){
		
		switch(config('my.oss_default_type')){
			case 'ali';
				$url = \utils\oss\AliOssService::upload($tmpInfo);	//七牛云上传
			break;
			
			case 'qiniuyun';
				$url = \utils\oss\QnyOssService::upload($tmpInfo);	//阿里上传
			break;
		}
		
		return $url;
	}
	
	
	
}
