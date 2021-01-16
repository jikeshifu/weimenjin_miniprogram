<?php 
/*
 module:		门锁列表
 create_time:	2020-06-23 22:40:49
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LockService;
use xhadmin\db\Lock as LockDb;
use think\facade\Cache;
use think\facade\Log;

class Lock extends Common {


	/**
	* @api {post} /Lock/view 04、查询锁信息
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  根据lock_id查询锁信息
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据详情
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"没有数据"}
	*/
	function view(){
		$data['lock_id'] = $this->request->post('lock_id','','intval');
		try{
			$field='lock_id,user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,lock_qrcode,online,successimg,successadimg,volume,openttscontent,addcardmode';
			$res  = checkData(LockDb::getWhereInfo($data,$field));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}


/*start*/
	/**
	* @api {post} /Lock/devaddcard 09、控制设备进出发卡模式
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  控制设备进出发卡模式
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)
    * @apiParam (输入参数：) {int}     		  addcardmode 1为进入发卡模式，2为退出发卡模式 (必填)
    * 
	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function devaddcard(){
		$postField = 'lock_id,addcardmode';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'lock_id不能为空']);
		if(empty($data['addcardmode'])) return json(['status'=>$this->errorCode,'msg'=>'addcardmode不能为空']);
		try {
			$lockdata=\xhadmin\db\Lock::getInfo($data['lock_id']);
		    $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
		    $postdata['sn']=$lockdata['lock_sn'];
		    $postdata['addcardmode']=$data['addcardmode'];
		    if ($stateresult['online'])
		    {
		       
			    $result=wmjManageHandle($lockdata['lock_sn'],'devaddcard',$postdata);
			    if (!$result['state']) 
			     {
			         return json(['status'=>'201','msg'=>$result['state_msg']]);
			     }
			    else
			     {
			        db()->name('lock')->where('lock_id', $data['lock_id'])->update(['addcardmode' => $data['addcardmode']]);
			     }
		    }
		    else
		    {
		        return json(['status'=>$this->errorCode,'msg'=>'控制失败,设备不在线']);
		    }
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/**
	* @api {post} /Lock/townership 08、转移所有权
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  转移所有权
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)
	* @apiParam (输入参数：) {string}     		lockauth_id  当前钥匙ID(必填)
	* @apiParam (输入参数：) {int}				member_id 接收人的会员ID (必填)
	* @apiParam (输入参数：) {string}			user_id 接收人的管理员ID (必填)

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function townership(){
		$postField = 'lock_id,member_id,user_id,lockauth_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'lock_id参数错误']);
		if(empty($data['lockauth_id'])) return json(['status'=>$this->errorCode,'msg'=>'lockauth_id参数错误']);
		if(empty($data['member_id'])) return json(['status'=>$this->errorCode,'msg'=>'member_id参数错误']);
		if(empty($data['user_id'])) return json(['status'=>$this->errorCode,'msg'=>'user_id参数错误']);
		$resauthdata=\xhadmin\db\LockAuth::getInfo($data['lockauth_id']);
		mlog("townership-resauthdata:".json_encode($resauthdata));
		if($resauthdata['auth_member_id']>0) return json(['status'=>$this->errorCode,'msg'=>'您不是超级管理员，无法转移']);
		try {
			//$where['lock_id'] = $data['lock_id'];
			//$res = LockService::townership($where,$data);
			//mlog("townership:".json_encode($res));
			db()->name('lock')->where('lock_id', $data['lock_id'])->update(['user_id' => $data['user_id'],'member_id'=>$data['member_id']]);
			db()->name('lockauth')->save(['lockauth_id' => $data['lockauth_id'], 'user_id' => $data['user_id'],'member_id'=>$data['member_id'],'auth_member_id'=>0]);
			db()->name('lockauth')->where('lock_id', $data['lock_id'])->update(['user_id' => $data['user_id']]);
			db()->name('locklog')->where('lock_id', $data['lock_id'])->update(['user_id' => $data['user_id']]);
			db()->name('lockcard')->where('lock_id', $data['lock_id'])->update(['user_id' => $data['user_id']]);
			db()->name('locktimes')->where('lock_id', $data['lock_id'])->update(['user_id' => $data['user_id']]);
		} catch (\Exception $e) {
		    mlog("townership:".$e);
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

/*end*/


/*start*/
	/**
	* @api {post} /Lock/configlcd 07、配置显示屏二维码
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  配置显示屏二维码
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function configlcd(){
		$postField = 'lock_id,qrcodeurl';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
		    $lockdata=\xhadmin\db\Lock::getInfo($data['lock_id']);
		    $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
		    $postdata['sn']=$lockdata['lock_sn'];
		    $postdata['qrcodeurl']='https://'.$_SERVER['HTTP_HOST'].'/minilock?user_id='.$lockdata['user_id'].'&lock_id='.$data['lock_id'].'&st=';
		    if ($stateresult['online'])
		    {
			    $result=wmjManageHandle($lockdata['lock_sn'],'lcdconfig',$postdata);
			    if (!$result['state']) 
			     {
			         return json(['status'=>'201','msg'=>$result['state_msg']]);
			     }
		    }
		    else
		    {
		        return json(['status'=>$this->errorCode,'msg'=>'设置失败,设备不在线']);
		    }
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}



	/**
	* @api {post} /Lock/configaudio 06、语音设置
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  修改语音设置
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				volume 音量 
	* @apiParam (输入参数：) {string}			openttscontent 语音内容 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function configaudio(){
		$postField = 'lock_id,volume,openttscontent';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
		    //查询锁序列号
		    $lockdata=\xhadmin\db\Lock::getInfo($data['lock_id']);
		    $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
		    $postdata['sn']=$lockdata['lock_sn'];
		    $postdata['openttscontent']=$data['openttscontent'];
		    $postdata['volume']=$data['volume'];
		    if ($stateresult['online'])
		    {
		        $where['lock_id'] = $data['lock_id'];
			    $res = LockService::configaudio($where,$data);
			    $result=wmjManageHandle($lockdata['lock_sn'],'audioconfig',$postdata);
			    if (!$result['state']) 
			     {
			         return json(['status'=>'201','msg'=>$result['state_msg']]);
			     }
		    }
			
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/**
	* @api {post} /Lock/update 02、修改
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  修改
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			lock_name 锁名称 (必填) 
	* @apiParam (输入参数：) {int}				mobile_check 绑定手机 是|1|primary,否|0|info
	* @apiParam (输入参数：) {int}				applyauth 申请钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				applyauth_check 审核钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				location_check 开门距离 
	* @apiParam (输入参数：) {int}				status 开关 启用|1|success,禁用|0|danger

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function update(){
		$postField = 'lock_id,lock_name,mobile_check,applyauth,applyauth_check,location_check,status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
		    //查询这个锁的信息
		    $lockdata=LockDb::getInfo($data['lock_id']);
		    //删除之前生成的二维码
			$arr = parse_url($lockdata['lock_qrcode']);
			$urlarr = pathinfo($arr['path']);
			$path = app()->getRootPath().'public/qrdata/qrcode/';
			$qrcodename = $urlarr['basename'];
			$qrcodefile=$path.$qrcodename;
			if (!unlink($qrcodefile)) 
			{
				//mlog("updatelock_lock_qrcode_delete_fail:".json_encode($urlarr['basename']));
		    }
		    $qrcodeurl="https://".$_SERVER['HTTP_HOST']."/minilock?"."user_id=".$lockdata['user_id']."&lock_id=".$data['lock_id'];
			//mlog("updatelock_data_user_id:".json_encode($lockdata['user_id']));
			$data['lock_qrcode'] = $this->createmarkqrcode($qrcodeurl,$data['lock_name']);
			$where['lock_id'] = $data['lock_id'];
			$res = LockService::update($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/**
	* @api {post} /Lock/delete 03、删除
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  删除
	* @apiParam (输入参数：) {string}     		lock_ids 主键id 注意后面跟了s 多数据删除
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"操作失败"}
	*/
	function delete(){
		$idx =  $this->request->post('lock_ids', '', 'serach_in');
		if(empty($idx)) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try{
			$data['lock_id'] = explode(',',$idx);
			LockService::delete($data);
			$ret = \xhadmin\service\api\LockAuthService::delete($data);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>'操作失败']);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/**
	* @api {post} /Lock/add 01、添加
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			user_id 用户ID 
	* @apiParam (输入参数：) {string}			lock_name 锁名称 (必填) 
	* @apiParam (输入参数：) {string}			lock_sn 序列号 (必填) 
	* @apiParam (输入参数：) {int}				mobile_check 绑定手机 是|1|primary,否|0|info
	* @apiParam (输入参数：) {int}				getkey 领取钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				getkey_check 审核钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				status 开关 启用|1|success,禁用|0|danger
	* @apiParam (输入参数：) {int}				lock_type 类型 
	* @apiParam (输入参数：) {string}			location 位置 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function add(){
		$postField = 'member_id,user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,location_check,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_sn'])) return json(['status'=>$this->errorCode,'msg'=>'序列号不能为空']);
		if(empty($data['lock_name'])) return json(['status'=>$this->errorCode,'msg'=>'锁名称不能为空']);
		if(empty($data['user_id'])) return json(['status'=>$this->errorCode,'msg'=>'管理员ID不能为空']);
		if(empty($data['member_id'])) return json(['status'=>$this->errorCode,'msg'=>'会员ID不能为空']);
		try {
		    $data['lock_sn']=strtoupper($data['lock_sn']);
		    $wmjapiresult = wmjHandle($data['lock_sn'],'postlock');
			if ($wmjapiresult['state']) 
			{
			    $data['mobile_check'] = 1;
			    $data['applyauth'] = 0;
			    $data['applyauth_check'] = 0;
			    $data['status'] = 1;
			    $data['location_check'] = 0;
			    $data['openbtn'] = 1;
			    $data['hitshowminiad'] = 1;
			    $data['qrshowminiad'] = 1;
			    $data['create_time'] = time();
			    $data['successimg'] = '/uploads/admin/202007/5f1c6367d68fd.jpg';
    			$res = LockService::add($data);
    			if ($res) 
    			{ 
    			    $lock_id=$res;
					$qrcodeurl="https://".$_SERVER['HTTP_HOST']."/minilock?"."user_id=".$data['user_id']."&lock_id=".$lock_id;
					$data['lock_qrcode'] = $this->createmarkqrcode($qrcodeurl,$data['lock_name']);
					$where['lock_id'] = $lock_id;
					$ret = LockService::update($where,$data);
					//给自己添加钥匙
    			    $authdata['lock_id']=$res;
    				$authdata['member_id']=$data['member_id'];
    				$authdata['auth_member_id']=0;
    				$authdata['auth_shareability']=1;
    				$authdata['auth_sharelimit']=0;
    				$authdata['auth_openlimit']=0;
    				$authdata['auth_starttime']=time();
    				$authdata['auth_endtime']=0;
    				$authdata['auth_isadmin']=1;
    				$authdata['auth_status']=1;
    				$authdata['user_id']=$data['user_id'];
    				$ret = \xhadmin\service\api\LockAuthService::applyauth($authdata);
    			}
			}
			else 
			{
				return json(['status'=>'00','msg'=>$wmjapiresult['state_msg']]);
			}
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}
/*end*/

 /*start*/
	/**
	* @api {post} /Lock/opendoor 05、开门
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  编辑数据
	
	* @apiParam (输入参数：) {int}     		lock_id 主键ID (必填)
    *@apiParam (输入参数：) {int}     		member_id 会员ID (必填)
    * @apiParam (输入参数：) {int}     		user_id  管理员ID (必填)
    * @apiParam (输入参数：) {int}     		type 1扫码开门,2菜单开门,管理员开门 (必填)
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.opendoor_status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.opendoor_status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiParam (需要绑定手机返回参数：) {string}     	array 返回结果集
	* @apiParam (需要绑定手机返回参数：) {string}     	array.opendoor_status 返回错误码 202
	* @apiParam (需要绑定手机返回参数：) {string}     	array.msg 返回需要绑定手机消息
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array 返回结果集
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array.opendoor_status 返回错误码 203
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array.msg 返回需要申请钥匙且审核消息
	* @apiParam (需要申请钥匙返回参数：) {string}     	array 返回结果集
	* @apiParam (需要申请钥匙返回参数：) {string}     	array.opendoor_status 返回错误码 204
	* @apiParam (需要申请钥匙返回参数：) {string}     	array.msg 返回需要申请钥匙消息
	* @apiSuccessExample {json} 01 成功示例
	* {"opendoor_status":"200","msg":"开门成功",'successimg'=>'/uploads/admin/202003/5e758dd0d7d15.png','successadimg'=>'/uploads/admin/202003/5e758e6fe9216.png'}
	* @apiErrorExample {json} 02 失败示例
	* {"opendoor_status":"201","msg":"错误信息"}
	* @apiErrorExample {json} 03 需要绑定手机示例
	* {"opendoor_status":"202","msg":"需要绑定手机号"}
	* @apiErrorExample {json} 04 需要申请钥匙且审核示例
	* {"opendoor_status":"203","msg":"需要申请钥匙且审核"}
	* @apiErrorExample {json} 05 需要申请钥匙示例
	* {"opendoor_status":"204","msg":"需要申请钥匙"}
	*/
	function opendoor()
	{
		
		$lock_id = $this->request->post('lock_id','','intval');
		$member_id = $this->request->post('member_id','','intval');
		$user_id = $this->request->post('user_id','','intval');
		$openst = $this->request->post('st','','intval');
		$type = $this->request->post('type','','intval');
		if(!$lock_id) return json(['opendoor_status'=>'101','msg'=>'lock_id不能为空']);
		if(!$member_id) return json(['opendoor_status'=>'101','msg'=>'member_id不能为空']);
		if(!$user_id) return json(['opendoor_status'=>'101','msg'=>'$user_id不能为空']);
		//根据锁id拿到锁信息,根据会员id拿到会员信息，根据会员id和锁id拿到钥匙信息
		$reslookdata=LockDb::getInfo($lock_id);
		$user_id=$reslookdata['user_id'];
		$resmemdata=\xhadmin\db\Member::getInfo($member_id);
		$authdata['member_id']=$member_id;
		$authdata['lock_id']=$lock_id;
		$umemdata['member_id']=$member_id;
		$umemdata['user_id']=$user_id;
		$resauthdata=\xhadmin\db\LockAuth::getWhereInfo($authdata);
		$resumemdata=\xhadmin\db\Umember::getWhereInfo($umemdata);
		if($openst&&$openst>0)
		{
		    $openst=$openst-1314520;
		    //mlog("openst:".$openst);
		    if ((time()-$openst)>60) 
		    {
		        return json(['opendoor_status'=>'201','msg'=>'二维码已过期']);
		    }
		}
		//创建用户信息
		if (!$resumemdata) 
		{
		    $umemdata['status']=1;
		    $umemdata['ucreate_time']=time();
		    $umemcreate=\xhadmin\db\Umember::createData($umemdata);
		}
		if ($resumemdata&&$resumemdata['status']==0) 
		{
		    //mlog("opendoor_status no auth!");
		    return json(['opendoor_status'=>'201','msg'=>'无权限']);
		}
		//mlog("opendoor_reslookdatauserid:".json_encode($user_id));
		//mlog("opendoor_resmemdatalock_id:".json_encode($lock_id));
		//mlog("opendoor_resauthdatamember_id:".json_encode($member_id));
		//判断设备是否停用
		
		if (!$reslookdata['status']) 
		{
			return json(['opendoor_status'=>'205','msg'=>'设备已停用']);
		}
		
		//判断是否要绑定手机号
		if ($reslookdata['mobile_check']&&!$resmemdata['mobile']) 
		{
			return json(['opendoor_status'=>'202','msg'=>'需要绑定手机号']);
		}
		//判断钥匙是否审核
		if ($reslookdata['applyauth_check']&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'203','msg'=>'需要申请钥匙且审核']);
		}
		//判断钥匙是否有效
		if ($resauthdata&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'201','msg'=>'钥匙已被禁用']);
		}
		//判断钥匙是否过期
		//mlog("resauthdata:".$resauthdata['auth_endtime']);
		//mlog("now:".time());
		if ($resauthdata&&$resauthdata['auth_starttime']&&$resauthdata['auth_endtime']&&$resauthdata['auth_endtime']<time()) 
		{
			return json(['opendoor_status'=>'201','msg'=>'钥匙已过期']);
		}
		//判断是否在锁的可开时段
		//读锁可开时段
		$locktimewhere['lock_id']=$lock_id;
		$locktimewhere['type']=1;
		$reslocktimedata=\xhadmin\db\Locktimes::loadList($locktimewhere);
		$locktd=count($reslocktimedata);//判断是否有锁可开时段限制
		if($locktd>0&&!$resauthdata['auth_isadmin'])
		{
		    //mlog("reslocktimedata_have");
		    $isopen=0;
		    foreach ($reslocktimedata as $value)
		    {
		        if(date('N')>=$value['startweek']&&date("N")<=$value['endweek'])
		        {
		            $nowtime = intval (date("Hi"));
		            //mlog("lock_nowtime:".$nowtime);
		            $startth=str_pad($value['starthour'], 2, '0', STR_PAD_LEFT).str_pad($value['startminute'], 2, '0', STR_PAD_LEFT);
		            $endth=str_pad($value['endhour'], 2, '0', STR_PAD_LEFT).str_pad($value['endminute'], 2, '0', STR_PAD_LEFT);
		            //mlog("lock_startth:".$startth);
		            //mlog("lock_endth:".$endth);
		            if ($nowtime >= $startth && $nowtime <= $endth) 
		            {
		                $isopen=1;
		                break;
		            }
		            else
		            {
		                $isopen=0;
		            }
		        }
		        else
		        {
		           $isopen=0;
		        }
		    }
		    if(!$isopen)
		    {
		        return json(['opendoor_status'=>'201','msg'=>'不在可开门时段']);
		    }
		}
		//判断是否在钥匙的可开时段
		//读钥匙可开时段
		$ids = explode(",",$resauthdata['auth_opentimes']);
		$locktimewhere=[['lock_id','=',$lock_id],['type','=',2],['locktimes_id','in',$ids]];
		$lockauthtimes=db()->name('locktimes')->where($locktimewhere)->select();
		$lockatcount=count($lockauthtimes);
		if($lockatcount>0&&!$resauthdata['auth_isadmin'])
		{
		    $isauthopen=0;
		    foreach ($lockauthtimes as $value)
		    {
		        if(date('N')>=$value['startweek']&&date("N")<=$value['endweek'])
		        {
		            $nowtime = intval (date("Hi"));
		            //mlog("auth_nowtime:".$nowtime);
		            $startth=str_pad($value['starthour'], 2, '0', STR_PAD_LEFT).str_pad($value['startminute'], 2, '0', STR_PAD_LEFT);
		            $endth=str_pad($value['endhour'], 2, '0', STR_PAD_LEFT).str_pad($value['endminute'], 2, '0', STR_PAD_LEFT);
		            //mlog("auth_startth:".$startth);
		            //mlog("auth_endth:".$endth);
		            if ($nowtime >= $startth && $nowtime <= $endth) 
		            {
		                $isauthopen=1;
		                break;
		            }
		            else
		            {
		                $isauthopen=0;
		            }
		        }
		        else
		        {
		           $isauthopen=0;
		        }
		    }
		    if(!$isauthopen)
		    {
		        return json(['opendoor_status'=>'201','msg'=>'钥匙不在可开门时段']);
		    }
		}
		//判断开门次数是否用尽
		if ($resauthdata&&$resauthdata['auth_openlimit']>0) 
		{
		    //mlog("auths_openlimit:".json_encode($resauthdata));
		    if($resauthdata['auth_openlimit']<=$resauthdata['auth_openused'])
		    {
		        return json(['opendoor_status'=>'201','msg'=>'可开门次数用尽']);
		    }
		    else
		    {
		        $where['lockauth_id'] = $resauthdata['lockauth_id'];
		        $openuseddata['auth_openused'] = $resauthdata['auth_openused']+1;
		        $ret = \xhadmin\service\api\LockAuthService::verifyauth($where,$openuseddata);
		    }
			
		}
		//判断用户申请钥匙自动获得
		if ($reslookdata['applyauth']&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'204','msg'=>'需要申请钥匙']);
		}
		
		try{
				$resdata=LockDb::getInfo($lock_id);
				//mlog("Lock_opendoor_data:".json_encode($resdata));
				if ($resdata) 
				{
				    if ($resdata['lock_type']==7) 
				    {
				        $result = wmjgwHandle($resdata['lock_sn'], 'ctrlgwl');
				    }
				    else
				    {
				        $result = wmjHandle($resdata['lock_sn'], 'openlock');
				    }
					$data['member_id']=$member_id;
					$data['lock_id']=$lock_id;
					$data['user_id']=$user_id;
					$data['type']=(int)$type;
					//mlog("Lock_opendoor_wmjHandle:".json_encode($result));
					if ($result['state'])
					{
						$data['status']=1;
						\xhadmin\service\api\LockLogService::add($data);
						return json(['opendoor_status'=>'200','msg'=>'开门成功','successimg'=>$resdata['successimg'],'successadimg'=>$resdata['successadimg'],'hitshowminiad'=>$resdata['hitshowminiad'],'qrshowminiad'=>$resdata['qrshowminiad'],'openadurl'=>$resdata['openadurl'],'adnum'=>$resdata['adnum']]);
					}
					else {
						$data['status']=0;
						$data['remark']=$result['state_msg'];
						\xhadmin\service\api\LockLogService::add($data);
						return json(['opendoor_status'=>'201','msg'=>$result['state_msg']]);
					}
				}
			}catch(\Exception $e){
				//$this->error($e->getMessage());
				return json(['opendoor_status'=>'201','msg'=>$result['state_msg']]);
			}
	}
