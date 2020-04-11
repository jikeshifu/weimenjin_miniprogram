<?php

namespace app\ApplicationName\service;

use app\admin\db\Menu;
use xhadmin\db\BaseDb;
use app\admin\db\Field;
use think\facade\Validate;

class FormExtendService
{
	
	//提交表单数据
	public function saveData($formData){
		$fieldList = Field::loadList(['menu_id'=>$formData['form_id']]);
		if(!$fieldList) throw new \Exception('模型不存在');
		$extInfo = Menu::getInfo($formData['form_id']);
		if(!$extInfo['is_submit']) throw new \Exception('禁止投稿');
		unset($formData['form_id']);
		foreach($formData as $k=>$v){
			$fields .= $k.',';
		}
		
		$fields = rtrim($fields,',');
		
		foreach($fieldList as $key=>$val){		
			$rules = [];
			$msg = [];
			foreach($fieldList as $key=>$v){		
				$rule = [];
				if(!empty($v['validate']) || !empty($v['rule'])){
					if(in_array('notEmpty',explode(',',$v['validate']))){
						array_push($rule,'require');
						$msg[$v['field'].'.require'] = $v['name'].'不能为空';
					}

					if(in_array('unique',explode(',',$v['validate']))){
						array_push($rule,'unique:'.$extInfo['table_name']);
						$msg[$v['field'].'.unique'] = $v['name'].'已存在';
					}
					
					if(!empty($v['rule'])){
						$rule['regex'] = $v['rule'];
						$msg[$v['field'].'.regex'] = $v['name'].'格式错误';
					}
					$rules[$v['field']] = $rule;
				}
			}
			
			$validate = Validate::rule($rules)->message($msg);	
			if (!$validate->check($formData)) {
				throw new \Exception($validate->getError());
			}
			
			if($val['type'] == 7){
				$formData[$val['field']] = strtotime($formData[$val['field']]);
			}		
			if($val['type'] == 12){
				$formData[$val['field']] = time();
			}
			if($val['type'] == 20){
				$formData[$val['field']] = ip();
			}
		}
		try{
			BaseDb::setTableName($extInfo['table_name']);
			BaseDb::setPk($extInfo['pk_id']);		
			$reset = BaseDb::createData($formData);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return true;
		
	}
	
}
