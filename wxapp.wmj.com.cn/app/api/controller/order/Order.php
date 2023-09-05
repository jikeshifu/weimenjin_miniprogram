<?php


namespace app\api\controller\order;


use app\module\code\Code;
use app\module\member\memberServer\MemberServer;
use think\facade\Db;

class Order
{
    public function list(){
        $page =input("page");
        $limit =input("limit");
        $Uid = MemberServer::Uid();
      $list =  Db::name("order")->where(["member_id"=>$Uid["uid"]])->where(["pay_status"=>1])->page($page,$limit)->select();

        return json(Code::CodeOk(["data"=>$list]));
    }
}