/*end*/

/*start*/
	/**
	* @api {post} /Lock/getphone 09、获取管理员手机号
	*/
	function getphone()
	{
		
		$lock_sn = $this->request->post('sn','','');
		$authkey = $this->request->post('key','','');
		if(!$lock_sn) return json(['status'=>'101','msg'=>'sn不能为空']);
		if(!$authkey) return json(['status'=>'101','msg'=>'key不能为空']);
		//判断钥匙是否有效
		if ($authkey!="McpNWnhKQJze7SBK") 
		{
			return json(['status'=>'201','msg'=>'秘钥错误']);
		}
		$lockmap['lock_sn']=$lock_sn;
		//根据锁sn拿到锁信息,根据会员id拿到会员信息，根据会员id和锁id拿到钥匙信息
		$reslookdata=LockDb::getWhereInfo($lockmap);
		$authdata['lock_id']=$reslookdata['lock_id'];
		$authdata['auth_member_id']=0;
		$authdata['auth_isadmin']=1;
		$resauthdata=\xhadmin\db\LockAuth::getWhereInfo($authdata);
		$resmemdata=\xhadmin\db\Member::getInfo($resauthdata['member_id']);
		try{
				mlog("getphone:".json_encode($resmemdata));
				if ($resmemdata) 
				{
						return json(['status'=>'200','msg'=>'获取成功','mobile'=>$resmemdata['mobile']]);
				}
			}
			catch(\Exception $e)
			{
				return json(['status'=>'201','msg'=>'获取失败']);
			}
	}
