<?php

namespace app\api\controller\device;

use app\api\controller\Base;
use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use app\module\member\memberServer\MemberServer;
use think\exception\ValidateException;

/**
 * 云喇叭定时播报控制器
 * 支持W70B/W70C/W70S云喇叭设备的定时播报功能
 */
class TtsSchedule extends Base
{
    /**
     * 获取所有定时播报任务
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
            "cmd_type" => "get_tts_schedules",
            "info" => [],
        ];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            return json(Code::CodeErr(1000, ($res["err"])));
        }
        return json(Code::CodeOk($res));
    }

    /**
     * 设置所有定时播报任务
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

        // 验证每个定时任务的字段
        foreach ($param['schedules'] as $index => $schedule) {
            if (!isset($schedule['enabled'])) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个任务缺少enabled字段"));
            }
            if (!isset($schedule['hour']) || $schedule['hour'] < 0 || $schedule['hour'] > 23) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个任务hour无效(0-23)"));
            }
            if (!isset($schedule['minute']) || $schedule['minute'] < 0 || $schedule['minute'] > 59) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个任务minute无效(0-59)"));
            }
            if (!isset($schedule['weekdays']) || $schedule['weekdays'] < 0 || $schedule['weekdays'] > 127) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个任务weekdays无效(0-127)"));
            }
            if (!isset($schedule['tts_text'])) {
                return json(Code::CodeErr(1000, "第" . ($index + 1) . "个任务缺少tts_text字段"));
            }
        }

        $sandData = [
            "cmd_type" => "set_tts_schedules",
            "info" => [
                "schedules" => $param['schedules']
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 50, 0, "设置定时播报失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 50, 1, "设置定时播报");
        return json(Code::CodeOk($res));
    }

    /**
     * 设置单个定时播报任务
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
                'index' => 'require|number|between:0,19',
                'hour' => 'require|number|between:0,23',
                'minute' => 'require|number|between:0,59',
                'weekdays' => 'require|number|between:0,127',
                'tts_text' => 'require|max:200',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "set_tts_schedule",
            "info" => [
                "index" => intval($param['index']),
                "enabled" => filter_var($param['enabled'], FILTER_VALIDATE_BOOLEAN),
                "hour" => intval($param['hour']),
                "minute" => intval($param['minute']),
                "weekdays" => intval($param['weekdays']),
                "tts_text" => $param['tts_text'],
                "speaker" => $param['speaker'] ?? 'prompt_female_high',
                "speed" => floatval($param['speed'] ?? 1.0),
                "repeat_count" => intval($param['repeat_count'] ?? 3),
                "number_mode" => $param['number_mode'] ?? 'digit',
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 51, 0, "设置定时播报任务" . ($param['index'] + 1) . "失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 51, 1, "设置定时播报任务" . ($param['index'] + 1));
        return json(Code::CodeOk($res));
    }

    /**
     * 清除单个定时播报任务
     * @return \think\response\Json
     */
    public function clearSchedule()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'index' => 'require|number|between:0,19',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $sandData = [
            "cmd_type" => "clear_tts_schedule",
            "info" => [
                "index" => intval($param['index']),
            ],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 52, 0, "清除定时播报任务" . ($param['index'] + 1) . "失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 52, 1, "清除定时播报任务" . ($param['index'] + 1));
        return json(Code::CodeOk($res));
    }

    /**
     * 清除所有定时播报任务
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
            "cmd_type" => "clear_all_tts_schedules",
            "info" => [],
        ];

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'], $sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, 53, 0, "清除所有定时播报失败");
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, 53, 1, "清除所有定时播报");
        return json(Code::CodeOk($res));
    }

    /**
     * 获取发音人列表
     * 根据设备序列号前缀返回支持的发音人列表
     * @return \think\response\Json
     */
    public function getSpeakers()
    {
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        } catch (ValidateException $e) {
            return json(Code::CodeErr(1000, $e->getError()));
        }

        $device_sn = $param['device_sn'];

        // 默认发音人列表（仅适用于W70B/W70R云喇叭设备）
        $speakers = [
            [
                'id' => 'prompt_female_high',
                'name' => '女声-高音',
                'description' => '系统',
                'default' => true
            ],
            [
                'id' => 'prompt_duoduo',
                'name' => '女声-多多',
                'description' => '默认女声发音人'
            ],
            [
                'id' => 'prompt_wenroutaotao',
                'name' => '桃桃-温柔',
                'description' => '默认女声发音人，音调温柔'
            ],
            [
                'id' => 'prompt_kunkun',
                'name' => '男声-坤坤',
                'description' => '系统'
            ],
            [
                'id' => 'prompt_bobo',
                'name' => '男声-优雅',
                'description' => '默认男声发音人，音调优雅'
            ],
            [
                'id' => 'prompt_ref_audio_02',
                'name' => '男声-搞怪',
                'description' => '默认男声发音人，音调搞怪'
            ]
        ];

        // 只有W70B和W70R支持选择发音人
        if (strpos($device_sn, 'W70B') === 0 || strpos($device_sn, 'W70R') === 0) {
            return json(Code::CodeOk([
                'speakers' => $speakers
            ]));
        }

        // 其他设备（包括W70C、W70S等）返回空列表
        return json(Code::CodeOk([
            'speakers' => []
        ]));
    }

    /**
     * 添加设备操作日志
     */
    private static function AddDeviceLog($device_sn, $member_id, $type, $status, $remark = '')
    {
        try {
            $lockInfo = Lock::InfoWLockSn($device_sn);
            if ($lockInfo) {
                \app\module\lockServer\LockLog::add([
                    'type' => $type,
                    'user_id' => $lockInfo['user_id'],
                    'member_id' => $member_id,
                    'lock_id' => $lockInfo['lock_id'],
                    'status' => $status,
                    'remark' => $remark
                ]);
            }
        } catch (\Exception $e) {
            // 日志记录失败不影响主流程
        }
    }
}
