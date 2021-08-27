<?php

namespace app\admin\service;
use xhadmin\CommonService;
use app\admin\db\Action;
use app\admin\db\Field;


class ActionService extends CommonService
{
	
	/*
     * @Description  获取应用数据列表
	 * @param (输入参数：)  {array}        where 查询条件
	 * @param (输入参数：)  {int}          limit 分页参数
     * @param (输入参数：)  {String}       field 查询字段
     * @param (输入参数：)  {String}       orderby 排序字段
     * @return (返回参数：) {array}        分页数据集
	 */
	public static function pageList($where=[],$limit,$field="*",$orderby=''){
		
		try{
			$list = Action::loadList($where,$limit,$field,$orderby);
			$count = Action::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return ['list'=>$list,'count'=>$count];	
	}
	
	 /*
     * @Description  添加或修改信息
	 * @param (输入参数：)  {string}        type 操作类型 add 添加 update修改
     * @param (输入参数：)  {array}         data 原始数据
     * @return (返回参数：) {bool}        
	 */
	public static function saveData($type,$data){
		
		try{
			
			$data['name'] = trim($data['name']);
			$data['block_name'] = trim($data['block_name']);
			
			//调用验证器
			$rule = [
				'name'  => 'require',
				'name'=>['regex'=>'/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9|\(|\)|\（|\）]+$/u'],
				'action_name'  => 'require',
				'action_name'=>['regex'=>'/^[a-zA-Z_]+$/'],
				'pagesize'=>['regex'=>'/^[1-9]\d*$/'],
				'tree_config'=>['regex'=>'/^[,a-z_]+$/'],
				'block_name'=>['regex'=>'/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9|\(|\)|\（|\）]+$/u'],
				'relate_table'=>['regex'=>'/^[a-zA-Z0-9_]+$/'],
			];
			
			//错误提示
			$msg = [
				'name.require'  => '操作名称必填',
				'name.regex'=>'操作名称中文数字小写字母或下划线',
				'action_name.require'  => '方法名称必填',
				'action_name.regex'=>'方法名称小写字母组合',
				'pagesize.regex'=>'分页整数',
				'tree_config.regex'=>'树配置小写字母 逗号组合',
				'block_name.regex'=>'方法描述名称中文数字小写字母或下划线',
				'relate_table.regex'=>'关联表小写字母组合',
			];
			
			self::validate($rule,$data,$msg);
			
			if($type == 'add'){
				$info = Action::getWhereInfo(['menu_id'=>$data['menu_id'],'type'=>$data['type'],'action_name'=>$data['action_name']]);
				if(!$info){
					$reset = Action::createData($data);
					if($reset){
						Action::edit(['id'=>$reset,'sortid'=>$reset]); //更新排序
					}
				}else{
					throw new \Exception('方法已经存在');
				}
			}elseif($type == 'edit'){
				$reset = Action::edit($data);
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
	 /*
     * @Description  快速生成操作方法
     * @param (输入参数：)  {array}         data 原始数据
     * @return (返回参数：) {bool}        
	 */
	public static function addFast($data){
		
		$actions = explode(',',$data['actions']);
		$postField = Field::getFieldList(['is_post'=>1,'menu_id'=>$data['menu_id']]);
		if($actions){
			try{	
				foreach($actions as $key=>$val){
					$actionInfo = explode('|',$val);
					$dt['menu_id'] = $data['menu_id'];
					$dt['name'] = $actionInfo[0];
					$dt['action_name'] = $actionInfo[1];
					$dt['type'] = $actionInfo[2];
					$dt['bs_icon'] = $actionInfo[3];
					$dt['is_view'] = 1;
					$dt['block_name'] = $actionInfo[0];
					
					if(in_array($actionInfo[2],[4,5])){
						$dt['button_status'] = 1;
					}else{
						$dt['button_status'] = 0;
					}
					
					if(in_array($actionInfo[2],[3,4,15])){
						$dt['fields'] = implode(',',$postField);
						$len = count($postField);
						if($len <= 3){
							$width = 600;
							$height = $len*50+300;
							$size = $width.'px|'.$height."px";
						}else if($len>3 && $len<=8){
							$width = 800;
							$height = $len*50+200;
							$size = $width.'px|'.$height."px";
						}else if($len>8){
							$width = '800';
							$size = $width.'px|100%';
						}
						$dt['remark'] = $size;
					}else{
						$dt['remark'] = '';
					}
					
					switch($actionInfo[2]){
						case 3:
							$label_color = 'primary';
						break;
						case 4:
							$label_color = 'success';
						break;
						case 5:
							$label_color = 'danger';
						break;
						case 15:
							$label_color = 'info';
						break;
						case 12:
							$label_color = 'warning';
						break;
						case 13:
							$label_color = 'warning';
						break;
					}
					$dt['lable_color'] = $label_color;
					$info = Action::getWhereInfo(['menu_id'=>$data['menu_id'],'action_name'=>$actionInfo[1]]);
					if(!$info){
						self::saveData('add',$dt);
					}else{
						throw new \Exception('方法已经存在');
					}
				}
			}catch(\Exception $e){
				throw new \Exception($e->getMessage());
			}
			return true;
		}
	}
	
	/**
     * 移动排序
	 * @param (输入参数：)  {string}        id 当前ID
     * @param (输入参数：)  {string}        type 类型 1上移 2 下移
     * @return (返回参数：) {bool}        
     * @return bool 信息
     */
	public static function arrowsort($id,$type){
		$data = Action::getInfo($id);

		if($type == 1){
			$map = 'sortid < '.$data['sortid'].' and menu_id = '.$data['menu_id'];
			$info = Action::getWhereInfo($map,$order='sortid desc');
		}else{
			$map = 'sortid > '.$data['sortid'].' and menu_id = '.$data['menu_id'];
			$info = Action::getWhereInfo($map,$order='sortid asc');
		}
		try{
			if($info && $data){
				Action::edit(['id'=>$id,'sortid'=>$info['sortid']]);
				Action::edit(['id'=>$info['id'],'sortid'=>$data['sortid']]);
			}else{
				throw new \Exception('目标位置没有数据');
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return true;	
	}
	
	/**
     * 删除信息
     * @return bool 信息
     */
	public static function delete($id){
		try{	
			$reset = Action::delete(['id'=>$id]);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
    
}
