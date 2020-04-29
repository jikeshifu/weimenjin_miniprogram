<?php 
/*
 module:		开门记录
 create_time:	2020-04-19 18:58:33
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
	public static function dumpData($where,$orderby){
		try{
			$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
			empty($orderby) && $orderby = 'locklog_id desc ';
			$res = \xhadmin\CommonService::loadList($sql,$where,$limit=50000,$orderby);
			$list = $res['list'];
			$list = htmlOutList($list);
 			if(!$list) throw new \Exception('没有数据');

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			//excel表头
			$sheet->setCellValue('A1','编号');
			$sheet->setCellValue('B1','锁名称');
			$sheet->setCellValue('C1','头像');
			$sheet->setCellValue('D1','呢称');
			$sheet->setCellValue('E1','手机号');
			$sheet->setCellValue('F1','状态');
			$sheet->setCellValue('G1','类型');
			$sheet->setCellValue('H1','备注');
			$sheet->setCellValue('I1','开门时间');

			//excel表内容
			foreach($list as $k=>$v){
				$sheet->setCellValue('A'.($k+2),$v['locklog_id']);
				$sheet->setCellValue('B'.($k+2),$v['lock_name']);
				$sheet->setCellValue('C'.($k+2),$v['headimgurl']);
				$sheet->setCellValue('D'.($k+2),$v['nickname']);
				$sheet->setCellValue('E'.($k+2),$v['mobile']);
				$v['status'] = getFieldVal($v['status'],'成功|1|primary,失败|0|danger');
				$sheet->setCellValue('F'.($k+2),$v['status']);
				$v['type'] = getFieldVal($v['type'],'扫码开门|1|primary,点击开门|2|info,后台开门|3|success');
				$sheet->setCellValue('G'.($k+2),$v['type']);
				$sheet->setCellValue('H'.($k+2),$v['remark']);
				$v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
				$sheet->setCellValue('I'.($k+2),$v['create_time']);
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

