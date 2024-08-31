<?php

namespace app\module\lockServer;

use think\facade\Db;

class LockCard
{
    public static function add($card_id, $lock_id, $end_time)
    {
        $data['lockcard_sn'] = $card_id;
        $data['lock_id'] = $lock_id;
        $data['lockcard_endtime'] = $end_time;
        Db::name("lockcard")->insert($data);
    }
}
