<?php
/*
 module:		开门记录
 create_time:	2022-03-10 17:43:11
 author:
 contact:
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockLogService;
use xhadmin\db\LockLog as LockLogDb;

class LockLog extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['updateExt','delete','view'])){
			$id = $this->request->param('locklog_id','','intval');
			$ids = $this->request->param('locklog_ids','','intval');
			if($id){
				$info = LockLogDb::getInfo($id);
				if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
			}
			if($ids){
				foreach(explode(',',$ids) as $v){
					$info = LockLogDb::getInfo($v);
					if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
				}
			}
		}
	}
	/*删除*/
	function delete(){
		$idx =  $this->request->post('locklog_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LockLogService::delete(['locklog_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$locklog_id = $this->request->get('locklog_id','','intval');
		if(!$locklog_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockLogDb::getInfo($locklog_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*导出*/
	function dumpData(){
		$where = [];
		if(session('admin.role') <> 1){
			$where['a.user_id'] = session('admin.user_id');
		}
		$locklog_id = $this->request->param('locklog_id', '', 'serach_in');
			$orderby = 'locklog_id desc ';
			$limit = 0; // 0 代表不限制条数，导出全部数据（需确保 loadList 支持 0 为不限制）
			$list = [];

			if (empty($locklog_id)){
				$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
				$create_time_end = $this->request->param('create_time_end', '', 'serach_in');
				$start_ts = strtotime($create_time_start);
				$end_ts = strtotime($create_time_end);
				// 调试日志
				if ($create_time_start && $create_time_end && $start_ts && $end_ts) {
					$where['a.create_time'] = ['between', [$start_ts, $end_ts]];
				}
				// 其它筛选参数为空时不参与 where 条件
				$lock_name = $this->request->param('lock_name', '', 'serach_in');
				if ($lock_name !== '') {
					$where['c.lock_name'] = ['like', $lock_name];
				}
				$realname = $this->request->param('realname', '', 'serach_in');
				if ($realname !== '') {
					$where['b.realname'] = $realname;
				}
				$mobile = $this->request->param('mobile', '', 'serach_in');
				if ($mobile !== '') {
					$where['b.mobile'] = ['like', $mobile];
				}
				$remark = $this->request->param('remark', '', 'serach_in');
				if ($remark !== '') {
					$where['b.remark'] = ['like', $remark];
				}

				try{
						$sql = 'select a.locklog_id,a.member_id,a.lock_id,a.status,a.type,a.create_time,a.user_id,a.lremark,a.cardsn,a.user_name,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile,c.lock_name from cd_locklog as a FORCE INDEX(idx_locklog_id) left join cd_member as b on a.member_id=b.member_id left join cd_lock as c on a.lock_id=c.lock_id';
						$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby,'cd_locklog');
						$list = $res['list'];
				}catch(\Exception $e){
						exit($e->getMessage());
				}
		}else{
				$where['a.lock_name'] = ['like',''];
				$where['a.realname'] = '';
				$where['a.mobile'] = ['like',''];
				$where['a.locklog_id'] = ['in',$this->request->param('locklog_id', '', 'serach_in')];

					try{
							$sql = 'select a.*,b.realname,b.remark,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a left join cd_member as b on a.member_id=b.member_id left join cd_lock as c on a.lock_id=c.lock_id';
							$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby,'cd_locklog');
							$list = $res['list'];
					}catch(\Exception $e){
							exit($e->getMessage());
					}

		}

		try {
				$filename = date('YmdHis');
				LockLogService::dumpData($list,$filename);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

    /**
     * 分批导出并打包为zip下载，带进度文件
     */
    public function dumpDataZip()
    {
        try {
            $user_id = session('admin.user_id');
            $role = session('admin.role');
            if (!session('admin.user_id')) {
                return json(['status' => 'not_login', 'msg' => '请重新登录']);
            }
            session_write_close();
            $where = [];
            if(session('admin.role') <> 1){
                $where['a.user_id'] = session('admin.user_id');
            }
            $locklog_id = $this->request->param('locklog_id', '', 'serach_in');
            $orderby = 'locklog_id desc ';
            $batchSize = 50000;
            $list = [];
            $files = [];
            $filenamePrefix = '开门记录_' . date('YmdHis');
            $total = 0;
            $progressFile = runtime_path() . 'export_progress_' . session('admin.user_id') . '.json';
            if (empty($locklog_id)) {
                $create_time_start = $this->request->param('create_time_start', '', 'serach_in');
                $create_time_end = $this->request->param('create_time_end', '', 'serach_in');
                $start_ts = strtotime($create_time_start);
                $end_ts = strtotime($create_time_end);
                if ($create_time_start && $create_time_end && $start_ts && $end_ts) {
                    $where['a.create_time'] = ['between', [$start_ts, $end_ts]];
                }
                $lock_name = $this->request->param('lock_name', '', 'serach_in');
                if ($lock_name !== '') {
                    $where['c.lock_name'] = ['like', $lock_name];
                }
                $realname = $this->request->param('realname', '', 'serach_in');
                if ($realname !== '') {
                    $where['b.realname'] = $realname;
                }
                $mobile = $this->request->param('mobile', '', 'serach_in');
                if ($mobile !== '') {
                    $where['b.mobile'] = ['like', $mobile];
                }
                $remark = $this->request->param('remark', '', 'serach_in');
                if ($remark !== '') {
                    $where['b.remark'] = ['like', $remark];
                }
                // 调试：select 查询一条数据
                $debugRow = \think\facade\Db::name('locklog')->alias('a')
                    ->leftJoin('cd_member b', 'a.member_id=b.member_id')
                    ->leftJoin('cd_lock c', 'a.lock_id=c.lock_id')
                    ->where($where)
                    ->order('locklog_id desc')
                    ->limit(1)
                    ->select();
                $debugSql = \think\facade\Db::getLastSql();
                // 用原生SQL统计总数
                $whereArr = [];
                if(session('admin.role') <> 1){
                    $whereArr[] = 'a.user_id = ' . intval(session('admin.user_id'));
                }
                if ($create_time_start && $create_time_end && $start_ts && $end_ts) {
                    $whereArr[] = "a.create_time BETWEEN $start_ts AND $end_ts";
                }
                if ($lock_name !== '') {
                    $whereArr[] = "c.lock_name LIKE '%$lock_name%'";
                }
                if ($realname !== '') {
                    $whereArr[] = "b.realname = '$realname'";
                }
                if ($mobile !== '') {
                    $whereArr[] = "b.mobile LIKE '%$mobile%'";
                }
                if ($remark !== '') {
                    $whereArr[] = "b.remark LIKE '%$remark%'";
                }
                $whereStr = $whereArr ? 'WHERE ' . implode(' AND ', $whereArr) : '';
                $countSql = "SELECT COUNT(*) as total FROM cd_locklog a LEFT JOIN cd_member b ON a.member_id=b.member_id LEFT JOIN cd_lock c ON a.lock_id=c.lock_id $whereStr";
                $countRes = \think\facade\Db::query($countSql);
                $total = $countRes ? $countRes[0]['total'] : 0;
                $batches = ceil($total / $batchSize);
                $querySqls = [];
                for ($i = 0; $i < $batches; $i++) {
                    $offset = $i * $batchSize;
                    $sql = "SELECT a.locklog_id,a.member_id,a.lock_id,a.status,a.type,a.create_time,a.user_id,a.lremark,a.cardsn,a.user_name,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile,c.lock_name FROM cd_locklog a LEFT JOIN cd_member b ON a.member_id=b.member_id LEFT JOIN cd_lock c ON a.lock_id=c.lock_id $whereStr ORDER BY locklog_id desc LIMIT $offset,$batchSize";
                    $list = \think\facade\Db::query($sql);
                    $querySqls[] = $sql;
                    if ($list) {
                        $partFile = runtime_path() . $filenamePrefix . '_part' . ($i+1) . '.xlsx';
                        \xhadmin\service\admin\LockLogService::dumpDataToFile($list, $partFile);
                        $files[] = $partFile;
                    }
                    // 写入进度
                    file_put_contents($progressFile, json_encode([
                        'total' => $batches,
                        'current' => $i + 1,
                        'status' => 'processing',
                        'zip' => ''
                    ]));
                }
            } else {
                // 按ID导出
                $where['a.locklog_id'] = ['in', $locklog_id];
                $list = \think\facade\Db::name('locklog')->alias('a')
                    ->leftJoin('cd_member b', 'a.member_id=b.member_id')
                    ->leftJoin('cd_lock c', 'a.lock_id=c.lock_id')
                    ->where($where)
                    ->order('locklog_id desc')
                    ->select()
                    ->toArray();
                if ($list) {
                    $partFile = runtime_path() . $filenamePrefix . '_part1.xlsx';
                    \xhadmin\service\admin\LockLogService::dumpDataToFile($list, $partFile);
                    $files[] = $partFile;
                }
                // 写入进度
                file_put_contents($progressFile, json_encode([
                    'total' => 1,
                    'current' => 1,
                    'status' => 'processing',
                    'zip' => ''
                ]));
            }
            if (empty($files)) {
                // 写入无数据进度
                file_put_contents($progressFile, json_encode([
                    'total' => 0,
                    'current' => 0,
                    'status' => 'nodata',
                    'msg' => '没有数据',
                    'where' => $whereArr,
                    'count' => isset($total) ? $total : 0,
                    'count_sql' => isset($countSql) ? $countSql : '',
                    'query_sqls' => isset($querySqls) ? $querySqls : [],
                    'start_ts' => isset($start_ts) ? $start_ts : null,
                    'end_ts' => isset($end_ts) ? $end_ts : null
                ]));
                return json([
                    'status' => 'nodata',
                    'msg' => '没有数据',
                    'where' => $whereArr,
                    'count' => isset($total) ? $total : 0,
                    'count_sql' => isset($countSql) ? $countSql : '',
                    'query_sqls' => isset($querySqls) ? $querySqls : [],
                    'start_ts' => isset($start_ts) ? $start_ts : null,
                    'end_ts' => isset($end_ts) ? $end_ts : null
                ]);
            }
            // 打包zip
            $zipFile = runtime_path() . $filenamePrefix . '.zip';
            $zip = new \ZipArchive();
            $zip->open($zipFile, \ZipArchive::CREATE);
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            // 删除临时Excel
            foreach ($files as $file) @unlink($file);
            // 写入完成进度
            file_put_contents($progressFile, json_encode([
                'total' => max(1, count($files)),
                'current' => max(1, count($files)),
                'status' => 'finished',
                'zip' => basename($zipFile)
            ]));
            // 下载zip
            return download($zipFile)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return json([
                'status' => 'error',
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => isset($user_id) ? $user_id : null,
                'role' => isset($role) ? $role : null
            ]);
        }
    }

    /**
     * 查询导出进度
     */
    public function exportProgress() {
        if (!session('admin.user_id')) {
            return json(['status' => 'not_login', 'msg' => '请重新登录']);
        }
        $progressFile = runtime_path() . 'export_progress_' . session('admin.user_id') . '.json';
        if (is_file($progressFile)) {
            $data = json_decode(file_get_contents($progressFile), true);
            return json($data);
        } else {
            return json(['total' => 0, 'current' => 0, 'status' => 'none', 'zip' => '']);
        }
    }

    /**
     * @route POST /admin/LockLog/createExportTask
     * 创建异步导出任务
     */
    public function createExportTask()
    {
        $params = $this->request->param();
        $params['admin_id'] = session('admin.user_id');
        $params['role'] = session('admin.role');
        $task_id = \think\facade\Db::name('export_task')->insertGetId([
            'admin_id' => $params['admin_id'],
            'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return json(['status'=>'ok', 'task_id'=>$task_id]);
    }

    /**
     * @route GET /admin/LockLog/exportTaskStatus
     * 查询异步导出任务状态
     */
    public function exportTaskStatus()
    {
        $task_id = $this->request->param('task_id');
        $task = \think\facade\Db::name('export_task')->where('id', $task_id)->find();
        if (!$task) return json(['status'=>'error', 'msg'=>'任务不存在']);
        return json([
            'status' => $task['status'],
            'file_path' => $task['file_path'],
            'msg' => $task['msg']
        ]);
    }

    /**
     * @route GET /admin/LockLog/downloadExportFile
     * 下载异步导出文件
     */
    public function downloadExportFile()
    {
        $task_id = $this->request->param('task_id');
        $task = \think\facade\Db::name('export_task')->where('id', $task_id)->find();
        if ($task && $task['status'] == 'finished' && is_file($task['file_path'])) {
            return download($task['file_path'], basename($task['file_path']));
        }
        return '文件不存在或未完成';
    }

/*start*/
	/*日志管理*/
    function index(){
        if (!$this->request->isAjax()){
            return $this->display('index');
        } else {
            $limit  = $this->request->post('limit', 0, 'intval');
            $offset = $this->request->post('offset', 0, 'intval');
            $page   = floor($offset / $limit) +1 ;

            $where = [];
            if (session('admin.role') <> 1) {
                $where['a.user_id'] = session('admin.user_id');
            }
            $where['c.lock_name'] = ['like', $this->request->param('lock_name', '', 'serach_in')];
            $where['b.realname'] = $this->request->param('realname', '', 'serach_in');
            $where['b.mobile'] = ['like', $this->request->param('mobile', '', 'serach_in')];
            $where['b.remark'] = ['like', $this->request->param('remark', '', 'serach_in')];

            $create_time_start = $this->request->param('create_time_start', '', 'serach_in');
            $create_time_end = $this->request->param('create_time_end', '', 'serach_in');
            $start_ts = strtotime($create_time_start);
            $end_ts = strtotime($create_time_end);
            if ($create_time_start && $create_time_end && $start_ts && $end_ts) {
                $where['a.create_time'] = ['between', [$start_ts, $end_ts]];
            }

            $order  = $this->request->post('order', '', 'serach_in');
            $sort  = $this->request->post('sort', '', 'serach_in');

            $limit = ($page-1) * $limit.','.$limit;
            $orderby = ($sort && $order) ? $sort.' '.$order : 'locklog_id desc';

            try {
                $sql = 'SELECT a.*, b.headimgurl, b.realname, b.remark, b.nickname, b.mobile, b.member_type, c.lock_name
                    FROM cd_locklog AS a
                    LEFT JOIN cd_member AS b ON a.member_id = b.member_id
                    LEFT JOIN cd_lock AS c ON a.lock_id = c.lock_id';

                // 格式化 where 条件
                $res = \xhadmin\CommonService::loadList1($sql, formatWhere($where), $limit, $orderby, 'cd_locklog');
                $list = $res['list'];
            } catch (\Exception $e) {
                exit($e->getMessage());
            }

            $data['rows']  = $list;
            $data['total'] = $res['count'];
            $data['debug'] = $res;
            return json(htmlOutList($data));
        }
    }

    function index1(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			if(session('admin.role') <> 1){
				$where['a.user_id'] = session('admin.user_id');
			}
			$where['c.lock_name'] = ['like',$this->request->param('lock_name', '', 'serach_in')];
			$where['b.realname'] = $this->request->param('realname', '', 'serach_in');
			$where['b.mobile'] = ['like',$this->request->param('mobile', '', 'serach_in')];
            $where['b.remark'] = ['like',$this->request->param('remark', '', 'serach_in')];
			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'locklog_id desc';

			try{
				$sql = 'select a.*,b.headimgurl,b.realname,b.remark,b.nickname,b.mobile,c.lock_name from cd_locklog  as a  inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
				$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby,'cd_locklog');
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			$data['debug'] = $res;
			return json(htmlOutList($data));
		}
	}
/*end*/



}
