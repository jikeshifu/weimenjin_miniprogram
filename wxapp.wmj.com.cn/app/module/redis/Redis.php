<?php


namespace app\module\redis;


class Redis
{


    static function Redis(){
        $redis = new \Redis;
        $redis->connect('111.230.97.87', 6379);
        $redis->auth('49ba59abbe56e057');
        $redis->select(2);
        return $redis;
    }
}
