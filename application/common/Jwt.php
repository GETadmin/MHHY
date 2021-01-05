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
    public $userInfo;
    public $mgs;
    public $code;
    public $respond;
    public $data;
    public $redis;
    public $jwt;
    public $result;
    public $key='sdfawefadfwefaf';
    public function __construct($param){
        $this->redis = Redis::redisInstance();
        $this->jwt = new jwts();
        $this->data = $param;

    }

    public static function baseInstance($param)
    {
        return new Jwt($param);
    }

    public function verifyToken()
    {
        if ($this->code != '400') {
            if (!empty($this->data)) {
                if (is_string($this->data)) {
                    $this->mgs = '验证通过！';
                    $this->code = '200';
                } else {
                    $this->mgs = 'Token格式有误！';
                    $this->code = '400';
                }
            }else{
                $this->mgs = 'Token数据不能为空！';
                $this->code = '400';
            }
        }
        return $this;
    }

    public function verifyArray()
    {
        if ($this->code != '400') {
            if (!empty($this->data)) {
                if (is_array($this->data)) {
                    $this->data['createtime'] = time();
                    if(isset($this->data['exptime'])||isset($this->data['expiration'])){

                        $this->mgs = '验证通过！';
                        $this->code = '200';
                    }else{
                        $this->data['expiration'] = strtotime(date('Y-m-d 23:59:59'));
                        $this->mgs = '有效时间为空！';
                        $this->code = '200';
                    }

                } else {
                    $this->mgs = 'array格式有误！';
                    $this->code = '400';
                }
            }else{
                $this->mgs = 'array数据不能为空！';
                $this->code = '400';
            }
        }
        return $this;
    }
    public function getDecode()
    {
        $this->verifyToken();
        if($this->code!= '400') {
            $data = $this->getJwtDecode($this->data);
            if (empty($data)) {
                $this->mgs = 'user数据为空！';
                $this->code = '400';
            } else {
                $this->mgs = '获取成功！';
                $this->code = '200';
                $this->result = json_decode(json_encode($data), true);
            }
        }
        return $this;

    }
    public function getEncode(){
        $this->verifyArray();
        if($this->code!= '400') {
            $data = $this->getJwtToken($this->data);
            // && $this->redis->setex('token', '3600', $data) == 'ok'
            if (!empty($data)) {

                $this->mgs = '获取成功！';
                $this->code = '200';
                $this->result = $data;
            } else {
                $this->mgs = '获取token失败！';
                $this->code = '400';
            }
        }
        return $this;
    }

    public function getJwtToken($array)
    {
        return jwts::encode($array, $this->key);
    }

    public function getJwtDecode($string)
    {
        return jwts::decode($string, $this->key, ['HS256']);
    }

    public function validity_time()
    {
        if ($this->code != 400) {
            if (!empty($this->result)) {
                if (isset($this->result['exptime']) || isset($this->result['expiration'])) {
                    if (isset($this->result['exptime']) && !empty($this->result['exptime'])) {
                        $expiration = $this->result['createtime'] + $this->result['exptime'];
                    }
                    if (isset($this->result['expiration']) && !empty($this->result['expiration'])) {
                        $expiration = $this->result['expiration'];
                    }
                    if (time() > $expiration) {
                        $this->mgs = 'Token已经过期！';
                        $this->code = '400';
                    } else {
                        unset($this->result['createtime']);
                        unset($this->result['expiration']);
                        unset($this->result['exptime']);
                        $this->mgs = '通过校验！';
                        $this->code = '200';
                    }
                } else {
                    $this->mgs = '系统识别到未设置过期时间！';
                    $this->code = '400';
                }
            } else {
                $this->mgs = '获取token失败！';
                $this->code = '400';
            }
        }
        return $this;
    }
    public function ending(){
        $respond = ['code' => $this->code, 'mgs' => $this->mgs];
        if (!empty($this->result)) $respond['data'] = $this->result;
        return $respond;
    }
}