<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/25
 * Time: 17:03
 */

namespace app\common;
use think\Controller;
use think\Request;


class Base extends Controller
{
    public $request_all;
    public $request;
    static private $newdata=[];
    //头部
    private static $header=array(
        'alg'=>'HS256', //生成signature的算法
        'typ'=>'JWT'  //类型
    );

    //使用HMAC生成信息摘要时所使用的密钥
    private static $key='sadwjlere46123123sadsa';
//    public function _initialize(){
//        parent::_initialize();
//    }
    public function __construct(Request $request){
        parent::__construct();
        //处理token值
        $this->tokenHandle($request->token);
        $this->request = $request->post();
    }
    public function baseInstance($colass){
        if(!isset(self::$newdata[$colass])){
            self::$newdata[$colass] = new $colass();
        }
        return self::$newdata[$colass];

    }
    /**
     * base64UrlEncode  https://jwt.io/ 中base64UrlEncode编码实现
     * @param string $input 需要编码的字符串
     * @return string
     */
    private static function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
    /**
     * HMACSHA256签名  https://jwt.io/ 中HMACSHA256签名实现
     * @param string $input 为base64UrlEncode(header).".".base64UrlEncode(payload)
     * @param string $key
     * @param string $alg  算法方式
     * @return mixed
     */
    private static function signature(string $input, string $key, string $alg = 'HS256')
    {
        $alg_config=array(
            'HS256'=>'sha256'
        );
        return self::base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key,true));
    }
    /**
     * 获取jwt token
     * @param array $payload jwt载荷  格式如下非必须
     * [
     * 'iss'=>'jwt_admin', //该JWT的签发者
     * 'iat'=>time(), //签发时间
     * 'exp'=>time()+7200, //过期时间
     * 'nbf'=>time()+60, //该时间之前不接收处理该Token
     * 'sub'=>'www.admin.com', //面向的用户
     * 'jti'=>md5(uniqid('JWT').time()) //该Token唯一标识
     * ]
     * @return bool|string
     */
    public static function getToken(array $payload)
    {
        if(is_array($payload))
        {
            $base64header=self::base64UrlEncode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64payload=self::base64UrlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            $token=$base64header.'.'.$base64payload.'.'.self::signature($base64header.'.'.$base64payload,self::$key,self::$header['alg']);
            return $token;
        }else{
            return false;
        }
    }
    public function getTokens(array $array){
        if(is_array($array)){
        $key = 'sdfawefadfwefaf';
        $ar = [];
        foreach ($array as $key => $val){
            $ar[$key] = $key;
        }
        sort($ar);
        $str = '';
        foreach ($ar as $item => $value){
            $str =$str.$ar[$item].$array[$value];
        }
        $str = $key.$str;
       return strtoupper(sha1($str));
        }else{
            return false;
        }
    }
    public function getJwtToken(array $array){
        if(is_array($array)){
            $jwt = self::baseInstance("\Firebase\JWT\JWT");
            $key = 'sdfawefadfwefaf';
            return $jwt->encode($array,$key);
        }else{
            return false;
        }

    }
    public function getJwtDecode($string){
        $jwt = self::baseInstance('\Firebase\JWT\JWT');
        $key = 'sdfawefadfwefaf';
        return $jwt->decode($string,$key);
    }
    public function getAllAuth($dir = ''){
        if(empty($dir)){
            $dir = explode('\\',__FILE__);
            ksort($dir);
            unset($dir[(count($dir)-1)],$dir[(count($dir)-1)]);
            $dir = implode('\\',$dir).'\admin\controller\Admin.php';
        }

        if( $ClassAll = getAllClass($dir)){
            $auth = [];
            $ClassAll = getAllClass($dir);
            foreach($ClassAll as $key => $val){
                $newclass =  "\app\admin\controller\\".$val;
                $Funct = getAllFunction($newclass);
                if(!empty($Funct)&& is_array($Funct)){
                    foreach ($Funct as $k=>$v){
                        $auth[] =  trim($val).'-'. trim($v);
                    }
                }
            }
            return $auth;
        }else{
            return false;
        }
    }

    public function error_respond_json($code = '400', $msg = '请求错误')
    {
        exit(json_encode(['code' => $code, 'msg' => $msg]));
    }

    public function success_respond_json($code = '200', $msg = '请求成功',$data=[])
    {
        $respond = ['code' => $code, 'msg' => $msg];
        if (!empty($data)) $respond['data'] = $data;
        exit(json_encode($respond));
    }
    private function tokenHandle($token){
       $data = Jwt::baseInstance()->getUserData($token)->respond();
       print_r($data);exit;
}
}