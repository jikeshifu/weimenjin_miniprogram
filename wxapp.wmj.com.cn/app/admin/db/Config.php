<?php

namespace app\admin\db;
use \think\facade\Db; 


class Config
{
	
	protected static $tableName = 'config';  
	
    /**
     * 获取信息
     * @param int 
     * @return array 信息
     */
    public static function loadList()
    {
        $list = Db::name(self::$tableName)->select()->toArray();
		
		foreach ($list as $key => $value) {
            $config[$value['name']] = $value['data'];
        }
        return $config;
        
    }
	
	
	/**
     * 数据修改
     * @param array $where 条件
     * @return array 信息
     */
	public static function edit($where,$data)
    {   	
		try{
			$result = Db::name(self::$tableName)->where($where)->update($data);
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
    
}
