<?php

namespace xhadmin;
use think\facade\Validate;
use think\facade\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\module\redis\Redis;
class CommonService
{

	 /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @return array|string|true
     */
	public static function validate($rule,$data,$msg=[]){
		$validate = Validate::rule($rule)->message($msg);
		if (!$validate->check($data)) {
			throw new \think\exception\ValidateException($validate->getError());
		}
		return true;
	}

    function loadList1($sql, $where = [], $limit = '', $orderby = '', $countetable = 'cd_locklog') {
        // 将SQL转换为小写
        $sql = strtolower($sql);
        $map = '';

        // 生成WHERE条件
        foreach ($where as $key => $val) {
            if (is_array($val)) {
                switch ($val[1]) {
                    case 'between':
                        if (!empty($val[2][0]) || !empty($val[2][1])) {
                            $map .= $val[0] . ' between ' . (empty($val[2][0]) ? '0' : $val[2][0]) . ' and ' . (empty($val[2][1]) ? '9999999999' : $val[2][1]) . ' and ';
                        }
                        break;
                    case 'exp':
                        $map .= $val[0] . ' ' . $val[2] . ' and ';
                        break;
                    case 'in':
                        $map .= $val[0] . ' in (' . implode(',', $val[2]) . ') and ';
                        break;
                    case 'find in set':
                        $map .= ' find_in_set(\'' . $val[2] . '\',' . $val[0] . ') and ';
                        break;
                    default:
                        $map .= $val[0] . ' ' . $val[1] . " '" . $val[2] . "' and ";
                        break;
                }
            }
        }

        // 删除最后的 ' and ' 并附加 1=1 作为结束条件，但仅在没有其他条件时附加
        if (!empty($map)) {
            $map = rtrim($map, ' and ');
        } else {
            $map = '1=1';  // 仅当没有其他条件时附加 1=1
        }

        // 处理SQL中是否已有WHERE子句
        $is_where = strripos($sql, "where");
        if ($is_where === false) {
            $sql .= ' where ' . $map;
        } else {
            $sql = substr($sql, 0, $is_where + 5) . $map;
        }

        // 添加 ORDER BY 和 LIMIT 子句
        if (!empty($orderby) && strripos($sql, "order by") === false) {
            $sql .= ' order by ' . $orderby;
        }

        if (!empty($limit) && strripos($sql, "limit") === false) {
            $sql .= ' limit ' . $limit;
        }

        // 构造统计总数的 SQL 语句
        $countSql = preg_replace('/^select\s+.*?\s+from\s+/i', 'select count(*) as count from ', $sql);

        // 移除统计查询中的 ORDER BY 和 LIMIT 子句
        $countSql = preg_replace('/\border\s+by\b.*?(?=\blimit\b|\Z)/i', '', $countSql); // 移除 ORDER BY
        $countSql = preg_replace('/\blimit\b\s+\d+\s*(,\s*\d+)?/i', '', $countSql); // 移除 LIMIT

        // 缓存键生成，基于查询条件和 SQL 生成唯一 Redis 键
        $cacheKey = "count_sql:" . md5($countSql);

        // 使用 Redis 获取统计结果
        $count = Redis::Redis()->get($cacheKey);
        if (!$count) {
            // 如果没有缓存，则进行统计查询
            try {
                log::error('统计SQL：' . print_r($countSql, true));
                $count = db()->query($countSql)[0]['count'];
                // 将统计结果缓存到 Redis，有效期为 360 秒（6 分钟）
                Redis::Redis()->set($cacheKey, $count, 3600);
            } catch (\Exception $e) {
                log::error('SQL 错误：' . print_r($e->getMessage(), true));
                log::error('出错统计SQL：' . print_r($countSql, true));
                return ['list' => [], 'count' => 0, 'sql' => $sql];
            }
        }

        // 记录 SQL 日志
        log::error('查询SQL：' . print_r($sql, true));

        // 执行数据查询
        try {
            $result = db()->query($sql);
        } catch (\Exception $e) {
            log::error('SQL 错误：' . print_r($e->getMessage(), true));
            return ['list' => [], 'count' => 0, 'sql' => $sql];
        }

        return ['list' => $result, 'count' => $count, 'sql' => $sql];
    }
    /**
	 * 生成sql查询语句
	 * @access protected
	 * @param  sql     原始sql语句
	 * @param  $where  查询条件
	 * @param  $limit  分页
	 * @param  $orderby  排序
	 * @return array
	 */
	function loadList($sql,$where=[],$limit,$orderby,$countetable='cd_locklog'){
		$sql = strtolower($sql);
		$map = '';
		foreach($where as $key=>$val){
			if(is_array($val)){
				switch($val[1]){
					case 'between':
						if(empty($val[2][0]) && !empty($val[2][1])){
							$map .= $val[0].' < '.$val[2][1].' and ';
						}
						if(!empty($val[2][0]) && empty($val[2][1])){
							$map .= $val[0].' > '.$val[2][1].' and ';
						}
						if(!empty($val[2][0]) && !empty($val[2][1])){
							$map .= $val[0].' between '.$val[2][0].' and '.$val[2][1].' and ';
						}
					break;

					case 'exp':
						$map .= $val[0].' '.$val[2].' and ';
					break;

					case 'in':
						$map .= $val[0].' in ('.$val[2].') and ';
					break;

					case 'find in set':
						$map .= ' find_in_set(\''.$val[2].'\','.$val[0].') and ';
					break;

					default:
						$map .= $val[0].' '.$val[1]." '".$val[2]."'".' and ';
					break;
				}
			}
		}
		$map .= '1=1';
		$is_where = strripos($sql,"where");
		if($is_where === false){
			$where = !empty($where) ?  ' where '.$map : '';
			$sql = $sql.$where;
		}else{
			$l_sql = substr($sql, 0, $is_where);
			$r_sql = substr($sql, $is_where+5, strlen($sql)- $is_where - 5);
			$where = !empty($where) ?  ' where '.$map.' and ' : ' where ';
			$sql = $l_sql . $where . $r_sql;
		}

		$limit = ' limit '.$limit;
		$searchString = "a.*,b.headimgurl,b.realname,b.remark,b.nickname,b.mobile,c.lock_name";
		$replaceString = "a.locklog_id";
		// 首先检查是否存在要替换的字符串
		$countsql=$sql;
		if (strpos($countsql, $searchString) !== false) {
		    // 如果存在，则进行替换
		    $countsql = str_replace($searchString, $replaceString, $countsql);
		}
	    $countWhere = 'select count(*) as count from ('.$countsql.') as tp';
		// $countWhere = 'select count(*) as count from '.$countetable. ' as tp ';
		if (strripos($sql,"order by")=== false && $orderby) {
			$sql .= ' order by '.$orderby;
		}

		if (strripos($sql,"limit")=== false) {
			$sql .= $limit;
		}

		try{
			log::error('sql语句：'.print_r($sql,true));
			log::error('countWhere语句：'.print_r($countWhere,true));
			$result = db()->query($sql);
			$count = db()->query($countWhere);
		}catch(\Exception $e){
			log::error('sql错误：'.print_r($e->getMessage(),true));
			log::error('错误sql语句：'.print_r($sql,true));
			log::error('错误countWhere语句：'.print_r($countWhere,true));
		}

		return ['list'=>$result,'count'=>$count[0]['count'],"sql"=>$sql];
	}
	/*start*/
			/**
	 * 生成sql查询语句
	 * @access protected
	 * @param  sql     原始sql语句
	 * @param  $where  查询条件
	 * @param  $limit  分页
	 * @param  $orderby  排序
	 * @return array
	 */
	function loadgroupbyList($sql,$where=[],$limit,$orderby,$groupby){
		$sql = strtolower($sql);
		$map = '';
		foreach($where as $key=>$val){
			if(is_array($val)){
				switch($val[1]){
					case 'between':
						if(empty($val[2][0]) && !empty($val[2][1])){
							$map .= $val[0].' < '.$val[2][1].' and ';
						}
						if(!empty($val[2][0]) && empty($val[2][1])){
							$map .= $val[0].' > '.$val[2][1].' and ';
						}
						if(!empty($val[2][0]) && !empty($val[2][1])){
							$map .= $val[0].' between '.$val[2][0].' and '.$val[2][1].' and ';
						}
					break;

					case 'exp':
						$map .= $val[0].' '.$val[2].' and ';
					break;

					case 'in':
						$map .= $val[0].' in ('.$val[2].') and ';
					break;

					case 'find in set':
						$map .= ' find_in_set(\''.$val[2].'\','.$val[0].') and ';
					break;

					default:
						$map .= $val[0].' '.$val[1]." '".$val[2]."'".' and ';
					break;
				}
			}
		}
		$map .= '1=1';

		$is_where = strripos($sql,"where");
		if($is_where === false){
			$where = !empty($where) ?  ' where '.$map : '';
			$sql = $sql.$where;
		}else{
			$l_sql = substr($sql, 0, $is_where);
			$r_sql = substr($sql, $is_where+5, strlen($sql)- $is_where - 5);
			$where = !empty($where) ?  ' where '.$map.' and ' : ' where ';
			$sql = $l_sql . $where . $r_sql;
		}

		$limit = ' limit '.$limit;

		$countWhere = 'select count(*) as count from ('.$sql.') as tp';
		if (strripos($sql,"group by")=== false && $groupby) {
			$sql .= ' group by '.$groupby;
		}
		if (strripos($sql,"order by")=== false && $orderby) {
			$sql .= ' order by '.$orderby;
		}

		if (strripos($sql,"limit")=== false) {
			$sql .= $limit;
		}

		try{
			$result = db()->query($sql);
			$count = db()->query($countWhere);
		}catch(\Exception $e){
			log::error('sql错误：'.print_r($e->getMessage(),true));
			log::error('错误语句：'.print_r($sql,true));
		}

		return ['list'=>$result,'count'=>$count[0]['count']];
	}
	/*end*/
	//导入excel数据
	public static function importData($key){
		$file = explode('.', $_FILES['file_name']['name']);
		if (!in_array(end($file), array('xls','xlsx','csv'))) {
			throw new \Exception('请选择xls文件！');
			exit;
		}
		$path = $_FILES['file_name']['tmp_name'];
		if (empty($path)) {
			throw new \Exception('请选择要上传的文件！');
			exit;
		}

		set_time_limit(0);

		$spreadsheet = IOFactory::load($path);
		$worksheet = $spreadsheet->getActiveSheet();

		$sheet = $spreadsheet->getActiveSheet();
		$res = [];

		foreach ($sheet->getRowIterator(1) as $row) {
			$tmp = [];
			foreach ($row->getCellIterator() as $cell) {
				$tmp[] = $cell->getFormattedValue();
			}

			if(filterEmptyArray($tmp)){
				$res[$row->getRowIndex()] = $tmp;
			}
		}
		return $res;
	}



}
