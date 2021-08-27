<?php 
/*
 module:		门锁列表
 create_time:	2021-08-02 17:58:07
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockService;
use xhadmin\db\Lock as LockDb;

class Lock extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['updateExt','update','delete','view','opendoor'])){
			$id = $this->request->param('lock_id','','intval');
			$ids = $this->request->param('lock_ids','','intval');
			if($id){
				$info = LockDb::getInfo($id);
				if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
			}
			if($ids){
				foreach(explode(',',$ids) as $v){
					$info = LockDb::getInfo($v);
					if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
				}
			}
		}
	}
	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$postField = 'lock_id,mobile_check,applyauth,applyauth_check,status,hitshowminiad,openbtn,qrshowminiad,opsucnt';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['lock_id']) $this->error('参数错误');
		try{
			LockDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$lock_id = $this->request->get('lock_id','','intval');
		if(!$lock_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockDb::getInfo($lock_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*导出*/
	function dumpData(){
		$where = [];
		if(session('admin.role') <> 1){
			$where['user_id'] = session('admin.user_id');
		}
		$where['lock_name'] = ['like',$this->request->param('lock_name', '', 'serach_in')];
		$where['lock_sn'] = $this->request->param('lock_sn', '', 'serach_in');
		$where['location_check'] = $this->request->param('location_check', '', 'serach_in');
		$where['status'] = $this->request->param('status', '', 'serach_in');
		$where['online'] = $this->request->param('online', '', 'serach_in');
		$where['lock_id'] = ['in',$this->request->param('lock_id', '', 'serach_in')];

		$orderby = '';

		try {
			//此处读取前端传过来的 表格勾选的显示字段
			$fieldInfo = [];
			for($j=0; $j<100;$j++){
				$fieldInfo[] = $this->request->param($j);
			}
			$res = LockService::dumpData(formatWhere($where),$orderby,filterEmptyArray(array_unique($fieldInfo)));
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

 /*start*/
	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$lock_id = $this->request->get('lock_id','','intval');
			if(!$lock_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(LockDb::getInfo($lock_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'lock_id,user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,location_check,online,qrshowminiad,hitshowminiad,lock_qrcode,create_time,openbtn,successimg,successadimg,openadurl,adnum,opsucnt';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				//mlog("updatelock_data:".json_encode($data));
				//删除之前生成的二维码
				$arr = parse_url($data['lock_qrcode']);
				$urlarr = pathinfo($arr['path']);
				$path = app()->getRootPath().'public/qrdata/qrcode/';
				$qrcodename = $urlarr['basename'];
				$qrcodefile=$path.$qrcodename;
				if (!unlink($qrcodefile)) 
				{
					mlog("updatelock_lock_qrcode_delete_fail:".json_encode($urlarr['basename']));
				}
				//更新时session值没传回，用Lock_id去数据库查一下user_id
				mlog("updatelock_lock_qrcode_basename:".json_encode($urlarr['basename']));
				
				$lockdata=LockDb::getInfo($data['lock_id']);
				$qrcodeurl="https://".$_SERVER['HTTP_HOST']."/minilock?"."user_id=".$lockdata['user_id']."&lock_id=".$data['lock_id'];
				//mlog("updatelock_data_user_id:".json_encode($lockdata['user_id']));
				$data['lock_qrcode'] = $this->createmarkqrcode($qrcodeurl,$data['lock_name']);
				LockService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
 /*end*/

 /*start*/
    
    /*门锁管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			if(session('admin.role') <> 1){
				$where['user_id'] = session('admin.user_id');
			}
			$where['lock_name'] = ['like',$this->request->param('lock_name', '', 'serach_in')];
			$where['lock_sn'] = ['like',$this->request->param('lock_sn', '', 'serach_in')];
			$where['mobile_check'] = $this->request->param('mobile_check', '', 'serach_in');
			$where['applyauth'] = $this->request->param('applyauth', '', 'serach_in');
			$where['applyauth_check'] = $this->request->param('applyauth_check', '', 'serach_in');
			$where['status'] = $this->request->param('status', '', 'serach_in');
			$where['lock_type'] = $this->request->param('lock_type', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			$where['online'] = $this->request->param('online', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'lock_id,user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,location_check,create_time,lock_qrcode,online,successimg,successadimg,adnum,opsucnt';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'lock_id desc';

			try{
				$res = LockService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
				foreach($list as $key => $value) 
				{
				    if ($list[$key]['lock_type']==7) 
				    {
				        $result = wmjgwHandle($value['lock_sn'], 'getlplockstate');
				        mlog("wmjgwHandle:".json_encode($result));
			            $list[$key]['online']       = $result['online'];
				    }
			        else
			        {
			            $result = wmjHandle($value['lock_sn'], 'lockstate');
			            $list[$key]['online']       = $result['online'];
			        }
                }
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}
	
     /*删除*/
	function delete(){
		$idx =  $this->request->post('lock_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$ids=explode(',',$idx);
			$num=count($ids);
			//删除之前生成的二维码
			
			for ($i = 0; $i < $num; $i++) 
			{
				$lock_data=LockDb::getInfo($ids[$i]);
				//删除之前生成的二维码
				$arr = parse_url($lock_data['lock_qrcode']);
				$urlarr = pathinfo($arr['path']);
				$path = app()->getRootPath().'public/qrdata/qrcode/';
				$qrcodename = $urlarr['basename'];
				$qrcodefile=$path.$qrcodename;
				if (!unlink($qrcodefile)) 
				{
					mlog("updatelock_lock_qrcode_delete_fail:".json_encode($urlarr['basename']));
				}
				$wmjapiresult = wmjHandle($lock_data['lock_sn'],'dellock');
				if ($wmjapiresult['state']) 
				{
					LockService::delete(['lock_id'=>explode(',',$idx)]);
					$ret = \xhadmin\service\admin\LockAuthService::delete(['lock_id'=>explode(',',$idx)]);
				}
				else 
				{
				 LockService::delete(['lock_id'=>explode(',',$idx)]);
				 $ret = \xhadmin\service\admin\LockAuthService::delete(['lock_id'=>explode(',',$idx)]);
				 return json(['status'=>'00','msg'=>$wmjapiresult['state_msg']]);
				}
			}
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
    
	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,lock_qrcode,location_check,hitshowminiad,qrshowminiad,successimg,openbtn,successadimg,openadurl,adnum,opsucnt,create_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
			    $lockmap['lock_sn']=$data['lock_sn'];
		        //根据锁sn拿到锁信息,根据会员id拿到会员信息，根据会员id和锁id拿到钥匙信息
		        $reslookdata=LockDb::getWhereInfo($lockmap);
		        if ($reslookdata) 
		        {
		            return json(['status'=>'00','msg'=>'设备已添加过']);
		        }
				//mlog("WMJSN:".$data['lock_sn']);
				if ($data['lock_type']==7)
				{
				    $wmjapiresult = wmjgwHandle($data['lock_sn'],'reggwlock');
				}
				else
				{
				    $wmjapiresult = wmjHandle($data['lock_sn'],'postlock');
				}
				if ($wmjapiresult['state']) 
				{
						$res = LockService::add($data);
						if ($res)
						{
							$lock_id=$res;
							$lockdata=LockDb::getInfo($lock_id);
							$qrcodeurl="https://".$_SERVER['HTTP_HOST']."/minilock?"."user_id=".$lockdata['user_id']."&lock_id=".$lock_id;
							$data['lock_qrcode'] = $this->createmarkqrcode($qrcodeurl,$lockdata['lock_name']);
							$where['lock_id'] = $lock_id;
							$ret = LockService::updatewhere($where,$data);
							//给自己添加钥匙
							$authdata['lock_id']=$res;
							//查询会员id
							//mlog("admin.session('admin.user_id'):".session('admin.user_id'));
							$rem = \xhadmin\db\User::getInfo(session('admin.user_id'));
							//mlog("admin.user_id:".$rem['member_id']);
							
							$authdata['member_id']=$rem['member_id'];
							$authdata['auth_member_id']=0;
							$authdata['auth_shareability']=1;
							$authdata['auth_sharelimit']=0;
							$authdata['auth_openlimit']=0;
							$authdata['auth_status']=1;
							//$authdata['auth_starttime']= null;
							//$authdata['auth_endtime']= null;
							//mlog("auth_starttime:".$authdata['auth_starttime']);
							//mlog("auth_endtime".$authdata['auth_endtime']);
							$authdata['auth_isadmin']=1;
							$authdata['user_id']=session('admin.user_id');
							//mlog("auth_endtime".json_encode($authdata));
							$ret = \xhadmin\service\admin\LockAuthService::lockadd($authdata);
						}
				}
				else {
				return json(['status'=>'00','msg'=>$wmjapiresult['state_msg']]);
				}
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}
/*开门*/

	function opendoor(){
		if (!$this->request->isPost()){
			$lock_id = $this->request->get('lock_id','','intval');
			if(!$lock_id) $this->error('lock_id不能为空');
			//根据锁id拿到锁信息
			$reslookdata=LockDb::getInfo($lock_id);
			mlog("opendoor_reslookdata:".json_encode($reslookdata));
			try{
				
				if ($reslookdata) 
				{
				    if ($reslookdata['lock_type']==7) 
				    {
				        $result = wmjgwHandle($reslookdata['lock_sn'], 'ctrlgwl');
				    } 
				    else 
				    {
				        $result = wmjHandle($reslookdata['lock_sn'], 'openlock');
				    }
					$data['user_id']=$reslookdata['user_id'];
					$data['lock_id']=$lock_id;
					$data['type']=3;
					$data['remark']=$result['state_msg'];
					if ($result['state'])
					{
						$data['status']=1;
						$rel=\xhadmin\service\admin\LockLogService::add($data);
						return json(['status'=>'00','msg'=>$result['state_msg']]);
					}
					else {
						$data['status']=0;
						$rel=\xhadmin\service\admin\LockLogService::add($data);
						return json(['status'=>'00','msg'=>$result['state_msg']]);
					}
				}
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
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

