<?php
namespace app\webapi\controller;

use app\module\model\UserSmsApp;
use app\module\model\RechargeRecord;
use think\Request;
use think\response\Json;

class Recharge
{
    // 处理充值请求
    public function processRecharge(Request $request): Json
    {
        $data = $request->post();

        // 验证AppID和金额
        if (!$data['appid'] || !$data['amount']) {
            return json(['status' => 'fail', 'message' => 'Missing required parameters'], 400);
        }

        $userApp = UserSmsApp::where('appid', $data['appid'])->find();
        if (!$userApp) {
            return json(['status' => 'fail', 'message' => 'Invalid AppID'], 401);
        }

        // 更新用户的余额
        $userApp->balance += $data['amount'];
        $userApp->save();

        // 记录充值日志
        RechargeRecord::create([
            'appid' => $data['appid'],
            'amount' => $data['amount'],
            'status' => 'completed', // 或者 'pending' 视具体情况而定
        ]);

        return json(['status' => 'success', 'message' => 'Recharge successful']);
    }
}
