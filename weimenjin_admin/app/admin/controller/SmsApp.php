<?php
namespace app\admin\controller;

use app\module\model\UserSmsApp;
use app\module\model\RechargeRecord;
use think\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class SmsApp extends Admin
{
    private function getWxConfig(): array
    {
        $siteUrl = rtrim((string) config('my.siteconfig.siteurl'), '/');

        return [
            'appid' => config('my.wxmp.wxmp_appid'),
            'mchid' => config('my.wechart_pay.mch_id'),
            'key' => config('my.wechart_pay.key'),
            'appsecret' => config('my.wxmp.wxmp_appsecret'),
            'notify_url' => $siteUrl . '/webapi/SmsApi/paymentCallback',
        ];
    }

    function index(){
        $admin = session('admin');
        $user_id = $admin["user_id"];

        $userApp = UserSmsApp::where('user_id', $user_id)->find();

        if (!$userApp) {
            $data = [
                'user_id' => $user_id,
                'appid' => $this->generateAppId(),
                'appsecret' => $this->generateAppSecret(),
            ];

            try {
                UserSmsApp::create($data);
                $userApp = UserSmsApp::where('user_id', $user_id)->find();
            } catch (\Exception $e) {
                $this->error('生成失败: ' . $e->getMessage());
            }
        }

        $this->view->assign('smsapi', $userApp);
        $qrcode_url = $this->generateQrcodeUrl($userApp->appid, 100);
        $this->view->assign('qrcode_url', $qrcode_url);

        return $this->display('index');
    }

    public function generateQrcode(Request $request)
    {
        $amount = $request->post('amount');
        $appid = $request->post('appid');

        if (!$amount || !$appid) {
            return json(['status' => 'fail', 'message' => '缺少参数']);
        }

        $qrcode_url = $this->generateQrcodeUrl($appid, $amount);

        if ($qrcode_url) {
            return json(['status' => 'success', 'qrcode_url' => $qrcode_url]);
        } else {
            return json(['status' => 'fail', 'message' => '二维码生成失败']);
        }
    }

    private function generateQrcodeUrl($appid, $amount)
    {
        $wxConfig = $this->getWxConfig();
        $nonce_str = $this->generateNonceStr();
        $total_fee = $amount * 100; // 金额单位为分
        $out_trade_no = $appid . time(); // 生成唯一订单号

        $params = [
            'appid' => $wxConfig['appid'],
            'mch_id' => $wxConfig['mchid'],
            'nonce_str' => $nonce_str,
            'body' => '充值服务',
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee,
            'spbill_create_ip' => $this->getClientIp(),
            'notify_url' => $wxConfig['notify_url'],
            'trade_type' => 'NATIVE',
        ];

        $params['sign'] = $this->makeSign($params, $wxConfig['key']);

        // 调用微信统一下单API
        $xml = $this->arrayToXml($params);
        $response = $this->postXmlCurl($xml, 'https://api.mch.weixin.qq.com/pay/unifiedorder');
        $result = $this->xmlToArray($response);
        mlog("generateQrcodeUrl:" . json_encode($result));

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $code_url = $result['code_url'];

            // 生成二维码图片路径
            $qrcode_file = app()->getRootPath() . 'public/qrdata/qrpay/wxpay_qrcode_' . $out_trade_no . '.png';

            // 配置 QRCode 选项
            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'   => QRCode::ECC_L,
                'scale'      => 10,
            ]);

            try {
                // 生成二维码并保存到文件
                $qrcode = new QRCode($options);
                $qrcode->render($code_url, $qrcode_file);
            } catch (\Exception $e) {
                mlog("二维码生成失败: " . $e->getMessage());
                return false;
            }

            // 返回二维码图片的路径供前端显示
            return '/qrdata/qrpay/wxpay_qrcode_' . $out_trade_no . '.png';
        } else {
            return false;
        }
    }
    // 校验签名
    private function checkSign($data, $key)
    {
        $sign = $data['sign'];
        unset($data['sign']);
        $generatedSign = $this->makeSign($data, $key);
        return $sign === $generatedSign;
    }
    private function makeSign($params, $key)
    {
        ksort($params);
        $string = urldecode(http_build_query($params)) . '&key=' . $key;
        return strtoupper(md5($string));
    }

    private function generateNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getClientIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    private function xmlToArray($xml)
    {
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }

    private function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return false;
        }
    }
    /* 生成AppID */
    private function generateAppId()
    {
        $prefix = 'wmjapp_';
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $prefix . $randomString;
    }

    /* 生成AppSecret */
    private function generateAppSecret()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
