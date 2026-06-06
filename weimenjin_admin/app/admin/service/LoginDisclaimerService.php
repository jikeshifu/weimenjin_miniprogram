<?php

namespace app\admin\service;

use think\facade\Db;

class LoginDisclaimerService
{
    public static function defaultContent(): string
    {
        return "开源免责声明\n"
            . "本开源版本仅用于学习、研究、演示和二次开发参考，不承诺适用于任何特定业务场景。使用者应自行评估系统功能、数据安全、网络安全、设备兼容性和合规要求。\n"
            . "因部署、配置、修改、使用本系统或与第三方硬件、云服务、支付、短信、微信接口等集成产生的任何故障、数据丢失、资损、业务中断、法律责任或其他损失，由使用者自行承担。\n"
            . "正式商用、生产部署或接入真实门禁设备前，请完成充分测试、权限隔离、数据备份、安全加固和合规审查。\n\n"
            . "门禁及远程控制设备免责声明\n"
            . "门禁、开门、摄像头、继电器、开关等远程控制设备涉及人员通行、财产安全和现场设备状态。使用者应确保设备安装、供电、联网、权限分配、日志审计和应急处置符合实际场景要求。\n"
            . "远程开门、批量授权、设备重绑、摄像头控制等操作可能受到网络延迟、设备离线、云服务异常、权限配置错误、人员误操作等因素影响。由此产生的通行风险、设备误动作、现场安全事件或业务损失，由使用者自行承担。\n"
            . "请勿将本系统作为唯一安全保障手段。正式使用前应建立线下核验、人工复核、备用通行、权限回收、数据备份和安全巡检机制。";
    }

    public static function content(): string
    {
        try {
            $value = Db::name('appconfig')
                ->where(['module' => 'login', 'name' => 'disclaimer_content'])
                ->value('value');
            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        } catch (\Throwable $e) {
        }

        $configured = (string) config('my.login.disclaimer_content', '');
        return trim($configured) !== '' ? $configured : self::defaultContent();
    }

    public static function html(): string
    {
        return nl2br(htmlspecialchars(self::content(), ENT_QUOTES, 'UTF-8'), false);
    }
}
