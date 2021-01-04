<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getAllClass($dir){
    if(file_exists($dir)){
        $Class = dirname($dir);
        $Class = scandir($Class);
        unset($Class[0],$Class[1]);
        $list=[];
        foreach($Class as $k => $v){
            $list[]=pathinfo($v,PATHINFO_FILENAME);
        }
        return $list;
    }else{
        return false;
    }
}
function getAllFunction($Class){
    if (class_exists($Class)) {
        $Class = new $Class;
        $own = get_class_methods($Class);
        if ($parent = get_parent_class($Class)) {
            $p_function = get_class_methods($parent);
            $newarr = array_diff($own, $p_function);
        } else {
            $newarr = $own;
        }
        return $newarr;
    }else{
        return false;
    }

}
/**
 * 检查操作是否存在
 * @param $request
 * @return bool
 */
function check_action_exists($request)
{
    $action     = $request->action();
    $module     = $request->module();
    $controller = $request->controller();
    $classpath  = sprintf('app\\%s\\controller\\%s', $module, $controller);
    return method_exists($classpath, $action);
}
/**
 * 检查操作是否存在
 * @param $request
 * @return bool
 */
function chech_auth($request)
{

//    $token = $request->header('token');
    $token = $request->get('token');
    $action     = $request->action();
    $module     = $request->module();
    $controller = $request->controller();
    $permission_module = $permission[$module]??[];
    $auth_key = trim($controller).'-'.trim($action);
    if(!in_array($auth_key,$permission_module)&&empty($token)){
        return false;
    }

    return true;
}
function is_login($request){
    $token_key = \think\facade\Cookie::get('token');
    if(empty($token_key)) $token_key = $request->header('token');
    if(empty($token_key)) return false;
    $key = config('app.cookie_key');
    $tokens = decrypt($token_key,$key);
    $token = \think\facade\Session::get($tokens);
    if(empty($token)) return false;
    return $token;
}
/**
 * 加密函数
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = ''){
    if (empty($txt)) return $txt;
    if (empty($key)) $key = md5(MD5_KEY);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0,64);
    $nh2 = rand(0,64);
    $nh3 = rand(0,64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};

    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;$i = 0;
    while(isset($key{$i})) $knum +=ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
    $txt = base64_encode(time().'_'.$txt);
    $txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
    $tmp = '';
    $j=0;$k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i=0; $i<$tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
    $tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
    $tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
    return $tmp;
}
/**
 * 解密函数
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0){
    if (empty($txt)) return $txt;
    if (empty($key)) $key = md5(MD5_KEY);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;$i = 0;
    $tlen = @strlen($txt);
    while(isset($key{$i})) $knum +=ord($key{$i++});
    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars,$ch1);
    $txt = @substr_replace($txt,'',$knum % $tlen--,1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars,$ch2);
    $txt = @substr_replace($txt,'',$nh1 % $tlen--,1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars,$ch3);
    $txt = @substr_replace($txt,'',$nh2 % $tlen--,1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum % 8,$knum % 8 + 16);
    $tmp = '';
    $j=0; $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i=0; $i<$tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars,$txt{$i})-$nhnum - ord($mdKey{$k++});
        while ($j<0) $j+=64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
    $tmp = trim(base64_decode($tmp));
    if (preg_match("/\d{10}_/s",substr($tmp,0,11))){
        if ($ttl > 0 && (time() - substr($tmp,0,11) > $ttl)){
            $tmp = null;
        }else{
            $tmp = substr($tmp,11);
        }
    }
    return $tmp;
}
function quchufh($txt){
  return str_replace(array('+','/','='),array('-','_','.'),$txt);
}
function sumint(){
    $disk_totle = '';
    if(strtoupper(substr(PHP_OS,0,3)) == 'WIN'){
        $driver=['c:','a:','b:','d:','e:','f:','h'];
        foreach ($driver as $key=>$val){
            if(is_dir($val)){
                $disk = disk_free_space("{$val}");
                $disk_all = disk_total_space("{$val}");
                if(!empty($disk))$disk_totle .='['.$val.'盘可用：'.round($disk/1024/1024,2).'mb,总大小：'.round($disk_all/1024/1024,2).'mb];';
            }

        }
    }else{
        $pars = array_filter(explode("\n",`df -h`));
        foreach ($pars as $par) {
            if ($par{0} == '/') {
                $_tmp = array_values(array_filter(explode(' ',$par)));
                reset($_tmp);
                $disk_totle .= '['.$_tmp['5'].'分区可用：'.$_tmp['2'].'('.$_tmp['4'].'),总大小：'.$_tmp['1'].'];';
            }
        }
    }
    return $disk_totle;
}
function get_file(){
    return __FILE__;
}