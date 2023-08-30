<?php


namespace app\module\model;


use think\Model;

class LockLog extends Model
{
    protected $table = 'cd_locklog';




    public function memberInfo()
    {
        return $this->hasOne(Member::class,"member_id","member_id")->bind(["headimgurl"]);

    }



    public function lock()
    {
        return $this->hasOne(Lock::class,"lock_id","lock_id")->field("lock_name,lock_id");
    }
}
