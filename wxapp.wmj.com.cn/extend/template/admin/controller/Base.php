<?php

namespace app\ApplicationName\controller;
use \think\facade\Db; 

class Base extends Admin
{
   
    /*修改密码*/
    public function password(){
	    if (!$this->request->isPost()){	
			return $this->display('password');
		}else{			
			$password = $this->request->post('password', '', 'strval');
			try {
				$dt['pk_id'] = session('ApplicationName.pk_id');
				$password = !empty(config('my.password_secrect')) ? trim($password).config('my.password_secrect') : trim($password);
				$dt['pwd'] = md5($password);
				Db::name('tablename')->update($dt);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
            return json(['status'=>'00','message'=>'修改成功']);
		}
    }
  
	

}
