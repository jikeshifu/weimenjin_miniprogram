<?php
namespace app\module\model;

use think\Model;

class RechargeRecord extends Model
{
    protected $table = 'cd_recharge_records';
    protected $autoWriteTimestamp = 'datetime';
}