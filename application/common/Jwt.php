<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/26
 * Time: 14:28
 */

namespace app\common;

use app\common\Redis;
use Firebase\JWT\JWT as jwts;
class Jwt
{
    public $usertoken;
    public $mgs;
    public $code;
    public $respond;
    public $data;
    public $redis;
    public $jwt;
    public $key='sdfawefadfwefaf';
    public function __construct(){
        $this->redis = Redis::redisInstance();
        $this->jwt = new jwts();
    }

    public static function baseInstance()
    {

        return new Jwt;
    }

    public function setUserId()
    {
        $this->redis->set('userid', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoid3NuIiwic2V4IjoiMSJ9.EsaA0wAf17UDWAg0iZH9II5QC4-CTvp0-EH7sleXdho');

        return $this;
    }

    public function getUserToken($usertoken = '')
    {
        $this->usertoken = $usertoken?:$this->redis->get('token');
        return $this;
    }

    public function verifyToken($token)
    {
        if($this->code!= '400'){
            if (!empty($token)) {
                if (trim($token) === $this->usertoken) {
                    $this->mgs = '验证通过！';
                    $this->code = '200';
                } else {
                    $this->mgs = 'thoken值为空！';
                    $this->code = '400';
                }
            }
        }
        return $this;
    }

    public function getUserData()
    {
        if($this->code!= '400') {
            $data = $this->getJwtDecode($this->usertoken);

            if (empty($data)) {
                $this->mgs = 'user数据为空！';
                $this->code = '400';
            } else {
                $this->mgs = '获取成功！';
                $this->code = '200';
                $this->data = json_decode(json_encode($data), true);
            }
        }
       return $this;

    }
    public function setJwtToken($array){
        if($this->code!= '400') {
            if (empty($array) && !is_array($array)) {
                $this->mgs = 'user数据为空！';
                $this->code = '400';
                return $this;
            }
            $data = $this->getJwtToken($array);

            if (!empty($data) && $this->redis->setex('token', '3600', $data) == 'ok') {

                $this->mgs = '获取成功！';
                $this->code = '200';
                $this->data = $data;
            } else {
                $this->mgs = '获取token失败！';
                $this->code = '400';
            }
        }
        return $this;
    }
    public function respond()
    {
        $respond = ['code' => $this->code, 'mgs' => $this->mgs];
        if (!empty($this->data)) $respond['data'] = $this->data;
        return $respond;
    }

    public function getJwtToken(array $array)
    {
        if (is_array($array)) {
            return jwts::encode($array, $this->key);
        } else {
            return false;
        }

    }

    public function getJwtDecode($string)
    {

        return jwts::decode($string, $this->key,['HS256']);

    }
}