<?php

namespace app\ApplicationName\controller;
use app\ApplicationName\controller\Admin;
use think\facade\Validate;
use think\facade\Filesystem;

class Upload extends Admin{
	
	
	//上传文件检测hash唯一 不存在文件则上传 并且记录文件信息 存在文件信息 则先检测文件物理路径存在否 不存在也上传 否则返回文件路径
	private function upload($filekey){
		$file = $this->request->file($filekey);
		try{
			$file_type = upload_replace(config('xhadmin.file_type')); //上传黑名单检测
			if(!Validate::fileExt($file,$file_type) || !Validate::fileSize($file,config('xhadmin.file_size') * 1024 * 1024)){
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
			log::error('图片上传错误：'.print_r($e->getMessage(),true));
			throw new \Exception($e->getMessage());
		}
		return $url;
	}
	
	protected function up($file){
		try{
			if(config('my.oss_status')){
				$url = \utils\oss\OssService::OssUpload(['tmp_name'=>$file->getPathname(),'extension'=>$file->extension()]);
			}else{
				$info = Filesystem::disk('public')->putFile(\utils\oss\OssService::setFilepath(),$file,'uniqid');
				$url = \utils\oss\OssService::getAdminFileName(basename($info));
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		$upload_hash_status = !is_null(config('my.upload_hash_status')) ? config('my.upload_hash_status') : true; 
		$upload_hash_status && db('file')->insert(['filepath'=>$url,'hash'=>$file->hash('md5'),'create_time'=>time()]);
		
		return $url;
	}
	
	//普通图片上传
	public function uploadImages()
	{
		$url = $this->upload('file');
		if($url){
			return json(['code'=>1,'data'=>$url]);
		}else{
			return json(['code'=>0,'msg'=>'上传失败']);
		}
	}
	
	
	//xheditor编辑器上传
	public function editorUpload() {
		$url = $this->upload('filedata');
		if($url){
			echo '{err: "", msg: {url: "!'.$url.'", localname: "", id: "1"}}';
		}
	}
	
	
	//百度编辑器上传
	public function uploadUeditor(){
		$ueditor_config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("static/js/ueditor/php/config.json")), true);
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result = json_encode($ueditor_config);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
				$url = $this->upload('upfile');
				$result = json_encode(array(
					'url' => $url,
					'title' => htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
					'original' => basename($url),
					'state' => 'SUCCESS'
				));
                break;
            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
	}
	
    
}