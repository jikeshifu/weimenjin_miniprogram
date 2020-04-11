<?php

namespace app\ApplicationName\controller;
use app\ApplicationName\service\FormExtendService;


class Form extends Base
{
	
	//表单提交页面
	public function index(){
		if ($this->request->isPost()){
			$formData = $this->request->post();
			if(empty($formData['form_id'])){
				$this->error('模型ID不能为空');
			}
			try {
				$res = FormExtendService::saveData($formData);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			$this->success('提交成功');
		}
	}
}
