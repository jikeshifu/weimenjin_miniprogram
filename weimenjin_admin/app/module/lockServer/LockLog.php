<?php


namespace app\module\lockServer;


use think\facade\Db;

class LockLog
{
    private static $hasMobileBakColumn = null;

    private static function canWriteMobileBak()
    {
        if (self::$hasMobileBakColumn !== null) {
            return self::$hasMobileBakColumn;
        }
        try {
            $prefix = config('database.connections.mysql.prefix') ?: '';
            $rows = Db::query("SHOW COLUMNS FROM `{$prefix}locklog` LIKE 'mobile_bak'");
            self::$hasMobileBakColumn = !empty($rows);
        } catch (\Exception $e) {
            self::$hasMobileBakColumn = false;
        }
        return self::$hasMobileBakColumn;
    }

    static $type = [
        "0" => '',
        "1" => '扫码开门',
        "2" => '点击开门',
        "3" => '后台开门',
        "4" => '刷卡开门',
        "5" => '点击开电',
        "6" => '点击关电',
        "7" => '指纹开门',
        "8" => '蓝牙开门',
        "9" => '喇叭操作',
        "10" => '生成钥匙',
        "11" => '刷脸开门',
        "12" => '密码开门',
        "13" => '点击开',
        "14" => '点击关',
        "15" => '点击停',
        "16" => '联动开电',
        "17" => '联动关电',
        "18" => '联动播报',
        "19" => '开锁止',
        "20" => '关锁止',
        "21" => '停锁止',
        "22" => "摄像头-向上",
        "23" => "摄像头-向下",
        "24" => "摄像头-向左",
        "25" => "摄像头-向右",
        "26" => "画面旋转",
        "27" => "自动夜视",
        "28" => "遥控器学习",
        "29" => "设置夜视",
        "30" => "设备重启",
        "31" => "添加遥控器",
        "32" => "删除遥控器",
        "33" => "语音设置",
        "34" => "遥控器学习",
        "35" => "格式化SD卡",
        "36" => "应用配置修改",
        "37" => "继电器延时设置",
        "38" => "继电器模式设置",
        "39" => "开启",
        "40" => "关闭",
        "41" => "手动开启",
        "42" => "手动关闭",
        "43" => "定时开启",
        "44" => "定时关闭",
        "50" => "设置定时播报",
        "51" => "设置播报任务",
        "52" => "清除播报任务",
        "53" => "清除全部播报",
    ];

    static function add($member_id, $lock_id, $type, $status = 1,$user_name="",$user_id="",$cpurl="",$cardsn="",$remark="")
    {
      $user= Db::name("user")->where(["member_id"=>$member_id])->find();


        $data['member_id'] = $member_id;
        $data['lock_id'] = $lock_id;
        $data['type'] = (int)$type;
        $data['create_time'] = time();
        $data['status'] = $status;
        $data['user_name'] = $user_name;
        $data['user_id'] = $user_id;
        $data['cpurl'] = $cpurl;
        $data['cardsn']=$cardsn;
        if (self::canWriteMobileBak()) {
            $data['mobile_bak'] = (string)Db::name("member")->where(["member_id" => $member_id])->value("mobile");
        }
        if(!empty($remark)) {
            $data['lremark'] = $remark;
        }
        Db::name("locklog")->insert($data);
    }
}
