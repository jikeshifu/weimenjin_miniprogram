<?php 
/*
 module:		门锁列表
 create_time:	2020-04-10 00:37:50
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Lock;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LockService extends CommonService {


	/*
 	* @Description  门锁管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Lock::loadList($where,$limit,$field,$orderby);
			$count = Lock::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return ['list'=>$list,'count'=>$count];
	}


	/*
 	* @Description  添加
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{
			$data['user_id'] = session('admin.user_id');
			$data['create_time'] = time();

			//数据验证
			$rule = [
				'lock_name'=>['require'],
				'lock_sn'=>['require','unique:lock'],
				'location'=>['require'],
			];
			//数据错误提示
			$msg = [
				'lock_name.require'=>'锁名称不能为空',
				'lock_sn.require'=>'序列号不能为空',
				'lock_sn.unique'=>'序列号已经存在',
				'location.require'=>'位置不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Lock::createData($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($data){
		try{
			$data['create_time'] = strtotime($data['create_time']);

			//数据验证
			$rule = [
				'lock_name'=>['require'],
				'lock_sn'=>['require','unique:lock'],
				'location'=>['require'],
			];
			$msg = [
				'lock_name.require'=>'锁名称不能为空',
				'lock_sn.require'=>'序列号不能为空',
				'lock_sn.unique'=>'序列号已经存在',
				'location.require'=>'位置不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Lock::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  删除
 	* @param (输入参数：)  {array}        where 删除条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function delete($where){
		try{
			$res = Lock::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  导出
 	* @param (输入参数：)  {array}        where 查询条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function dumpData($where,$orderby,$field){
		try{
			$list = Lock::loadList($where,$limit=50000,'*',$orderby);
			$list = htmlOutList($list);
			if(!$list) throw new \Exception('没有数据');

			$map['menu_id'] = 803;
			$map['field'] = $field;
			$fieldList = db("field")->where($map)->order('id asc')->select()->toArray();

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			//excel表头
			foreach($fieldList as $key=>$val){
				$sheet->setCellValue(getTag($key+1).'1',$val['name']);
			}
			//excel表主体内容
			foreach($list as $k=>$v){
				foreach($fieldList as $m=>$n){
					if(in_array($n['type'],[7,12,25]) && $v[$n['field']]){
						$v[$n['field']] = date(getTimeFormat($n),$v[$n['field']]);
					}
					if(in_array($n['type'],[2,3,4,23,27,29]) && !empty($n['config'])){
						$v[$n['field']] = getFieldVal($v[$n['field']],$n['config']);
					}
					if($n['type'] == 17){
						foreach(explode('|',$n['field']) as $q){
							$v[$n['field']] .= $v[$q].'-';
						}
						$v[$n['field']] = rtrim($v[$n['field']],'-');
					}
					$sheet->setCellValueExplicit(getTag($m+1).($k+2),$v[$n['field']],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$v[$n['field']] = '';
				}
			}
			
			$filename = date('YmdHis');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename.'.'.config('my.import_type')); 
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet); 
			$writer->save('php://output');
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}
	/*
 	* @Description  编辑数据
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function opendoor($data){
		try{

			$res = Lock::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


 /*start*/
    /*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function updatewhere($where,$data){
		try{
			//$data['create_time'] = strtotime($data['create_time']);
			$res = Lock::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}
    /*end*/



}

