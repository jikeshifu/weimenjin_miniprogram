<?php


namespace app\module\model;


use think\Model;

class LockAuth extends Model
{
    protected $table = 'cd_lockauth';



    public function lock()
    {
        return $this->hasOne(Lock::class,"lock_id","lock_id");
    }
    public function memberInfo()
    {
        return $this->hasOne(Member::class,"member_id","member_id");
    }
}
