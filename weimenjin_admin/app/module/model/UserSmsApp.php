<?php

namespace app\module\model;

use think\Model;

class UserSmsApp extends Model
{
    protected $name = 'user_sms_apps';

    protected $autoWriteTimestamp = 'datetime';

    protected $createTime = 'created_at';
}
