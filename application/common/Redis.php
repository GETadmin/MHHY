<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/26
 * Time: 14:30
 */

namespace app\common;


class Redis
{
    public static function redisInstance($host = '127.0.0.1', $port = '6379')
    {
        $redis = new \Redis();
        $redis->connect($host, $port);
        return $redis;
    }

}