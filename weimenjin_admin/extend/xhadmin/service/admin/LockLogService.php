<?php
/*
 module:		开门记录
 create_time:	2022-03-10 17:43:11
 author:
 contact:
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\LockLog;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LockLogService extends CommonService {


	/*
     * @Description  删除
     * @param (输入参数：)  {array}        where 删除条件
     * @return (返回参数：) {bool}
     */
	public static function delete($where){
		try{
			$res = LockLog::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
     * @Description  导出
     * @param (输入参数：)  {array}        where 删除条件
     * @return (返回参数：) {bool}
     */
	public static function dumpData($list,$filename){
		try{
			$list = htmlOutList($list);
			if(!$list) throw new \Exception('没有数据');

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			//excel表头
			$sheet->setCellValue('A1','编号');
			$sheet->setCellValue('B1','锁名称');
			$sheet->setCellValue('C1','头像');
			$sheet->setCellValue('D1','呢称');
			$sheet->setCellValue('E1','姓名');
			$sheet->setCellValue('F1','备注');
			$sheet->setCellValue('G1','手机号');
			$sheet->setCellValue('H1','状态');
			$sheet->setCellValue('I1','类型');
			$sheet->setCellValue('J1','开门时间');

			//excel表内容
			foreach($list as $k=>$v){
				$sheet->setCellValue('A'.($k+2),$v['locklog_id']);
				$sheet->setCellValue('B'.($k+2),$v['lock_name']);
				$sheet->setCellValue('C'.($k+2),$v['headimgurl']);
				$sheet->setCellValue('D'.($k+2),$v['nickname']);
				$sheet->setCellValue('E'.($k+2),$v['realname']);
				$sheet->setCellValue('F'.($k+2),$v['remark']);
				$sheet->setCellValue('G'.($k+2),$v['mobile']);
				$v['status'] = getFieldVal($v['status'],'成功|1|primary,失败|0|danger');
				$sheet->setCellValue('H'.($k+2),$v['status']);
				$v['type'] = getFieldVal($v['type'],
                    '扫码开门|1|primary,' .
                    '点击开门|2|info,' .
                    '后台开门|3|success,' .
                    '刷卡开门|4|warning,' .
                    '点击开电|5|info,' .
                    '点击关电|6|danger,' .
                    '指纹开门|7|primary,' .
                    '蓝牙开门|8|info,' .
                    '喇叭操作|9|warning,' .
                    '生成钥匙|10|success,' .
                    '刷脸开门|11|primary,' .
                    '密码开门|12|info,' .
                    '点击开|13|info,' .
                    '点击关|14|danger,' .
                    '点击停|15|warning,' .
                    '联动开电|16|info,' .
                    '联动关电|17|danger,' .
                    '联动播报|18|warning,' .
                    '开锁步|19|info,' .
                    '关锁步|20|danger,' .
                    '停锁步|21|warning,' .
                    '摄像头向上|22|info,' .
                    '摄像头向下|23|info,' .
                    '摄像头向左|24|info,' .
                    '摄像头向右|25|info,' .
                    '画面旋转|26|info,' .
                    '自动夜视|27|info,' .
                    '遥控器学习|28|info,' .
                    '设置夜视|29|info,' .
                    '设备重启|30|warning,' .
                    '添加遥控器|31|success,' .
                    '删除遥控器|32|danger,' .
                    '语音设置|33|warning,' .
                    '遥控器学习|34|info,' .
                    '格式化SD卡|35|danger,' .
                    '应用配置修改|36|info,' .
                    '继电器延时设置|37|info,' .
                    '继电器模式设置|38|info,' .
                    '开启|39|success,' .
                    '关闭|40|danger,' .
                    '手动开启|41|success,' .
                    '手动关闭|42|danger,' .
                    '定时开启|43|success,' .
                    '定时关闭|44|danger,' .
                    '设置定时播报|50|warning,' .
                    '设置播报任务|51|warning,' .
                    '清除播报任务|52|danger,' .
                    '清除全部播报|53|danger'
                );
				$sheet->setCellValue('I'.($k+2),$v['type']);
				$v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
				$sheet->setCellValue('J'.($k+2),$v['create_time']);
			}

//			$filename = date('YmdHis');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename.'.'.config('my.import_type'));
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}

    /**
     * 将数据写入指定路径的Excel文件
     */
    public static function dumpDataToFile($list, $filePath) {
        try{
            $list = htmlOutList($list);
            if(!$list) throw new \Exception('没有数据');
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            //excel表头
            $sheet->setCellValue('A1','编号');
            $sheet->setCellValue('B1','锁名称');
            $sheet->setCellValue('C1','头像');
            $sheet->setCellValue('D1','呢称');
            $sheet->setCellValue('E1','姓名');
            $sheet->setCellValue('F1','备注');
            $sheet->setCellValue('G1','手机号');
            $sheet->setCellValue('H1','状态');
            $sheet->setCellValue('I1','类型');
            $sheet->setCellValue('J1','开门时间');
            //excel表内容
            foreach($list as $k=>$v){
                $sheet->setCellValue('A'.($k+2),$v['locklog_id']);
                $sheet->setCellValue('B'.($k+2),$v['lock_name']);
                $sheet->setCellValue('C'.($k+2),$v['headimgurl']);
                $sheet->setCellValue('D'.($k+2),$v['nickname']);
                $sheet->setCellValue('E'.($k+2),$v['realname']);
                $sheet->setCellValue('F'.($k+2),$v['remark']);
                $sheet->setCellValue('G'.($k+2),$v['mobile']);
                $v['status'] = getFieldVal($v['status'],'成功|1|primary,失败|0|danger');
                $sheet->setCellValue('H'.($k+2),$v['status']);
                $v['type'] = getFieldVal($v['type'],
                    '扫码开门|1|primary,' .
                    '点击开门|2|info,' .
                    '后台开门|3|success,' .
                    '刷卡开门|4|warning,' .
                    '点击开电|5|info,' .
                    '点击关电|6|danger,' .
                    '指纹开门|7|primary,' .
                    '蓝牙开门|8|info,' .
                    '喇叭操作|9|warning,' .
                    '生成钥匙|10|success,' .
                    '刷脸开门|11|primary,' .
                    '密码开门|12|info,' .
                    '点击开|13|info,' .
                    '点击关|14|danger,' .
                    '点击停|15|warning,' .
                    '联动开电|16|info,' .
                    '联动关电|17|danger,' .
                    '联动播报|18|warning,' .
                    '开锁步|19|info,' .
                    '关锁步|20|danger,' .
                    '停锁步|21|warning,' .
                    '摄像头向上|22|info,' .
                    '摄像头向下|23|info,' .
                    '摄像头向左|24|info,' .
                    '摄像头向右|25|info,' .
                    '画面旋转|26|info,' .
                    '自动夜视|27|info,' .
                    '遥控器学习|28|info,' .
                    '设置夜视|29|info,' .
                    '设备重启|30|warning,' .
                    '添加遥控器|31|success,' .
                    '删除遥控器|32|danger,' .
                    '语音设置|33|warning,' .
                    '遥控器学习|34|info,' .
                    '格式化SD卡|35|danger,' .
                    '应用配置修改|36|info,' .
                    '继电器延时设置|37|info,' .
                    '继电器模式设置|38|info,' .
                    '开启|39|success,' .
                    '关闭|40|danger,' .
                    '手动开启|41|success,' .
                    '手动关闭|42|danger,' .
                    '定时开启|43|success,' .
                    '定时关闭|44|danger,' .
                    '设置定时播报|50|warning,' .
                    '设置播报任务|51|warning,' .
                    '清除播报任务|52|danger,' .
                    '清除全部播报|53|danger'
                );
                $sheet->setCellValue('I'.($k+2),$v['type']);
                $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
                $sheet->setCellValue('J'.($k+2),$v['create_time']);
            }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($filePath);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
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

			$res = LockLog::createData($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}
