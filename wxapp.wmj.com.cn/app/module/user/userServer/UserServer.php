<?php


namespace app\module\user\userServer;


use xhadmin\service\api\UserService;

class UserServer
{

    static function Add($name,$user,$pwd,$member_id)
    {

        //name,user,pwd,member_id
        $data['name'] = $name;
        $data['user'] = $user;
        $data['pwd'] = md5($pwd.config('my.password_secrect'));
        $data['member_id'] = $member_id;
        $data['group_id'] = 7;
        $data['type'] = 2;
        $data['status'] = 1;
        $data['create_time'] = time();

       $user = db()->name('user')->where(["user"=>$user])->find();
       if(!$user){
           $data['user'] = uniqid();
           db()->name('user')->insert($data);
       }

    }

    static function Info($user_id){
       return db()->name('user')->where(["user_id"=>$user_id])->find();
    }
}
