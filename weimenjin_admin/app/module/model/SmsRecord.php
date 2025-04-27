<?php
namespace app\module\model;

use think\Model;

class SmsRecord extends Model
{
    protected $table = 'cd_sms_records';
    protected $autoWriteTimestamp = 'datetime';
}
