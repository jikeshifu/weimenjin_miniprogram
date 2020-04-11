<?php 
/**
 *栏目管理
*/

namespace cms\service;

use cms\db\Catagory;
use xhadmin\CommonService;

class CatagoryService extends CommonService {


	/*
 	* @Description  栏目管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Catagory::loadList($where,$limit,$field,$orderby);
			$count = Catagory::countList($where);
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
			//数据验证
			$rule = [
				'class_name'=>['require'],
			];
			//数据错误提示
			$msg = [
				'class_name.require'=>'栏目名称不能为空',
			];
			self::validate($rule,$data,$msg);
			
			$filepath = self::getFilepath($data['class_name'],$data['class_id']);
			
			if(empty($data['filepath'])){
				$filepath = rtrim(config('xhadmin.filepath'),'/').'/'.$filepath;
			}else{
				$filepath = $data['filepath'].'/'.$filepath;
			}
			
			$data['filepath'] = $filepath;
			$res = Catagory::createData($data);
			if($res){
				Catagory::edit(['class_id'=>$res,'sortid'=>$res]);
			}
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
			//数据验证
			$rule = [
				'class_name'=>['require'],
			];
			$msg = [
				'class_name.require'=>'栏目名称不能为空',
			];
			self::validate($rule,$data,$msg);
			
			if(empty($data['filepath']) || empty($data['filename'])){
				$data['filename'] = 'index.html';
				$data['filepath'] = rtrim(config('xhadmin.filepath'),'/').'/'.self::getFilepath($data['class_name'],$data['class_id']);
			}
			
			$res = Catagory::edit($data);
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
			$res = Catagory::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}
	
	//排序上下移动
	public static function setSort($class_id,$type){
		$data = Catagory::getInfo($class_id);

		if($type == 1){
			$map['sortid']  = array('<',$data['sortid']);
			$map['pid'] = $data['pid'];
			$info = Catagory::getWhereInfo(formatWhere($map),'*',$orderby='sortid desc');
		}else{
			$map['sortid']  = array('>',$data['sortid']);
			$map['pid'] = $data['pid'];
			$info = Catagory::getWhereInfo(formatWhere($map),'*',$orderby='sortid asc');
		}
		
		if($info){
		   try{
				$r1 = Catagory::edit(['class_id'=>$class_id,'sortid'=>$info['sortid']]);
				$r2 = Catagory::edit(['class_id'=>$info['class_id'],'sortid'=>$data['sortid']]);
		   }catch(\Exception $e){
				throw new \Exception($e->getMessage());
			}
		   return true;
		}
	}
	
	/**
     * 获取当前模板文件
     * @return array 文件列表
     */
    public static function tplList($default_themes='')
    {
        $tplDir=app()->getRootPath().'/app/ApplicationName/view/'.$default_themes;
        if(!is_dir($tplDir)){
            return false;
        }
        $listFile=scandir($tplDir);
        if(is_array($listFile)){
            $list=array();
            foreach ($listFile as $key => $value) {
                if ($value != "." && $value != "..") {
                    $list[$key]['file']=$value;
                    $list[$key]['name']=substr($value, 0, -5);
                }
            }
        }
        return $list;
    }
	
	 /**
     * 栏目拼音转换
     * @return string 栏目拼音
     */
    public static function getFilepath($classname,$classId)
    {
		$classname = preg_replace('/\s+/', '-', $classname);
		$pattern = '/[^\x{4e00}-\x{9fa5}\d\w\-]+/u';
		$classname = preg_replace($pattern, '', $classname);
		$filepath = substr(\org\Pinyin::output($classname, true),0,30);
		$filepath = trim($filepath,'-');
        
        //返回数据
        $where = [];
        if (!empty($classId))
        {
            $where['class_id'] = ['<>',$classId];
        }
        $where['filepath'] = $filepath;
        $info = Catagory::getWhereInfo(formatWhere($where),'*','class_id desc'); 
        if(empty($info))
        {
            return $filepath;
        }else{
            return $filepath.rand(1,9);
        }
    }


}

