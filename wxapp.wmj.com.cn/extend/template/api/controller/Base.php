<?php 

namespace app\ApplicationName\controller;
use think\facade\Validate;
use think\facade\Filesystem;

class Base extends Common{
	
	
	/**
	* @api {post} /Base/upload 01、图片上传
	* @apiGroup Base
	* @apiVersion 1.0.0
	* @apiDescription  图片上传
	
	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回图片地址
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	public function upload(){
		if(!$_FILES){
			return json(['status'=>config('my.errorCode'),'msg'=>'图片上传为空']);
		}
		$file = $this->request->file(array_keys($_FILES)[0]);
		try{
			$file_type = upload_replace(config('my.api_upload_ext')); //上传黑名单检测
			if(!Validate::fileExt($file,$file_type) || !Validate::fileSize($file,config('my.api_upload_max'))){
				throw new \Exception('上传验证失败');
			}
			//检测图片路径已存在  true 检测 读取已有的图片路径 false不检测 每次都重新上传新的
			$upload_hash_status = !is_null(config('my.upload_hash_status')) ? config('my.upload_hash_status') : true; 
			$fileinfo = db("file")->where('hash',$file->hash('md5'))->find();
			if($fileinfo && $upload_hash_status){
				if(!config('my.oss_status')){
					$url = !file_exists('.'.$fileinfo['filepath']) ? $this->up($file) : $fileinfo['filepath'];
				}else{
					$url = $fileinfo['filepath'];
				}
			}else{
				$url = $this->up($file);
			}
		}catch(\Exception $e){
			return json(['status'=>config('my.errorCode'),'msg'=>'上传失败']);
		}
		return json(['status'=>config('my.successCode'),'data'=>$url]);
	}
	
	protected function up($file){
		try{
			if(config('my.oss_status')){
				$url = \utils\oss\OssService::OssUpload(['tmp_name'=>$file->getPathname(),'extension'=>$file->extension()]);
			}else{
				$info = Filesystem::disk('public')->putFile(\utils\oss\OssService::setFilepath(),$file,'uniqid');
				$url = \utils\oss\OssService::getApiFileName(basename($info));
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		$upload_hash_status = !is_null(config('my.upload_hash_status')) ? config('my.upload_hash_status') : true; 
		$upload_hash_status && db('file')->insert(['filepath'=>$url,'hash'=>$file->hash('md5'),'create_time'=>time()]);
		return $url;
	}
	
	
	/**
	* @api {get} /Base/captcha 02、图片验证码地址
	* @apiGroup Base
	* @apiVersion 1.0.0
	* @apiDescription  图片验证码
	* @apiSuccessExample {json} 01 调用示例
	* <img src="http://xxxx.com/Base/captcha" onClick="this.src=this.src+'?'+Math.random()" alt="点击刷新验证码">
	*/
	public function captcha()
	{
		ob_clean();
	    return captcha();
	}

}

