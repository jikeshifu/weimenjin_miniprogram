<?php

namespace cms\db;
use think\facade\Db;
use xhadmin\db\Common; 


class Content extends Common
{
	
	protected static $tableName = 'content';   //数据表名
	protected static $pk = 'content_id';   //主键
	protected static $errMsg = '操作失败';   //错误信息
	
	
	/**
     * 获取列表
     * @return array 列表
     */
    public static function loadList($where=[],$limit=100,$field='*',$orderby=''){	
		try{
			empty($orderby) && $orderby = self::$pk.' desc';
			list($start,$end) = explode(',',$limit);
			$result =  Db::name(self::$tableName)->where($where)->field($field)->limit($start,$end)->order($orderby)->select()->toArray();
		}catch(\Exception $e){
			self::setLog($e->getMessage());
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
			self::setLog($e->getMessage());
		}
		
		return $result;
    }

    /**
     * 获取信息
     * @param int 
     * @return array 信息
     */
    public static function getInfo($pk,$field="*")
    {
        $map[self::$pk] = $pk;
        return self::getWhereInfo($map,$field,self::$pk.' desc');
    }

    /**
     * 获取信息
     * @param array $where 条件
     * @return array 信息
     */
    public static function getWhereInfo($where,$field='',$orderby='')
    {		
		try{
			empty($orderby) && $orderby = self::$pk.' desc';
			empty($field) && $field = '*';
			$result = Db::name(self::$tableName)->field($field)->where($where)->order($orderby)->find();
		}catch(\Exception $e){
			self::setLog($e->getMessage());
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
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
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
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
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
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
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
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
		}
		
		return $result;
    }
	
	/**
     * 原生sql语句查询
     * @return array 信息
     */
    public static function query($sql)
    {	
		try{
			$result = Db::query($sql);
		}catch(\Exception $e){
			self::setLog($e->getMessage());
		}
		
		return $result;
    }
	
	/**
     * 关联查询 只支持2张表查询
	 * @param string    $field 查询字段
	 * @param string    $thisField 当前表关联字段
	 * @param string    $relate_table 关联表
	 * @param string    $relate_field 关联表关联字段
	 * @param array     $where 条件
	 * @param string    $limit 分页
	 * @param string    $orderby 排序
     * @return array 信息
     */
    public static function relateQuery($field,$thisField,$relate_table,$relate_field,$where,$limit,$orderby='')
    {	
		try{
			empty($orderby) && $orderby = self::$pk.' desc';
			list($start,$end) = explode(',',$limit);
			$result = Db::name(self::$tableName)->field($field)->alias('a')->join($relate_table.' b','a.'.$thisField.'=b.'.$relate_field,"LEFT")->where($where)->limit($start,$end)->order($orderby)->select()->toArray();
		}catch(\Exception $e){
			self::setLog($e->getMessage());
		}
		
		return $result;
    }
	
	/**
     * 关联查询统计数量
	 * @param string    $field 查询字段
	 * @param string    $thisField 当前表关联字段
	 * @param string    $relate_table 关联表
	 * @param string    $relate_field 关联表关联字段
	 * @param array     $where 条件
     * @return array 信息
     */
    public static function relateQueryCount($field,$thisField,$relate_table,$relate_field,$where)
    {	
		try{
			$count = Db::name(self::$tableName)->field($field)->alias('a')->join($relate_table.' b','a.'.$thisField.'=b.'.$relate_field,"LEFT")->where($where)->count();	
		}catch(\Exception $e){
			self::setLog($e->getMessage());
		}
		return $count;
    }
	
	/**
     * 数值加
     * @param array $where 条件
	 * @param string $field 操作的字段
	 * @param int $data 变动的值
     * @return bool
     */
	public static function setInc($where,$field,$data)
    {   	
		try{
			$result = Db::name(self::$tableName)->where($where)->inc($field,$data)->update();	
		}catch(\Exception $e){
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
		}
		return $result;
    }
	
	
	/**
     * 数值减
     * @param array $where 条件
	 * @param string $field 操作的字段
	 * @param int $data 变动的值
     * @return bool
     */
	public static function setDec($where,$field,$data)
    {   
		$info = self::getWhereInfo($where,$field);
		if($info[$field] < $data){
			throw new \Exception('数据不足');
		}
		try{
			$result = Db::name(self::$tableName)->where($where)->dec($field,$data)->update();	
		}catch(\Exception $e){
			self::setLog($e->getMessage());
			throw new \Exception(self::$errMsg);
		}
		return $result;
    }
    
	
	
    
}
