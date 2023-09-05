<?php


namespace app\module\order;


use think\facade\Db;

class OrderServer
{
    public static function Add($member_id,$order_price,$product_id,$sim_sn)
    {
        $data["order_sn"] = time() . rand(1000000000, 9999999999);
        $data["created_at"] = date("Y-m-d H:i:s");
        $data["order_price"] = $order_price;
        $data["product_id"] = $product_id;
        $data["member_id"] = $member_id;
        $data["sim_sn"] = $sim_sn;

        Db::name("order")->insert($data);
        return $data;
    }
}
