<?php 

namespace app\admin\controller;
use app\admin\service\BackupService;


class Backup extends Admin {


	/*数据备份管理*/
	function index(){
		return $this->display('index');
	}

	/*数据初始化*/
	function listData(){

		$limit  = input('post.limit', 0, 'intval');
		$offset = input('post.offset', 0, 'intval');
		$page   = floor($offset / $limit) +1 ;

		try{
			$res = BackupService::loadList();
		}catch(\Exception $e){
			exit($e->getMessage());
		}
		$list = $res['list'];
		$data['rows']  = $list;
		$data['total'] = $res['count'];

		return json($data);

	}
	
	/*数据表列表*/
	function table(){
		return $this->display('table');
	}
	
	
	function tableList(){

		$limit  = 200;
		$offset = input('post.offset', 0, 'intval');
		$page   = floor($offset / $limit) +1 ;

		try{
			$res = BackupService::tableList();
		}catch(\Exception $e){
			exit($e->getMessage());
		}
		$list = $res;
		$data['rows']  = $list;
		$data['total'] = count($res);

		return json($data);

	}
	
	//开始备份数据
	public function backupData(){
		try{
			$tablename = input('post.tablename', '', 'strval');
			BackupService::backupData($tablename);
		}catch(\Exception $e){
			exit($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'备份成功']);
	}
	
	//删除
	public function delete(){
		try{
			$filename = input('post.filename', '', 'strval');
			BackupService::delete($filename);
		}catch(\Exception $e){
			exit($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	
	//下载
	public function download(){
		$filename = input('post.filename', '', 'strval');
		$filepath = '/backup/'.$filename.'.sql.gz';
		return json(['filepath'=>$filepath]);
	}
	

}