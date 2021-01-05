<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/28
 * Time: 13:46
 */

namespace app\http\middleware;
use think\Controller;

class Check extends Controller
{
    public function handle($request, \Closure $next)
    {
        $permission = config('app.public_permission');
        $action     = $request->action();
        $module     = $request->module();
        $controller = $request->controller();
        $permission_module = $permission[$module]??[];
        $classpath  = sprintf('app\\%s\\controller\\%s', $module, $controller);
        if(!method_exists($classpath, $action)){
            return $this->error("api not found.");
        }
        $auth_key = trim($controller).'-'.trim($action);
        if(!in_array($auth_key,$permission_module)){
            $token = is_login($request);
            if(!$token){
                return   $this->error('请登录账号','admin/login/index');
//                return redirect('admin/login/index');
            }
            $request->token = $token;
        }
        return $next($request);

    }
}
