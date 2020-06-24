<?php 
/*
 module:		卡管理
 create_time:	2020-05-05 02:19:54
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockCardService;
use xhadmin\db\LockCard as LockCardDb;

class LockCard extends Admin {



/*start*/
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
			$where['lockcard_remark'] = ['like',$this->request->param('lockcard_remark', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'lockcard_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'lockcard_id desc';
            $lockdata=\xhadmin\db\Lock::getInfo($lock_id);
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

