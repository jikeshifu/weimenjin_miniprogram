<?php


namespace app\module\code;


class Code
{
    static function CodeOk($data=[])
    {
        $data["code"]=0;
        if (!isset($data["msg"])){
            $data["msg"] ="操作成功";
        }
        return $data;
    }

    static function CodeErr($code=1000,$msg ="操作失败",$data=[])
    {
        $resData["code"]=$code;
        $resData["msg"] =$msg;
        $resData["data"] =$data;
        return $resData;
    }
}
