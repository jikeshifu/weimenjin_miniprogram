<?php

namespace app\admin\db;
use think\facade\Db; 


class Field
{
	
	protected static $tableName = 'Field';   //数据表名
	protected static $pk = "id";       //主键
	
	
	/**
     * 获取列表
     * @return array 列表
     */
    public static function loadList($where=[],$limit=100,$field='*',$orderby=''){	
		try{
			empty($orderby) && $orderby = 'sortid asc,id asc';
			list($start,$end) = explode(',',$limit);
			$result =  Db::name(self::$tableName)->where($where)->field($field)->limit($start,$end)->order($orderby)->select()->toArray();
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
    /**
     * 获取统计
     * @return int 数量
     */
    public static function countList($where){
	
		try{
			$result = Db::name(self::$tableName)->where($where)->count();
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }

    /**
     * 获取信息
     * @param int 
     * @return array 信息
     */
    public static function getInfo($pk)
    {
        $map = array();
        $map[self::$pk] = $pk;
        return self::getWhereInfo($map,self::$pk.' desc');
    }

    /**
     * 获取信息
     * @param array $where 条件
     * @return array 信息
     */
    public static function getWhereInfo($where,$orderby='')
    {		
		try{
			$result = Db::name(self::$tableName)->where($where)->order($orderby)->find();
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
	
	/**
     * 删除信息
     * @return bool 信息
     */
    public static function delete($where)
    {	
		try{
			$result = Db::name(self::$tableName)->where($where)->delete();
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }

	/**
     * 按条件修改
     * @param array $where 条件
     * @return bool 信息
     */
    public static function editWhere($where,$data)
    {   	
		try{
			$result = Db::name(self::$tableName)->where($where)->update($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
	
	/**
     * 按主键修改
     * @return bool 信息
     */
	public static function edit($data)
    {   	
		try{
			$result = Db::name(self::$tableName)->update($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
	/**
     * 创建信息
     * @return array 信息
     */
    public static function createData($data)
    {	
		try{
			$result = Db::name(self::$tableName)->insertGetId($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
	/**
     * 查询某一列的值
     * @return array 信息
     */
    public static function getFieldList($where)
    {	
		try{
			$result = Db::name(self::$tableName)->where($where)->column('field');;
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return $result;
    }
	
	
    
}
