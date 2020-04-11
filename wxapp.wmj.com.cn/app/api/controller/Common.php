<?php

namespace app\api\controller;
use think\App;
use think\facade\Log;

class Common
{
    
	protected $request;
    protected $app;
	
	protected $_data;
	protected $successCode;
	protected $errorCode;
	
    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
		//exit('禁止访问');
        $this->app     = $app;
        $this->request = $this->app->request;
		$this->_data = $this->request->param();
		
		//判断是否是json请求
		if(!$this->request->isJson()){
			$this->_data = $this->request->param();
		}else{
			$this->_data = json_decode(file_get_contents('php://input'),true);
		}
		
		$this->_data['timestamp'] = date('Y-m-d H:i:s', time());
		$this->_data['uid'] = $this->request->uid;
		
		$this->successCode = config('my.successCode');
		$this->errorCode = config('my.errorCode');
		
		if(config('my.api_input_log')){
			Log::info('接口地址：'.request()->pathinfo().',接口输入：'.print_r($this->_data,true));
		}
    }
	
	 /**
     * 生成token
     * @param  uid 用户UID
     */
	protected function setToken($uid){
		$jwt = Jwt::getInstance();
		$jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecrect(config('my.jwt_secrect'))->setExpTime(config('my.jwt_expire_time'));
		$token = $jwt->setUid($uid)->encode()->getToken();
		return $token;
	}
	
	public function __call($method, $args)
    {
        return json(['status'=>'01','msg'=>'方法不存在']);
    }

	
}
