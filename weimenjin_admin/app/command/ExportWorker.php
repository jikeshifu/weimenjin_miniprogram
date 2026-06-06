<?php
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;
use xhadmin\service\admin\LockLogService;

class ExportWorker extends Command
{
    protected function configure()
    {
        $this->setName('export:worker')->setDescription('Process export tasks');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('exportworker started');
        while (true) {
            $task = Db::name('export_task')->where('status', 'pending')->order('id')->find();
            if (!$task) {
                sleep(5);
                continue;
            }
            Db::name('export_task')->where('id', $task['id'])->update(['status'=>'processing', 'updated_at'=>date('Y-m-d H:i:s')]);
            $params = json_decode($task['params'], true);
            try {
                $file_path = $this->doExport($params, $task['id']);
                Db::name('export_task')->where('id', $task['id'])->update([
                    'status'=>'finished',
                    'file_path'=>$file_path,
                    'updated_at'=>date('Y-m-d H:i:s')
                ]);
            } catch (\Throwable $e) {
                Db::name('export_task')->where('id', $task['id'])->update([
                    'status'=>'failed',
                    'msg'=>$e->getMessage(),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    // 分批导出逻辑，生成zip
    protected function doExport($params, $task_id)
    {
        $whereArr = [];
        // 权限控制：超级管理员可导出全部，普通用户只能导出自己数据
        if (!isset($params['role']) || $params['role'] != 1) {
            $whereArr[] = 'a.user_id = ' . intval($params['admin_id']);
        }
        $start_ts = isset($params['create_time_start']) ? strtotime($params['create_time_start']) : 0;
        $end_ts = isset($params['create_time_end']) ? strtotime($params['create_time_end']) : 0;
        if (!empty($params['create_time_start']) && !empty($params['create_time_end']) && $start_ts && $end_ts) {
            $whereArr[] = "a.create_time BETWEEN $start_ts AND $end_ts";
        }
        if (!empty($params['lock_name'])) {
            $whereArr[] = "c.lock_name LIKE '%" . addslashes($params['lock_name']) . "%'";
        }
        if (!empty($params['realname'])) {
            $whereArr[] = "b.realname = '" . addslashes($params['realname']) . "'";
        }
        if (!empty($params['mobile'])) {
            $whereArr[] = "b.mobile LIKE '%" . addslashes($params['mobile']) . "%'";
        }
        if (!empty($params['remark'])) {
            $whereArr[] = "b.remark LIKE '%" . addslashes($params['remark']) . "%'";
        }
        $whereStr = $whereArr ? 'WHERE ' . implode(' AND ', $whereArr) : '';
        $countSql = "SELECT COUNT(*) as total FROM cd_locklog a LEFT JOIN cd_member b ON a.member_id=b.member_id LEFT JOIN cd_lock c ON a.lock_id=c.lock_id $whereStr";
        $countRes = Db::query($countSql);
        $total = $countRes ? $countRes[0]['total'] : 0;
        $batchSize = 20000;
        $batches = ceil($total / $batchSize);
        $files = [];
        $filenamePrefix = 'locklog_' . date('Ymd_His') . '_' . $task_id;
        $csvHeader = [
            '编号','锁名称','头像','呢称','姓名','备注','手机号','状态','类型','开门时间'
        ];
        for ($i = 0; $i < $batches; $i++) {
            $offset = $i * $batchSize;
            $sql = "SELECT a.locklog_id,a.member_id,a.lock_id,a.status,a.type,a.create_time,a.user_id,a.lremark,a.cardsn,a.user_name,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile,c.lock_name FROM cd_locklog a LEFT JOIN cd_member b ON a.member_id=b.member_id LEFT JOIN cd_lock c ON a.lock_id=c.lock_id $whereStr ORDER BY locklog_id desc LIMIT $offset,$batchSize";
            $list = Db::query($sql);
            if ($list) {
                $partFile = runtime_path() . $filenamePrefix . '_part' . ($i+1) . '.csv';
                $fp = fopen($partFile, 'w');
                // 写入表头
                fputcsv($fp, $csvHeader);
                foreach ($list as $v) {
                    $row = [
                        $v['locklog_id'],
                        $v['lock_name'],
                        $v['headimgurl'],
                        $v['nickname'],
                        $v['realname'],
                        $v['remark'],
                        $v['mobile'],
                        getFieldVal($v['status'],'成功|1|primary,失败|0|danger'),
                        getFieldVal($v['type'],'扫码开门|1|primary,点击开门|2|info,后台开门|3|success'),
                        date('Y-m-d H:i:s',$v['create_time'])
                    ];
                    fputcsv($fp, $row);
                }
                fclose($fp);
                $files[] = $partFile;
            }
        }
        if (empty($files)) {
            throw new \Exception('没有数据');
        }
        $zipFile = runtime_path() . $filenamePrefix . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        foreach ($files as $file) @unlink($file);
        return $zipFile;
    }
}
