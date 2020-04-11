<?php 
/*
 module:		登记点管理
 create_time:	2020-02-24 01:20:15
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\RegpointService;
use xhadmin\db\Regpoint as RegpointDb;
use think\facade\Cache;
use think\facade\Log;

class Regpoint extends Common {


	/**
	* @api {post} /Regpoint/update 01、修改
	* @apiGroup Regpoint
	* @apiVersion 1.0.0
	* @apiDescription  修改
	
	* @apiParam (输入参数：) {string}     		regpoint_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			member_id 会员ID 
	* @apiParam (输入参数：) {string}			user_id 用户ID 
	* @apiParam (输入参数：) {string}			regpointname 名称 
	* @apiParam (输入参数：) {string}			regpointurl 注册点url 
	* @apiParam (输入参数：) {string}			create_time 创建时间 

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
		$postField = 'regpoint_id,member_id,user_id,regpointname,regpointurl,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['regpoint_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
			$where['regpoint_id'] = $data['regpoint_id'];
			$res = RegpointService::update($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /Regpoint/delete 02、删除
	* @apiGroup Regpoint
	* @apiVersion 1.0.0
	* @apiDescription  删除

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}     		regpoint_ids 主键id 注意后面跟了s 多数据删除

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
		$idx =  $this->request->post('regpoint_ids', '', 'serach_in');
		if(empty($idx)) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try{
			$data['regpoint_id'] = explode(',',$idx);
			RegpointService::delete($data);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>'操作失败']);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /Regpoint/view 03、查看数据
	* @apiGroup Regpoint
	* @apiVersion 1.0.0
	* @apiDescription  查看数据
	
	* @apiParam (输入参数：) {string}     		regpoint_id 主键ID

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
		$data['regpoint_id'] = $this->request->post('regpoint_id','','intval');
		try{
			$field='regpoint_id,member_id,user_id,regpointname,regpointurl,create_time';
			$res  = checkData(RegpointDb::getWhereInfo($data,$field));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}

 /*start*/
	/**
	* @api {post} /Regpoint/add 01、添加
	* @apiGroup Regpoint
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			member_id 会员ID 
	* @apiParam (输入参数：) {string}			user_id 用户ID 
	* @apiParam (输入参数：) {string}			regpointname 名称 
	* @apiParam (输入参数：) {string}			regpointurl 注册点url 

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
		$postField = 'member_id,user_id,regpointname,regpointurl,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		$url = $this->request->param('regpointurl').$this->request->param('user_id');
		//$url = 'https://wxapp.wmj.com.cn/qrdata/qrcode/大地.png';
		$qrcodename = $this->request->param('regpointname');
		//$name ='dddddd';
		try {
			$res = RegpointService::add($data);
			if ($res) {
				$regpoint_id=$res;
				$url = $this->request->param('regpointurl').$this->request->param('user_id')."&regpoint_id=".$regpoint_id;
				$data['regpointqrcode'] = $this->createmarkqrcode($url,$qrcodename);
				$where['regpoint_id'] = $regpoint_id;
				$ret = RegpointService::update($where,$data);
			}
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}
    /*end*/

 /*start*/
	/**
	* @api {post} /Regpoint/index 01、登记点列表
	* @apiGroup Regpoint
	* @apiVersion 1.0.0
	* @apiDescription  登记点管理

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {string}		[member_id] 会员ID 
	* @apiParam (输入参数：) {string}		[user_id] 用户ID 
	* @apiParam (输入参数：) {string}		[regpointname] 名称 
	* @apiParam (输入参数：) {string}		[regpointurl] 注册点url 
	* @apiParam (输入参数：) {string}		[create_time_start] 创建时间开始
	* @apiParam (输入参数：) {string}		[create_time_end] 创建时间结束

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
	function index(){
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');

		$where = [];
		$where['member_id'] = $this->request->post('member_id', '', 'serach_in');
		$where['user_id'] = $this->request->post('user_id', '', 'serach_in');
		$where['regpointname'] = $this->request->post('regpointname', '', 'serach_in');
		$where['regpointurl'] = $this->request->post('regpointurl', '', 'serach_in');

		$create_time_start = $this->request->post('create_time_start', '', 'serach_in');
		$create_time_end = $this->request->post('create_time_end', '', 'serach_in');

		$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'regpoint_id desc';

		try{
			if ($this->request->param('user_id')==0) {
				return json(['status'=>'201','msg'=>'没有登记点']);
			} else {
				$res = RegpointService::pageList(formatWhere($where),$limit,$field,$orderby);
			}
			
			
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
    /*end*/

 /*start*/
   function creatqrcode()
	{
		$url='https://wxapp.wmj.com.cn/qrdata/qrcode/%E5%B0%8F%E5%8C%BA%E9%97%A8%E5%8F%A3.png';
		$qrcodename='测试567';
		return $this->createmarkqrcode($url,$qrcodename);
	}
    //创建带文字下标的二维码图片
	function createmarkqrcode($url, $qrcodename)
	{
		//$background = app()->getRootPath().'public/qrdata/back.png';
        //$logo = app()->getRootPath().'public/qrdata/logo.png';
		$path = app()->getRootPath().'public/qrdata/qrcode/';
		
        $file = time(). '.png';
		$qrcode_file = $path . $file;
		
		if (!(is_file($qrcode_file))){
			//vendor("phpqrcode.phpqrcode");
			require_once app()->getRootPath().'/vendor/phpqrcode/phpqrcode.php';
			$object = new \QRcode();
			//$object->png($url, $qrcode_file, QR_ECLEVEL_L, 10);
			$object->png($url, $qrcode_file, QR_ECLEVEL_L, 10);
			//print_r('11111111111');
		}
		/*
        $im = imagecreate(60,20);
        $backcc = imagecolorallocate($im,255,255,255);
        $bl = imagecolorallocate($im,0,0,0);
        $image = imagecreatefrompng($qrcode_file);  
        $font=app()->getRootPath().'public/qrdata/simhei.ttf'; 
        imagettftext($image, 21, 0, 120, 440, $bl, $font, $qrcodename);
        imagepng($image,$qrcode_file);
        imagedestroy($image);
        */
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
		return 'https://wxapp.wmj.com.cn/qrdata/qrcode/'.$file;	
	}
	/*end*/



}

