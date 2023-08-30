<?php

//生成微信小程序二维码
namespace utils\wechart;
use EasyWeChat\Factory;
use think\facade\Log;

class QrcodeService
{
	
	
	private static $qrcode_dir = './uploads/qrcode';
	
	/**
	 * 带参数的小程序二维码生成
	 * @param  array $data
	 * @param  data.width 二维码宽度
	 * @param  data.scene 二维码参数
	 * @param  data.page 小程序页面地址
	 * @param  data.filename 生成的图片文件名
	 * @return string  返回文件名   
	 */
	public static function createQrcode($data){
		$app = Factory::miniProgram(config('my.mini_program'));
		
		$width = empty($data['width']) ? $data['width'] : 600;
		$response = $app->app_code->getUnlimit($data['scene'], [
			'page'  => $data['page'],
			'width' => $width,
		]);

		// 保存小程序码到文件
		if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
			$filename = $response->saveAs(self::$qrcode_dir, 'code-'.$data['filename'].'.png');
			return $filename;
		}
	}
	
	
    
}
