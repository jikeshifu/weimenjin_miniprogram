<?php 
/*
 module:		卡管理
 create_time:	2020-05-18 00:43:19
 author:		duanxy
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LockCardService;
use xhadmin\db\LockCard as LockCardDb;
use think\facade\Cache;
use think\facade\Log;

class LockCard extends Common {



/*start*/
	/**
	* @api {post} /LockCard/getcardlistbylockid 01、获取锁下卡列表
	* @apiGroup LockCard
	* @apiVersion 1.0.0
	* @apiDescription  获取锁下卡列表

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}		    lock_id 锁ID 
	* @apiParam (输入参数：) {int}		    [lockauth_id] 钥匙ID，当传此值时查询当前钥匙下绑定的卡

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function getcardlistbylockid(){
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');
        $lock_id = $this->request->post('lock_id', '', 'serach_in');
        $lockauth_id = $this->request->post('lockauth_id', '', 'serach_in');
        $keyword = $this->request->param('keyword', '', 'serach_in');
        if(!$lock_id) return json(['status'=>$this->errorCode,'msg'=>'lock_id不能为空']);
        //mlog("getcardlistbylockid-lock_id:".$lock_id);
        //读远程卡入库
        //查询锁序列号
		$lockdata=\xhadmin\db\Lock::getInfo($lock_id);
		if($lockdata)
		{   $postdata['sn']=$lockdata['lock_sn'];
            $result=wmjManageHandle($lockdata['lock_sn'],'readcard',$postdata);
            //mlog("getopenlogbylockid-readcard:".json_encode($result));
            foreach ($result['data'] as $value) 
            {
                //判断当前锁是否已经有此卡
                $where = [];
		        $where['lock_id'] = $lock_id;
                $where['lockcard_sn'] = $value['carduid'];
                $havelockcard=\xhadmin\db\LockCard::getWhereInfo($where);
                if(!$havelockcard)
                {
                    //mlog("getopenlogbylockid-readcard-detaile:".json_encode($value));
                    $carddata['lock_id']=$lock_id;
                    $carddata['user_id']=$lockdata['user_id'];
                    $carddata['lockcard_sn']=$value['carduid'];
                    $carddata['lockcard_endtime']=date('Y-m-d H:i:s',$value['endtime']);
                    $carddata['lockcard_createtime']=$value['dateline'];
                    $res=LockCardService::addauthcard($carddata);
                }
                else
                {
                    //mlog("getopenlogbylockid-readcard-have:".json_encode($value));
                }
                
            }
		}
        //
		$where = [];
		//$where['t.lock_id'] = $lock_id;
        //$where['t.lockauth_id'] = $lockauth_id;
        //$where['t.lockcard_username'] = ['like',$this->request->param('keyword', '', 'serach_in')];
        //$where['t.lockcard_username'] = ['exp',"like"."'%".$keyword."%'"."or t.lockcard_sn like"."'%".$keyword."%'"."or t.lockcard_remark like"."'%".$keyword."%'"];
        //$create_time_start = $this->request->post('create_time_start', '', 'serach_in');
		//$create_time_end = $this->request->post('create_time_end', '', 'serach_in');
		//$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'lockcard_id desc';

		try{
			$sql = 'select t.*,c.nickname,c.mobile,c.headimgurl from (select a.*,b.auth_status,b.auth_starttime,b.auth_endtime,b.member_id from cd_lockcard as a left join cd_lockauth as b on a.lockauth_id=b.lockauth_id where a.lockcard_username like \'%'.$keyword.'%\' or a.lockcard_sn like \'%'.$keyword.'%\' or a.lockcard_remark like \'%'.$keyword.'%\') as t left join cd_member as c on t.member_id=c.member_id where t.lock_id = '.$lock_id;
			$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}


	/**
	* @api {post} /LockCard/addauthcard 02、添加卡
	* @apiGroup LockCard
	* @apiVersion 1.0.0
	* @apiDescription  添加卡

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				lock_id 锁ID
	* @apiParam (输入参数：) {int}				[lockauth_id] 钥匙ID,当传此参数时和钥匙绑定。
	* @apiParam (输入参数：) {string}			user_id 管理员ID
	* @apiParam (输入参数：) {string}			lockcard_sn IC卡序列号，8位，如37163DF0 
	* @apiParam (输入参数：) {string}			lockcard_endtime 过期时间(钥匙下的卡过期时间取钥匙过期时间)
	* @apiParam (输入参数：) {string}			lockcard_username 持有人 
	* @apiParam (输入参数：) {string}			lockcard_remark 备注 

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
	function addauthcard(){
		$postField = 'lock_id,lockauth_id,user_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime';
		$data = $this->request->only(explode(',',$postField),'post',null);
        if(!$data['lock_id']) return json(['status'=>$this->errorCode,'msg'=>'lock_id不能为空']);
        if(!$data['user_id']) return json(['status'=>$this->errorCode,'msg'=>'user_id不能为空']);
        if(!$data['lockcard_sn']) return json(['status'=>$this->errorCode,'msg'=>'卡号不能为空']);
        if(strlen($data['lockcard_sn'])<8) return json(['status'=>$this->errorCode,'msg'=>'卡号长度不对']);
        //判断当前锁是否已经有此卡
        $where = [];
		$where['lock_id'] = $data['lock_id'];
        $where['lockcard_sn'] = $data['lockcard_sn'];
        $islockcard=\xhadmin\db\LockCard::getWhereInfo($where);
        //mlog("islockcard:".json_encode($islockcard));
        if ($islockcard) {
            return json(['status'=>$this->errorCode,'data'=>$res,'msg'=>'此卡已存在']);
        }
		//查询锁序列号
		$lockdata=\xhadmin\db\Lock::getInfo($data['lock_id']);
		//mlog("addauthcard:".json_encode($lockdata));
		if($lockdata)
		{
			try {
			    //执行添加卡到设备
			    $postdata['sn']=$lockdata['lock_sn'];
			    $postdata['cardsn']=$data['lockcard_sn'];
			    $postdata['endtime']=strtotime($data['lockcard_endtime']);
			    $data['lockcard_endtime']= $data['lockcard_endtime'];
			    if ($lockdata['lock_sn']) 
			    {
			        //mlog("card_data:".json_encode($postdata));
			        $result=wmjManageHandle($lockdata['lock_sn'],'addcard',$postdata);
			        
			        if ($result['state']) 
			        {
			            $res=LockCardService::addauthcard($data);
			        }
				    else
				    {
				        return json(['status'=>'201','msg'=>$result['state_msg']]);
				    }
			    }
			    
			} 
		catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		    return json(['status'=>$this->successCode,'data'=>$res,'msg'=>$result['state_msg']]);
		}
		else
		{
		    return json(['status'=>$this->errorCode,'data'=>$res,'msg'=>'操作失败']);
		}
	}

	/**
	* @api {post} /LockCard/updatecard 03、更新卡
	* @apiGroup LockCard
	* @apiVersion 1.0.0
	* @apiDescription  更新卡
	
	* @apiParam (输入参数：) {string}     		lockcard_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			lockcard_endtime 过期时间 
	* @apiParam (输入参数：) {string}			lockcard_username 持有人 
	* @apiParam (输入参数：) {string}			lockcard_remark 备注 

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
	function updatecard(){
		$postField = 'lockcard_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lockcard_id'])) return json(['status'=>$this->errorCode,'msg'=>'lockcard_id不能为空']);
        $lockcarddata=LockCardDb::getInfo($data['lockcard_id']);
		$lockdata=\xhadmin\db\Lock::getInfo($lockcarddata['lock_id']);
			try {
			    $postdata['sn']=$lockdata['lock_sn'];
			    $postdata['cardsn']=$lockcarddata['lockcard_sn'];
			    $postdata['endtime']=strtotime($data['lockcard_endtime']);
			    $data['lockcard_endtime']= $data['lockcard_endtime'];
			    if ($lockdata['lock_sn']) 
			    {
			        //mlog("card_data:".json_encode($postdata));
			        $result=wmjManageHandle($lockdata['lock_sn'],'addcard',$postdata);
			        if ($result['state']) 
			        {
			            $where['lockcard_id'] = $data['lockcard_id'];
			            $res = LockCardService::updatecard($where,$data);
			        }
				    else
				    {
				        return json(['status'=>'201','msg'=>$result['state_msg']]);
				    }
				   
			    }
			    
				
			} 
		catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>$result['state_msg']]);
	}

	/**
	* @api {post} /LockCard/delcard 04、删除卡
	* @apiGroup LockCard
	* @apiVersion 1.0.0
	* @apiDescription  删除卡

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}     		lockcard_ids 主键id 注意后面跟了s 多数据删除

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
	function delcard(){
		$idx =  $this->request->post('lockcard_ids', '', 'serach_in');
		if(empty($idx)) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try{
			$data['lockcard_id'] = explode(',',$idx);
			//查询卡数据
            $lockcarddata=LockCardDb::getInfo($data['lockcard_id']);
            //查询锁信息
			$lockdata=\xhadmin\db\Lock::getInfo($lockcarddata['lock_id']);
			if ($lockdata['lock_sn']) 
			    {
			        //锁序列号
			        $postdata['sn']=$lockdata['lock_sn'];
			        //卡序列号
			        $postdata['cardsn']=$lockcarddata['lockcard_sn'];
			        //执行远程删除
			        $result=wmjManageHandle($lockdata['lock_sn'],'delcard',$postdata);
			        if ($result['state']) 
			        {
			            //LockCardService::delete(['lockcard_id'=>$delcardarr[$index]]);
			            LockCardService::delcard($data);
			        }
				    else
				    {
				        return json(['status'=>'00','msg'=>$result['state_msg']]);
				    }
                    
			    }
			
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>'操作失败']);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /LockCard/viewcarddetail 05、查看卡数据
	* @apiGroup LockCard
	* @apiVersion 1.0.0
	* @apiDescription  查看卡数据
	
	* @apiParam (输入参数：) {string}     		lockcard_id 主键ID

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
	function viewcarddetail(){
		$data['lockcard_id'] = $this->request->post('lockcard_id','','intval');
		//mlog("viewcarddetail:".$data['lockcard_id']);
		try{
			$res = checkData(LockCardDb::query('select t.*,c.nickname,c.mobile from (select a.*,b.auth_status,b.auth_starttime,b.auth_endtime,b.member_id from cd_lockcard as a left join cd_lockauth as b on a.lockauth_id=b.lockauth_id) as t left join cd_member as c on t.member_id=c.member_id where t.lockcard_id = '.$data['lockcard_id']));
			
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res[0]]);
	}
/*end*/



}