/*end*/

/*start*/
   function creatqrcode()
	{
		$url='https://'.$_SERVER['HTTP_HOST'].'/adduser';
		$qrcodename='请使用微信扫码注册';
		return $this->createmarkqrcode($url,$qrcodename);
	}
    //创建带文字下标的二维码图片
	function createmarkqrcode($url, $qrcodename)
	{
		$path = app()->getRootPath().'public/qrdata/qrcode/';
        $file = time(). '.png';
		$qrcode_file = $path . $file;
		
		if (!(is_file($qrcode_file))){
			require_once app()->getRootPath().'/vendor/phpqrcode/phpqrcode.php';
			$object = new \QRcode();
			$object->png($url, $qrcode_file, QR_ECLEVEL_L, 10);
		}
        $font=app()->getRootPath().'public/qrdata/simhei.ttf'; 
        if ($qrcodename) { // 有文字再往图片上加文字
            $size = 14;
            $box = @imagettfbbox($size,0,$font,$qrcodename);
            $fontw = abs($box[4] - $box[0]); // 生成文字的width
            $fonth = abs($box[5] - $box[1]);
            $im = imagecreatefrompng($qrcode_file);
            $info = getimagesize($qrcode_file);
            $imgw = $info[0]; // width
            $imgh = $info[1] + $fonth + 10; // height
            $img = imagecreate($imgw,$imgh);//创建一个长为500高为16的空白图片
            imagecolorallocate($img,0xff,0xff,0xff);//设置图片背景颜色，这里背景颜色为#ffffff，也就是白色
            $black=imagecolorallocate($img,0x00,0x00,0x00);//设置字体颜色，这里为#000000，也就是黑色
            $fontx = 10; // 文字距离图片左侧的距离
            if($imgw > $fontw){
                $fontx = ceil(($imgw-$fontw)/2); // 进一法取整
            }
            imagettftext($img,$size,0,$fontx,($info[1]+$fonth),$black,$font,$qrcodename);//将ttf文字写到图片中
            // 以 50% 的透明度合并水印和图像
            imagecopymerge($img,$im,0, 0, 0, 0, $info[0], $info[1], 100);
            // header('Content-Type: image/png');//发送头信息 浏览器显示
            imagepng($img,$qrcode_file);//输出图片，输出png使用imagepng方法，输出gif使用imagegif方法
        }
		return 'https://'.$_SERVER['HTTP_HOST'].'/qrdata/qrcode/'.$file;	
	}
	/*end*/



}

