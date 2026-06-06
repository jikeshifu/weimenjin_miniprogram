<?php

namespace app\api\controller\device;

use app\api\controller\Base;
use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use app\module\lockServer\LockLog;
use app\module\member\memberServer\MemberServer;
use think\exception\ValidateException;
use think\facade\Db;

/**
 * W71空开断路器控制器
 * 支持计划任务（定时开关）功能
 */
class W71Switch extends Base
{
    /**
     * 获取设备状态
     * @return \think\response\Json
     */
    public function getStatus()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "getdevinfo",
            "info" => [],
        ];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            return json(Code::CodeErr(1000, ($res["err"])));
        }
        return json(Code::CodeOk($res));
    }

    /**
     * 开启空开
     * @return \think\response\Json
     */
    public function turnOn()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "turnon",
            "info" => [],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 41, 0);
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        // 检查是否被计划任务控制
        if (isset($res["data"]["info"]["code"]) && $res["data"]["info"]["code"] == 2) {
            self::AddDeviceLog($param['device_sn'], $member_id, 41, 0, "被计划任务控制");
        } else {
            self::AddDeviceLog($param['device_sn'], $member_id, 41, 1);
        }

        return json(Code::CodeOk($res));
    }

    /**
     * 关闭空开
     * @return \think\response\Json
     */
    public function turnOff()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "turnoff",
            "info" => [],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 42, 0);
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        // 检查是否被计划任务控制
        if (isset($res["data"]["info"]["code"]) && $res["data"]["info"]["code"] == 2) {
            self::AddDeviceLog($param['device_sn'], $member_id, 42, 0, "被计划任务控制");
        } else {
            self::AddDeviceLog($param['device_sn'], $member_id, 42, 1);
        }

        return json(Code::CodeOk($res));
    }

    /**
     * 获取所有计划任务
     * @return \think\response\Json
     */
    public function getSchedules()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "get_schedules",
            "info" => [],
        ];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            return json(Code::CodeErr(1000, ($res["err"])));
        }
        return json(Code::CodeOk($res));
    }

    /**
     * 设置所有计划任务
     * @return \think\response\Json
     */
    public function setSchedules()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'schedules' => 'require|array',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        // 验证每个计划任务的字段
        foreach ($param['schedules'] as $index => $schedule) {
            if (!isset($schedule['enabled'])) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务缺少enabled字段"));
            }
            if (!isset($schedule['start_hour']) || $schedule['start_hour'] < 0 || $schedule['start_hour'] > 23) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务start_hour无效(0-23)"));
            }
            if (!isset($schedule['start_minute']) || $schedule['start_minute'] < 0 || $schedule['start_minute'] > 59) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务start_minute无效(0-59)"));
            }
            if (!isset($schedule['end_hour']) || $schedule['end_hour'] < 0 || $schedule['end_hour'] > 23) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务end_hour无效(0-23)"));
            }
            if (!isset($schedule['end_minute']) || $schedule['end_minute'] < 0 || $schedule['end_minute'] > 59) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务end_minute无效(0-59)"));
            }
            if (!isset($schedule['weekdays']) || $schedule['weekdays'] < 0 || $schedule['weekdays'] > 127) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务weekdays无效(0-127)"));
            }
            if (!isset($schedule['action']) || ($schedule['action'] != 0 && $schedule['action'] != 1)) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个计划任务action无效(0或1)"));
            }
        }

        $sandData = [
            "cmd_type" => "set_schedules",
            "info" => [
                "schedules" => $param['schedules']
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 43, 0, "设置计划任务失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 43, 1, "设置计划任务");
        return json(Code::CodeOk($res));
    }

    /**
     * 设置单个计划任务
     * @return \think\response\Json
     */
    public function setSchedule()
    {
        $param = request()->post();

        // enabled 字段特殊处理，因为 false 值会被 require 验证视为空
        if (!isset($param['enabled'])) {
            return json(Code::CodeErr(1000, 'enabled不能为空'));
        }

        try {
            validate([
                'device_sn' => 'require',
                'index' => 'require|number|between:0,9',
                'start_hour' => 'require|number|between:0,23',
                'start_minute' => 'require|number|between:0,59',
                'end_hour' => 'require|number|between:0,23',
                'end_minute' => 'require|number|between:0,59',
                'weekdays' => 'require|number|between:0,127',
                'action' => 'require|in:0,1',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "set_schedule",
            "info" => [
                "index" => intval($param['index']),
                "enabled" => filter_var($param['enabled'], FILTER_VALIDATE_BOOLEAN),
                "start_hour" => intval($param['start_hour']),
                "start_minute" => intval($param['start_minute']),
                "end_hour" => intval($param['end_hour']),
                "end_minute" => intval($param['end_minute']),
                "weekdays" => intval($param['weekdays']),
                "action" => intval($param['action']),
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 43, 0, "设置计划任务" . ($param['index'] + 1) . "失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 43, 1, "设置计划任务" . ($param['index'] + 1));
        return json(Code::CodeOk($res));
    }

    /**
     * 清除单个计划任务
     * @return \think\response\Json
     */
    public function clearSchedule()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'index' => 'require|number|between:0,9',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "clear_schedule",
            "info" => [
                "index" => intval($param['index']),
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 44, 0, "清除计划任务" . ($param['index'] + 1) . "失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 44, 1, "清除计划任务" . ($param['index'] + 1));
        return json(Code::CodeOk($res));
    }

    /**
     * 清除所有计划任务
     * @return \think\response\Json
     */
    public function clearAllSchedules()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "clear_all_schedules",
            "info" => [],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 44, 0, "清除所有计划任务失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 44, 1, "清除所有计划任务");
        return json(Code::CodeOk($res));
    }

    /**
     * 添加操作记录
     * @param string $device_sn 设备SN
     * @param int $member_id 用户ID
     * @param int $type 操作类型：41=开启空开，42=关闭空开，43=设置计划任务，44=清除计划任务
     * @param int $status 操作结果：1成功，0失败
     * @param string $remark 备注
     */
    static function AddDeviceLog($device_sn, $member_id, $type, $status = 1, $remark = "")
    {
        $device = Db::name('lock')
            ->where('lock_sn', $device_sn)
            ->whereNull("deleted_at")
            ->find();

        if (!$device) {
            return;
        }

        LockLog::add($member_id, $device["lock_id"], $type, $status, "", "", "", "", $remark);
    }
}
