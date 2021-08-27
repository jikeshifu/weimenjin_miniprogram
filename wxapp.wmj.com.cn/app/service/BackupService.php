<?php

namespace app\admin\service;
use app\admin\service\FieldSetService;
use think\facade\Env;

class BackupService
{
	
	public static $backupDir = './backup';
    public static $tableList = []; //表列表
	
	public static function check() {
        if(config('database.connections.mysql.type') <> 'mysql'){
            throw new \Exception('抱歉，数据库驱动非mysql时无法使用备份功能！');
        }
        $list = self::tableList();
        if(empty($list)){
            throw new \Exception('没有发现表');
        }
        self::$tableList = $list;
        return true;
    }
	
	//加载默认数据
    public static function loadList(){
	
		try{
			$fileDir = realpath(self::$backupDir) . DIRECTORY_SEPARATOR;
			if(!is_dir($fileDir)){
				return false;
			}
			$listFile = glob($fileDir . '*.sql.*');
			
			if(is_array($listFile)){
				$list=array();
				foreach ($listFile as $key => $value) {
                    $list[$key]['time'] =  filemtime($value);   //添加一行
					$value = explode(DIRECTORY_SEPARATOR, $value);
					$value = end($value);
					$list[$key]['name'] = $value;                                              
				}
			}
			$last_names = array_column($list,'time');
			array_multisort($last_names,SORT_DESC,$list);
			
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return ['list'=>$list,'count'=>count($listFile)];	
	}

	
	/**
     * 备份数据库
     */
    public function backupData($tablename){
        if(!self::check()){
            return false;
        }
		if(empty($tablename)){
			$list = self::$tableList;
		}else{
			$tablename = explode(',',$tablename);
			foreach($tablename as $key=>$val){
				$list[$key]['Name'] = $val;
			}
		}
        
        //生成备份文件信息
        $file = array(
            'name' => time(),
            'part' => 1,
        );
        //设置备份配置
        $config = array(
            'path'     => realpath(self::$backupDir) . DIRECTORY_SEPARATOR,
            'part'     => 20971520,
            'compress' => 1,
            'level'    => 9,
        );
        //检查是否有正在执行的任务
        //$lock = "{$config['path']}backup.lock";
        if(is_file($lock)){
            throw new \Exception('检测到有一个备份任务正在执行，请稍后再试！');
        } else {
            //创建锁文件
            file_put_contents($lock, time());
        }
		
		if(!is_dir(self::$backupDir)){
			mkdir(self::$backupDir,777);
		}
		
        //检查备份目录是否可写
        if(!is_writeable($config['path'])){
            throw new \Exception('备份目录不存在或不可写，请检查后重试！');
        }
        //创建备份文件
        $Database = new \org\Database($file, $config);
        if(!$Database->create()){
            throw new \Exception('初始化失败，备份文件创建失败！');
        }
        $start = 0;
        foreach ($list as $value) {
            $start = $Database->backup($value['Name'], $start);
            if($start === false){
                //删除文件锁
                unlink($lock);
                throw new \Exception('备份文件创建失败，请稍后再试！'); 
            }
        }
        //删除文件锁
        unlink($lock);
        return true;
    }
	
	public static function tableList(){
		$list = db()->query('SHOW TABLE STATUS');
		return $list;
	}
	
	/*
	*删除数据文件
	*/
	public function delete($fileName){
		try{
			$array = explode(',',$fileName);
			foreach($array as $key=>$val){
				$fileName = self::$backupDir.'/'.$val.'.sql.gz'; 
				@unlink($fileName);
			}	
			
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return true;
	}

	
	
	
}
