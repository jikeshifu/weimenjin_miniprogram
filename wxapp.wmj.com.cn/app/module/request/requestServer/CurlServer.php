<?php


namespace app\module\reqiest\reqiestServer;




class CurlServer
{
    /**
     * @param $url
     * @param string $arr
     * @return mixed
     * 指令
     */
    static function curlJsonPost($url,$arr=""){
        if($arr){
            $data_string = json_encode($arr,JSON_UNESCAPED_UNICODE);
        }else{
            $data_string = "{}";
        }

        $ch = curl_init(InstructConfig::$urlApi.$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        return json_decode($result,true);
    }

    static function curlJsonPost2($url,$arr=""){
        if($arr){
            $data_string = json_encode($arr,JSON_UNESCAPED_UNICODE);
        }else{
            $data_string = "{}";
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        return json_decode($result,true);
    }
}
