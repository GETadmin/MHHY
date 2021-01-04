<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/26
 * Time: 16:26
 */

namespace app\admin\controller;

use app\common\Base;
use think\Db;
use think\facade\Config;
use think\facade\Cookie;
use think\facade\Request as FacadeRequest;
use think\facade\Session;
use think\facade\Validate;
use app\common\Jwt;

class Login extends Base
{
        public function __construct(Request $request)
        {
            parent::__construct($request);
        }
        public function index(){
                return $this->fetch();
        }

    public function logindispose()
    {
        if (FacadeRequest::isAjax() && FacadeRequest::isPost()) {
            $request = FacadeRequest::post();
            $rule = ['username' => 'require|max：50|min：8', 'password' => 'require|alphaNum|min:8'];
            $msg = [
                'username.require' => '用户名称不能为空！',
                'username.max' => '用户名称不得大于50个字节！',
                'username.min' => '用户名称不得少于8个字节！',
                'password.require' => '用户密码不能为空！',
                'password.min' => '用户密码不能低于8个字节！',
            ];
            $validate = validate::make($rule, $msg);
            if ($validate->check($this->request)) {
                $this->error_respond_json('400', $validate->getError());
            }

            $adminInfo = Db::name('admin')->where(['name' => htmlentities(trim($this->request['username'])), 'status' => 1])->find();
            if ($adminInfo) {
                if (password_verify($this->request['password'], $adminInfo['password'])) {
                    $auth = Db::name('admin')->alias('a')
                        ->leftJoin('admin_role b', 'a.id=b.admin_id')
                        ->leftJoin('role c', 'b.role_id = c.id')
                        ->where(['a.status' => 1, 'c.status' => 1, 'a.id' => $adminInfo['id']])
                        ->field('a.*,c.action')
                        ->find();
                    if (!empty($auth['action'])) $auth['action'] = explode(',', $auth['action']);
                    $exptime = 60;
                    $token_arr = ['user_id' => $auth['id'], 'name' => $auth['name'], 'nickname' => $auth['nickname'], 'sex' => $auth['sex'], 'exptime' => $exptime, 'expiration' => time() + $exptime];
                    $tokens = Jwt::baseInstance()->setJwtToken($token_arr)->respond();
                    if ($tokens['code'] == 200) {
                        $token_key = quchufh($tokens['data']);
                        $token_key = explode('.',$token_key);
                        $token_key = $token_key[0];
                        Session::set($token_key, $tokens['data']);
                        $key = Config::get('app.cookie_key');
                        Cookie::set('token', encrypt($token_key, $key));
                        $this->success('登录成功', 'Index/index');
                    } else {
                        $this->error('登录失败');
                    }
//                        Cookie::set()
                } else {
                    $this->error('用户名或者密码错误~请重新输入');
                }
            } else {
                $this->error('用户名或者密码错误~请重新输入');
            }

        }
        }
}