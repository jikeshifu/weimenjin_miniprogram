<?php

namespace app\admin\controller;
use app\admin\service\ApplicationService;
use app\admin\db\Application as app;
use think\facade\Env;

class Application extends Admin
{
	
	
    public function index(){
	   
	   if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = input('post.limit', 0, 'intval');
			$offset = input('post.offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = ApplicationService::pageList($where,$limit);
			}catch(\Exception $e){
				exit($e->getMessage());
			}
			$data['rows']  = $res['list'];
			$data['total'] = $res['count'];

			return json($data);
		}
    }
	
	public function add(){
		if (!$this->request->isPost()){
			return $this->display('info');
		}else{
			$data = input('post.');
			try{
				ApplicationService::saveData('add',$data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}
	
	public function update(){
		if (!$this->request->isPost()){
			$app_id = $this->request->get('app_id','','intval');
			if(!$app_id) $this->error('参数错误');

			$info = App::getInfo($app_id);
			if(!$info) $this->error('没有数据');
			$this->view->assign('info',$info);
			return $this->display('info');
		}else{
			$data = $this->request->post();
			try{
				ApplicationService::saveData('edit',$data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
	
	public function delete(){
		$app_id = $this->request->post('app_id','','intval');
		if(!$app_id) $this->error('参数错误');
		if($app_id == 1 ) $this->error('禁止操作');
		try{
			ApplicationService::delete($app_id);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	
	
	//生成应用
	public function createApplication(){
		$app_id = $this->request->post('app_id','','intval');
		try{
			if($app_id == 1) $this->error('禁止生成');
			$applicationInfo = app::getInfo($app_id);
			if(!$applicationInfo['status']) $this->error('禁止生成');
			$rootPath = app()->getRootPath();
			
			switch($applicationInfo['app_type']){
				case 1:
					$this->read_admin_all($rootPath.'extend/template/admin',$applicationInfo);
				break;
				
				case 2:
					$this->read_api_all($rootPath.'extend/template/api',$applicationInfo);
				break;
				
				case 3:
					$this->read_cms_all($rootPath.'extend/template/cms',$applicationInfo);
					
					$list = db()->query('show tables');
					foreach($list as $k=>$v){
						$array[] = $v['Tables_in_'.config('database.connections.mysql.database')];
					}
					if(!in_array(config('database.connections.mysql.prefix').'catagory',$array)){
						$file = $rootPath.'extend/template/cms.sql';
						$gz   = fopen($file, 'r');
						for($i = 0; $i < 1000; $i++){
							$sql .= str_replace('cd_',config('database.connections.mysql.prefix'),fgets($gz));
							if(preg_match('/.*;$/', trim($sql))){
								if(false !== db()->query($sql)){
									$start += strlen($sql);
								} else {
									return false;
								}
								$sql = '';
							} 
						}
					}
				break;
					
			}
			
		}catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		
		return json(['status'=>'00','msg'=>'生成成功']);
		
	}
	
	//生成后台应用
	function read_admin_all($dir,$applicationInfo){
		if(!is_dir($dir)) return false;
		$handle = opendir($dir);
		if($handle){
			while(($fl = readdir($handle)) !== false){
				$temp = $dir.DIRECTORY_SEPARATOR.$fl;
				if(is_dir($temp) && $fl!='.' && $fl != '..'){
					$this->read_admin_all($temp,$applicationInfo);
				}else{
					if($fl!='.' && $fl != '..'){
						$rootPath = str_replace('\\','/',app()->getRootPath());
						$file = str_replace('\\','/',$temp);
						
						$content =str_replace('ApplicationName',$applicationInfo['app_dir'],file_get_contents($file));
						$filepath = str_replace($rootPath.'extend/template/admin',$rootPath.'app/'.$applicationInfo['app_dir'],$file);
						
						if($filepath == $rootPath.'app/'.$applicationInfo['app_dir'].'/service/AuthService.php'){
							$content = str_replace('ApplicationName',$applicationInfo['app_dir'],$content);
							list($username,$password) = explode('|',$applicationInfo['login_fields']);
							$content = str_replace('tempUsername',$username,$content);
							$content = str_replace('tempPassword',$password,$content);
							$content = str_replace('tablename',$applicationInfo['login_table'],$content);
						}
						
						if($filepath == $rootPath.'app/'.$applicationInfo['app_dir'].'/controller/Index.php'){
							$content = str_replace('appId',$applicationInfo['app_id'],$content);
						}
						
						if($filepath == $rootPath.'app/'.$applicationInfo['app_dir'].'/controller/Base.php'){
							$content = str_replace('ApplicationName',$applicationInfo['app_dir'],$content);
							list($username,$password) = explode('|',$applicationInfo['login_fields']);
							$content = str_replace('pk_id',$applicationInfo['pk'],$content);
							$content = str_replace('pwd',$password,$content);
							$content = str_replace('tablename',$applicationInfo['login_table'],$content);
						}
						
						filePutContents($content,$filepath,$type=2);
					}
				}
			}
		}
	}
	
	//生成api应用
	function read_api_all($dir,$applicationInfo){
		if(!is_dir($dir)) return false;
		$handle = opendir($dir);
		if($handle){
			while(($fl = readdir($handle)) !== false){
				$temp = $dir.DIRECTORY_SEPARATOR.$fl;
				if(is_dir($temp) && $fl!='.' && $fl != '..'){
					$this->read_api_all($temp,$applicationInfo);
				}else{
					if($fl!='.' && $fl != '..'){
						$rootPath = str_replace('\\','/',app()->getRootPath());
						$file = str_replace('\\','/',$temp);
						$content =str_replace('ApplicationName',$applicationInfo['app_dir'],file_get_contents($file));
						$filepath = str_replace($rootPath.'extend/template/api',$rootPath.'app/'.$applicationInfo['app_dir'],$file);
						
						if($filepath == $rootPath.'app/'.$applicationInfo['app_dir'].'/apidoc.json'){
							$content = str_replace('appname',$applicationInfo['name'],$content);
							$content = str_replace('domain',$applicationInfo['domain'],$content);
						}

						filePutContents($content,$filepath,$type=2);
					}
				}
			}
		}
	}
	
	
	//生成cms应用
	function read_cms_all($dir,$applicationInfo){
		if(!is_dir($dir)) return false;
		$handle = opendir($dir);
		if($handle){
			while(($fl = readdir($handle)) !== false){
				$temp = $dir.DIRECTORY_SEPARATOR.$fl;
				if(is_dir($temp) && $fl!='.' && $fl != '..'){
					$this->read_cms_all($temp,$applicationInfo);
				}else{
					$rootPath = str_replace('\\','/',app()->getRootPath());
					$file = str_replace('\\','/',$temp);
					$content =str_replace('ApplicationName',$applicationInfo['app_dir'],file_get_contents($file));
					$content =str_replace('cd_',config('database.connections.mysql.prefix'),$content);
					$filepath = str_replace($rootPath.'extend/template/cms',$rootPath,$file);
					$filepath = str_replace('app/index','app/'.$applicationInfo['app_dir'],$filepath);
					$filepath = str_replace('route/index','route/'.$applicationInfo['app_dir'],$filepath);
					
					if(strpos($filepath,'index.html') > 0 && file_get_contents($filepath) && file_get_contents($filepath) <> '欢迎使用xhadmin'){
						filePutContents(file_get_contents($filepath),$filepath,$type=2);
					}else{
						filePutContents($content,$filepath,$type=2);
					}
				}
			}
		}
		
	}
	
}
