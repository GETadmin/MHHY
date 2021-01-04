<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/25
 * Time: 17:00
 */

namespace app\admin\controller;


use app\common\Base;
use think\facade\Env;
use think\Request;
use think\facade\Session;
use think\route\Rule;

class Index extends Base
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(Request $request){
                print_r( $request->token);exit;
//        print_r(sumint());exit;
//        $ww = new  Rule();
//       $data = ['SERVER_ADDR'=>$_SERVER['SERVER_ADDR'],'hostname'=>gethostname()];
//       print_r(app('route')->getdomain());exit;
//         $data = [
//            'ip'=>app('request')->ip(),//服务器IP地址
//            'hostname'=>gethostname(),//计算机名称
//            'domain'=>app('route')->getdomain(),//服务器域名
//            'port'=>$_SERVER['SERVER_PORT'],//服务器端口
//            'versions'=>php_uname('s').php_uname('r'),//服务器版本
//            'uname'=>php_uname(),//服务器操作系统
//            'systemdir'=>$_SERVER['SystemRoot'],//获取服务器系统目录
//            'php_vers'=>PHP_VERSION,//PHP版本
//            'php_dir'=>DEFAULT_INCLUDE_PATH,//获取PHP安装路径
//            'Zend_vers'=>Zend_Version(),//获取Zend版本
//            'php_mode'=>php_sapi_name(),//PHP运行方式
//            'time'=>date("Y-m-d H:i:s"),//服务器时间
//            'max_uploa'=>get_cfg_var ("upload_max_filesize")?:"不允许",//最大上传限制
//            'max_run_time'=>get_cfg_var("max_execution_time")."秒 ",//最大执行时间
//            'script_time'=>get_cfg_var ("memory_limit")?:"无",//脚本运行占用最大内存
//            'translate'=>$_SERVER['SERVER_SOFTWARE'],//获取服务器解译引擎
//            'CPUsum'=>$_SERVER['PROCESSOR_IDENTIFIER'],//获取服务器CPU数量
//            'protocol'=>$_SERVER['SERVER_PROTOCOL'],//获取请求页面时通信协议的名称和版本
//            'userdomain'=>$_SERVER['USERDOMAIN'],//获取用户域名
//            'language'=>$_SERVER['HTTP_ACCEPT_LANGUAGE'],//获取服务器语言
//            'internal'=>round(memory_get_usage()/1024/1024, 2).'MB',//获取内存信息
//             'course_name'=>Get_Current_User(),
//             'Sessionsum'=>count(Session::get()),
//             'SessionID'=>Session::sid()
//        ];

        return $this->fetch();
    }
    public function welcome(){

        $data = [
            'ip'=>app('request')->ip(),//服务器IP地址
            'hostname'=>gethostname(),//计算机名称
            'domain'=>app('route')->getdomain(),//服务器域名
            'port'=>$_SERVER['SERVER_PORT'],//服务器端口
            'versions'=>php_uname('s').php_uname('r'),//服务器版本
            'uname'=>php_uname(),//服务器操作系统
            'systemdir'=>$_SERVER['SystemRoot'],//获取服务器系统目录
            'php_vers'=>PHP_VERSION,//PHP版本
            'php_dir'=>DEFAULT_INCLUDE_PATH,//获取PHP安装路径
            'Zend_vers'=>Zend_Version(),//获取Zend版本
            'php_mode'=>php_sapi_name(),//PHP运行方式
            'time'=>date("Y-m-d H:i:s"),//服务器时间
            'max_uploa'=>get_cfg_var ("upload_max_filesize")?:"不允许",//最大上传限制
            'max_run_time'=>get_cfg_var("max_execution_time")."秒 ",//最大执行时间
            'script_time'=>get_cfg_var ("memory_limit")?:"无",//脚本运行占用最大内存
            'translate'=>$_SERVER['SERVER_SOFTWARE'],//获取服务器解译引擎
            'CPUsum'=>$_SERVER['PROCESSOR_IDENTIFIER'],//获取服务器CPU数量
            'protocol'=>$_SERVER['SERVER_PROTOCOL'],//获取请求页面时通信协议的名称和版本
            'userdomain'=>$_SERVER['USERDOMAIN'],//获取用户域名
            'language'=>$_SERVER['HTTP_ACCEPT_LANGUAGE'],//获取服务器语言
            'internal'=>round(memory_get_usage()/1024/1024, 2).'MB',//获取内存信息
            'php_max_int'=>round(memory_get_peak_usage()/1024/1024, 2).'MB',//PHP峰值内存
            'course_name'=>Get_Current_User(),//进程名称
            'Sessionsum'=>count(Session::get()),//获取Session数量
             'SessionID'=>Session::sid(),//获取SessionID数量
            'diskinfo'=>sumint(),
            ];
        $this->assign('data',$data);
        return $this->fetch();
    }

}