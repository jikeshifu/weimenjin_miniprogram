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

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
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
		$postField = 'member_id,user_id,regpointname,lock_id,regpointurl,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		$url = $this->request->param('regpointurl').$this->request->param('user_id');
		//$url = 'https://your-domain.example/qrdata/qrcode/大地.png';
		$qrcodename = $this->request->param('regpointname');
		//$name ='dddddd';
		try {
			$res = RegpointService::add($data);
			if ($res) {
				$regpoint_id=$res;
				$url = $this->request->param('regpointurl').$this->request->param('user_id')."&regpoint_id=".$regpoint_id."&lock_id=".$data['lock_id'];
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
		$url='https://your-domain.example/qrdata/qrcode/%E5%B0%8F%E5%8C%BA%E9%97%A8%E5%8F%A3.png';
		$qrcodename='测试567';
		return $this->createmarkqrcode($url,$qrcodename);
	}
    //创建带文字下标的二维码图片
    /**
     * 生成带文字的二维码
     *
     * @param string $url 二维码包含的URL
     * @param string $qrcodename 二维码下方显示的文字
     * @return string|false 返回二维码图片的完整URL，失败返回false
     */
    function createmarkqrcode($url, $qrcodename)
    {
        // 定义二维码存储路径
        $path = app()->getRootPath() . 'public/qrdata/qrcode/';

        // 确保目录存在，如果不存在则尝试创建
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true)) {
                error_log("二维码目录创建失败: " . $path);
                return false;
            }
        }

        // 生成唯一文件名
        $file = time() . '.png';
        $qrcode_file = $path . $file;

        // 检查二维码文件是否已存在，避免重复生成
        if (!is_file($qrcode_file)) {
            // 配置 QRCode 选项
            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG, // 输出类型为 PNG 图片
                'eccLevel'   => QRCode::ECC_L,          // 容错级别为低
                'scale'      => 10,                      // 缩放比例
            ]);

            try {
                // 生成二维码对象
                $qrcode = new QRCode($options);

                // 生成二维码并保存到文件
                $qrcode->render($url, $qrcode_file);
            } catch (\Exception $e) {
                error_log("二维码生成失败: " . $e->getMessage());
                return false;
            }
        }

        // 如果有文字需要添加到二维码上
        if ($qrcodename) {
            $font = app()->getRootPath() . 'public/qrdata/simhei.ttf';

            // 验证字体文件是否存在
            if (!file_exists($font)) {
                error_log("二维码生成失败: 字体文件不存在 - " . $font);
                return false;
            }

            $size = 14; // 字体大小

            // 计算文字的宽度和高度
            $box = @imagettfbbox($size, 0, $font, $qrcodename);
            if (!$box) {
                error_log("二维码生成失败: 无法计算文字尺寸 - " . $qrcodename);
                return false;
            }
            $fontw = abs($box[4] - $box[0]); // 文字宽度
            $fonth = abs($box[5] - $box[1]); // 文字高度

            // 创建二维码图像资源
            $im = imagecreatefrompng($qrcode_file);
            if (!$im) {
                error_log("二维码生成失败: 无法创建图像资源 - " . $qrcode_file);
                return false;
            }

            // 获取二维码图片的尺寸
            $info = getimagesize($qrcode_file);
            $imgw = $info[0]; // 图片宽度
            $imgh = $info[1] + $fonth + 10; // 图片高度加上文字高度和间距

            // 创建新的空白图像（使用 imagecreatetruecolor 提供更好的图像质量）
            $img = imagecreatetruecolor($imgw, $imgh);
            if (!$img) {
                error_log("二维码生成失败: 无法创建新的图像");
                imagedestroy($im);
                return false;
            }

            // 设置背景为白色
            $white = imagecolorallocate($img, 255, 255, 255);
            imagefill($img, 0, 0, $white);

            // 设置文字颜色为黑色
            $black = imagecolorallocate($img, 0, 0, 0);

            // 计算文字的X坐标，使其居中
            $fontx = 10; // 默认文字距离图片左侧的距离
            if ($imgw > $fontw) {
                $fontx = ceil(($imgw - $fontw) / 2); // 居中对齐
            }

            // 在新图像上添加文字
            imagettftext($img, $size, 0, $fontx, ($info[1] + $fonth), $black, $font, $qrcodename);

            // 合并二维码图像到新图像
            if (!imagecopymerge($img, $im, 0, 0, 0, 0, $imgw, $info[1], 100)) {
                error_log("二维码生成失败: 无法合并图像");
                imagedestroy($im);
                imagedestroy($img);
                return false;
            }

            // 保存最终的二维码图像
            if (!imagepng($img, $qrcode_file)) {
                error_log("二维码生成失败: 无法保存最终的二维码图像 - " . $qrcode_file);
                imagedestroy($im);
                imagedestroy($img);
                return false;
            }

            // 释放内存
            imagedestroy($im);
            imagedestroy($img);
        }

        // 返回二维码图片的完整URL
        return 'https://' . $_SERVER['HTTP_HOST'] . '/qrdata/qrcode/' . $file;
    }
	/*end*/



}
