<?php 
/**
 *系统配置
*/

namespace app\admin\controller;

use xhadmin\admin\service\ConfigService;
use app\admin\db\Config as ConfigDb;

class Config extends Admin {


	/*修改*/
	function index(){
		if (!$this->request->isPost()){
			$info = ConfigDb::loadList();
			$this->view->assign('info',$info);
			return $this->display('index');
		}else{
			$data = $this->request->post();
			try{
				$info = ConfigDb::loadList();
				foreach($info as $k=>$v){
					$keyArr[] = $k;
				}
				foreach ($data as $key => $value) {
					$currentData = array();
					$currentData['data'] = $value;
					if(in_array($key,$keyArr)){
						ConfigDb::edit(['name'=>''.$key.''],$currentData);
					}else{
						ConfigDb::createData(['name'=>$key,'data'=>$value]);
					}
				}
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
			
            return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

}

