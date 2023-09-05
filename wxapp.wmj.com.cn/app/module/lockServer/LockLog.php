<?php


namespace app\module\lockServer;


use think\facade\Db;

class LockLog
{

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
        "11" => '人脸开门',
    ];

    static function add($member_id, $lock_id, $type, $status = 1,$user_name="")
    {
      $user= Db::name("user")->where(["member_id"=>$member_id])->find();


        $data['member_id'] = $member_id;
        $data['user_id'] = $user["user_id"];
        $data['lock_id'] = $lock_id;
        $data['type'] = (int)$type;
        $data['create_time'] = time();
        $data['status'] = $status;
        $data['user_name'] = $user_name;
        Db::name("locklog")->insert($data);
    }
}
