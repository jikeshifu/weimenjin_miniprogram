<?php
namespace app\admin\controller;

use app\module\model\UserSmsApp;
use app\module\model\RechargeRecord;
use think\Request;

class ApiUserApp extends Admin
{
    function initialize()
    {
        // 权限检查，确保只有超级管理员可以访问
        if (session('admin.role') <> 1) {
            $this->error('你没有操作权限');
        }
    }

    /*接口用户管理列表*/
    public function index(Request $request)
    {
        if (!$request->isAjax()) {
            return $this->display('index');
        } else {
            // 获取并强制转换为整数
            $limit = $request->post('limit', 20, 'intval');  // 设置默认每页 20 条
            $offset = $request->post('offset', 0, 'intval'); // 偏移量默认为 0

            // 计算当前页数
            $page = floor($offset / $limit) + 1;

            // 定义查询条件
            $where = [];

            // 条件查询
            if ($appid = $request->param('appid', '', 'serach_in')) {
                $where['appid'] = ['like', "$appid"];
            }

            // 字段和排序方式
            $field = 'id,user_id,appid,appsecret,balance,created_at';
            $orderby = 'id desc';

            try {
                // 使用 offset 和 limit 正确地传递整数
                $res = UserSmsApp::where($where)
                    ->field($field)
                    ->order($orderby)
                    ->limit($offset, $limit)  // 这里直接传入整数
                    ->select()
                    ->toArray();

                // 获取总数
                $total = UserSmsApp::where($where)->count();
            } catch (\Exception $e) {
                return json(['status' => 'fail', 'message' => $e->getMessage()]);
            }

            // 返回数据
            $data['rows'] = $res;
            $data['total'] = $total;
            return json($data);  // 返回 JSON 对象
        }
    }

    /*充值页面*/
    public function recharge(Request $request)
    {
        $user_id = $request->get('user_id');
        $this->view->assign('user_id', $user_id); // 传递 user_id 给视图
        return $this->display('recharge'); // 加载充值页面视图
    }

    /*执行充值操作*/
    public function dorecharge(Request $request)
    {
        $user_id = $request->post('user_id');
        $amount = $request->post('amount');
        $userApp = UserSmsApp::where('user_id', $user_id)->find();
        if ($userApp) {
            $userApp->balance += $amount;
            $userApp->save();

            // 记录充值日志
            $record = new RechargeRecord();
            $record->appid = $userApp->appid;
            $record->amount = $amount;
            $record->transaction_id = uniqid(); // 生成唯一的交易ID
            $record->status = 'success';
            $record->save();

            return json(['status' => 'success', 'message' => '充值成功', 'balance' => number_format($userApp->balance, 2)]);
        }

        return json(['status' => 'fail', 'message' => '用户不存在']);
    }
}
