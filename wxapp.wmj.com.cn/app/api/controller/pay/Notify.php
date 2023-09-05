<?php


namespace app\api\controller\pay;


use app\module\device\server\Device;
use app\module\redis\Redis;
use app\module\wechat\WechatServer;
use think\facade\Db;

class Notify
{
    public function index()
    {

        $app = WechatServer::PayApp();
        $response = $app->handlePaidNotify(function ($message, $fail) {

            $Redis = Redis::Redis();
            $Redis->set("payNotify", json_encode($message), 3600);
            $order =   Db::name("order")->where(["order_sn"=>$message["out_trade_no"],"pay_status"=>0])->find();

            if(!$order){
            return true;
            }
            print_r($order);
            Db::name("order")->where(["order_sn"=>$message["out_trade_no"]])->update([
                "pay_status"=>1,
                "pay_time"=> date("Y-m-d H:i:s")
            ]);
            $res =  Device::SimPay($order["sim_sn"],$order["product_id"],$order["order_sn"]);
            //续费成功
            if($res["code"]==0){
                Db::name("order")->where(["order_sn"=>$message["out_trade_no"]])->update([
                    "order_status"=>1,

                ]);

            }else{
                Db::name("order")->where(["order_sn"=>$message["out_trade_no"]])->update([
                    "remark"=>$res["msg"],

                ]);
            }

            // 你的逻辑
            return true;
            // 或者错误消息
            $fail('Order not exists.');
        });

        $response->send(); // Laravel 里请使用：return $response;
    }

    public function test(){


        $Redis = Redis::Redis();
      $payNotify = json_decode($Redis->get("payNotify"),true);

        $order =   Db::name("order")->where(["order_sn"=>$payNotify["out_trade_no"],"pay_status"=>0])->find();

        if(!$order){
//            return true;
        }
        print_r($order);
        Db::name("order")->where(["order_sn"=>$payNotify["out_trade_no"]])->update([
            "pay_status"=>1,
            "pay_time"=> date("Y-m-d H:i:s")
        ]);
        $res =  Device::SimPay($order["sim_sn"],$order["product_id"],$order["order_sn"]);
        //续费成功
        if($res["code"]==0){
            Db::name("order")->where(["order_sn"=>$payNotify["out_trade_no"]])->update([
                "order_status"=>1,

            ]);

        }else{
            Db::name("order")->where(["order_sn"=>$payNotify["out_trade_no"]])->update([
                "remark"=>$res["msg"],

            ]);
        }

        print_r($res);

    }
}
