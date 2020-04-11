<?php

namespace app\ApplicationName\controller;
use app\BaseController;

class Admin extends BaseController
{
	
	//视图全局过滤
	public function display($tpl){
		$this->filterView();
		return $this->view->fetch($tpl);
	}
	
}
