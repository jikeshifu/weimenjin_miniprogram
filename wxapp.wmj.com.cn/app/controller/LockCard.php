<?php 
/*
 module:		卡管理
 create_time:	2021-01-19 18:59:23
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockCardService;
use xhadmin\db\LockCard as LockCardDb;

class LockCard extends Admin {



/*start*/
	/*批量编辑数据*/
	function batchupcard(){
		if (!$this->request->isPost())
		{
			$lockcard_id = $this->request->get('lockcard_id','','strip_tags');
			if(!$lockcard_id) $this->error('参数错误');
			$info['lockcard_id'] = $lockcard_id;
			$this->view->assign('info',$info);
			return $this->display('batchupcard');
		}
		else
		{
			$data = $this->request->post();
			try {
				$where['lockcard_id'] = explode(',',$data['lockcard_id']);
				unset($data['lockcard_id']);
				$data['lockcard_endtime'] = strtotime($data['lockcard_endtime']);
				LockCardDb::editWhere($where,$data);
				
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}



	/*导出*/
	function dumpData(){
		$where = [];
		$where['lock_id'] = $this->request->param('lock_id', '', 'serach_in');
		mlog("card_dumpData:".$where['lock_id']);
		$where['lockcard_sn'] = ['like',$this->request->param('lockcard_sn', '', 'serach_in')];
		$where['lockcard_username'] = ['like',$this->request->param('lockcard_username', '', 'serach_in')];
		$where['lockcard_remark'] = ['like',$this->request->param('lockcard_remark', '', 'serach_in')];
		$where['lockcard_id'] = ['in',$this->request->param('lockcard_id', '', 'serach_in')];
        mlog("card_lockcard_id:".json_encode($where['lockcard_id']));
        if (empty($where['lockcard_id'][1])) 
			{
			  $this->error('请选择需要导出的卡');
			  exit();
			}
		$orderby = '';

		try {
			//此处读取前端传过来的 表格勾选的显示字段
			$fieldInfo = [];
			for($j=0; $j<100;$j++){
				$fieldInfo[] = $this->request->param($j);
			}
			$res = LockCardService::dumpData(formatWhere($where),$orderby,filterEmptyArray(array_unique($fieldInfo)));
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}



	/*卡管理*/
	function index(){
		if (!$this->request->isAjax())
		{
		    $lock_id=$this->request->param('lock_id', '', 'serach_in');
		    mlog("card_isAjax:".$lock_id);
		    $lockdata=\xhadmin\db\Lock::getInfo($lock_id);
		    if (substr($lockdata['lock_sn'], 0, 5) != 'WMJ62') 
			{
			   return json(['status'=>'00','msg'=>'4001:该设备不支持刷卡功能']);     
			}
			return $this->display('index');

		}else
		{
		    
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$lock_id=$this->request->param('lock_id', '', 'serach_in');
			$where['lock_id'] = $lock_id;
			$where['lockcard_sn'] = ['like',$this->request->param('lockcard_sn', '', 'serach_in')];
			$where['lockcard_username'] = ['like',$this->request->param('lockcard_username', '', 'serach_in')];
			$where['batchstatus'] = ['like',$this->request->param('batchstatus', '', 'serach_in')];
			$where['lockcard_remark'] = ['like',$this->request->param('lockcard_remark', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'lockcard_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime,batchstatus';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'lockcard_id desc';
            $lockdata=\xhadmin\db\Lock::getInfo($lock_id);
            if($lockdata)
	    	{   $postdata['sn']=$lockdata['lock_sn'];
                $result=wmjManageHandle($lockdata['lock_sn'],'readcard',$postdata);
                //mlog("getopenlogbylockid-readcard:".json_encode($result));
                    foreach ($result['data'] as $value) 
                    {
                        //判断当前锁是否已经有此卡
                        $readwhere = [];
        		        $readwhere['lock_id'] = $lock_id;
                        $readwhere['lockcard_sn'] = $value['carduid'];
                        $havelockcard=\xhadmin\db\LockCard::getWhereInfo($readwhere);
                        if(!$havelockcard)
                        {
                            //mlog("getopenlogbylockid-readcard-detaile:".json_encode($value));
                            $readcarddata['lock_id']=$lock_id;
                            $readcarddata['user_id']=$lockdata['user_id'];
                            $readcarddata['lockcard_sn']=$value['carduid'];
                            $readcarddata['lockcard_username']=$havelockcard['lockcard_username'];
                            $readcarddata['lockcard_remark']=$havelockcard['lockcard_remark'];
                            $readcarddata['lockcard_endtime']=date('Y-m-d H:i:s',$value['endtime']);
                            $readcarddata['lockcard_createtime']=$value['dateline'];
                            $readres=LockCardService::add($readcarddata);
                        }
                        else
                        {
                            //mlog("getopenlogbylockid-readcard-have:".json_encode($value));
                        }
                        
                    }
		    }
			try{
			    
			    if (substr($lockdata['lock_sn'], 0, 5) == 'WMJ62') 
			    {
			        
			        $res = LockCardService::pageList(formatWhere($where),$limit,$field,$orderby);
				    $list = $res['list'];
				    $data['rows']  = $list;
			        $data['total'] = $res['count'];
			        return json(htmlOutList($data));
			    }
				else
				{
				    mlog("card_index:".json_encode($lockdata));
				    return json(['status'=>'00','msg'=>'4002:该设备不支持刷卡功能']);
				}
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			
		}
	}

	/*查看数据*/
	function view(){
		$lockcard_id = $this->request->get('lockcard_id','','intval');
		if(!$lockcard_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockCardDb::getInfo($lockcard_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'lockcard_createtime,lockcard_remark,lockcard_username,lockcard_endtime,lockcard_sn,lock_id,user_id';
			$data = $this->request->only(explode(',',$postField),'post',null);
			//查询锁序列号
			$lockdata=\xhadmin\db\Lock::getInfo($data['lock_id']);
			try {
			    //执行添加卡到设备
			    $postdata['sn']=$lockdata['lock_sn'];
			    $postdata['cardsn']=$data['lockcard_sn'];
			    $postdata['endtime']=strtotime($data['lockcard_endtime']);
			    if ($lockdata['lock_sn']) 
			    {
			        mlog("card_data:".json_encode($postdata));
			        $result=wmjCardHandle($lockdata['lock_sn'],'addcard',$postdata);
			        
			        if ($result['state']) 
			        {
			            LockCardService::add($data);
			        }
				    else
				    {
				        return json(['status'=>'00','msg'=>$result['state_msg']]);
				    }
			    }
			    
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$lockcard_id = $this->request->get('lockcard_id','','intval');
			if(!$lockcard_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(LockCardDb::getInfo($lockcard_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'lockcard_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$lockcarddata=LockCardDb::getInfo($data['lockcard_id']);
			$lockdata=\xhadmin\db\Lock::getInfo($lockcarddata['lock_id']);
			try {
			    $postdata['sn']=$lockdata['lock_sn'];
			    $postdata['cardsn']=$data['lockcard_sn'];
			    $postdata['endtime']=strtotime($data['lockcard_endtime']);
			    if ($lockdata['lock_sn']) 
			    {
			        mlog("card_data:".json_encode($postdata));
			        $result=wmjCardHandle($lockdata['lock_sn'],'addcard',$postdata);
			        if ($result['state']) 
			        {
			            LockCardService::update($data);
			        }
				    else
				    {
				        return json(['status'=>'00','msg'=>$result['state_msg']]);
				    }
				   
			    }
			    
				
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>$result['state_msg']]);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('lockcard_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try
		{
		    $delcardarr = explode(',',$idx);
            for($index=0;$index<count($delcardarr);$index++)
            {
                //查询卡数据
                $lockcarddata=LockCardDb::getInfo($delcardarr[$index]);
                //查询锁信息
			    $lockdata=\xhadmin\db\Lock::getInfo($lockcarddata['lock_id']);
			    if ($lockdata['lock_sn']) 
			    {
			        $postdata['sn']=$lockdata['lock_sn'];
			        $postdata['cardsn']=$lockcarddata['lockcard_sn'];
			        $result=wmjCardHandle($lockdata['lock_sn'],'delcard',$postdata);
			        if ($result['state']) 
			        {
			            LockCardService::delete(['lockcard_id'=>$delcardarr[$index]]);
			        }
				    else
				    {
				        return json(['status'=>'00','msg'=>$result['state_msg']]);
				    }
                    
			    }
            }
			
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>$result['state_msg']]);
	}
/*end*/



}

