<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/25
 * Time: 17:00
 */

namespace app\admin\controller;
use app\admin\controller\Login;
use app\common\Base;
use think\facade\Config;
use app\common\Jwt;
use think\facade\Request;
use think\validate;

class Admin extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function teamList(){
        $this->success();
            print_r(1);exit;
            print_r($this->getAllAuth());exit;
//            print_r(Redis::redisInstance()->getUserId());exit;
            Config::get('template.');
            $tokens= Jwt::baseInstance()->setJwtToken(['name'=>'wsn','sex'=>'1'])->respond();
            $token = $tokens['data'];
           $Jwt = Jwt::baseInstance()->setUserId()->getUserToken()->verifyToken($token)->getUserData()->respond();
           print_r($Jwt);exit;

            print_r($this->getJwtToken(['name'=>'wsn','sex'=>'1']));
            echo "\n";
//            print_r(self::getToken(array('name'=>'wsn','sex'=>'1')));
//            echo "\n";
//            echo $this->getTokens(['name'=>'wsn','sex'=>'1']);
            exit;
            echo "\n";
            return $this->fetch();
        }

    public function insert()
    {
        if (Request::isPost()) {
            $rule = [
                'name' => 'require|chsAlpha|max：8|min：4',
                'password' => 'require|alphaNum|min:8',
                'sex' => 'number|in:0,1',
                'description' => 'max:255',
                'nickname' => 'chsAlpha|max：50|min：8'];
            $msg = [
                'name.require' => '中文名称不能为空！',
                'name.max' => '中文名称不得大于8个字节！',
                'name.min' => '中文名称不得少于4个字节！',
                'name.chsAlpha' => '中文名称格式错误！',
                'password.require' => '用户密码不能为空！',
                'password.alphaNum' => '用户密码格式错误！',
                'password.min' => '用户密码不能低于8个字节！',
                'sex.number'=>'用户性别格式错误！',
                'sex.in'    =>'用户性别格式错误！',
                'description.max'=>'个人介绍不能超过255个字节',
                'nickname.chsAlpha'=>'用户昵称格式错误！',
                'nickname.max'=>'用户昵称不得大于50个字节！',
                'nickname.min'=>'用户昵称不能低于8个字节！',
            ];
            $validate = validate::make($rule, $msg);
            if ($validate->check($this->request)) {
                $this->error($validate->getError());
            } else {
                $data = ['auth_key' => addcslashes(htmlentities($this->reques['auth_key'])), 'auth_name' => addslashes(htmlentities($this->reques['auth_name'])), 'addtime' => time()];
                if (Db::name('role')->insertGetId($data)) {
                    $this->success('新增成功！');
                } else {
                    $this->error('新增失败！');
                }
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit()
    {
        if (Request::isPost()) {
            $rule = [
                'id' => 'require|number',
            ];
            if (isset($this->request['auth_key'])) $rule['auth_key'] = 'require|max：50|min：8';
            if (isset($this->request['auth_name'])) $rule['auth_name'] = 'require|alphaNum|min:8';
            $msg = [
                'auth_key.require' => '权限key！',
                'auth_key.max' => '权限key不得大于50个字节！',
                'auth_key.min' => '权限key不得少于8个字节！',
                'auth_name.require' => '权限名称不能为空！',
                'auth_name.min' => '权限名称不能低于8个字节！',
            ];
            $validate = validate::make($rule, $msg);
            if ($validate->check($this->request)) {
                $this->error($validate->getError());
            } else {
                if (!Db::name('role')->get($this->reques['id'])) {
                    $this->error('数据不存在！');
                }
                $data = ['role_name'=>$this->request['role_name'],'role_explain'=>$this->request['role_name'],'role_images'=>$this->request['role_name'],'updtime'=>time(),'status'=>$this->request['status'],'action'=>$this->request['action']];
                if (Db::name('role')->where('id', $this->reques['id'])->update($this->request)) {
                    $this->success('编辑成功！');
                } else {
                    $this->error('编辑失败！');
                }
            }
        } else {
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            $list = Db::name('role')->get($this->reques['id']);
            $this->assign('list', $list);
            return $this->fetch();
        }
    }
    //修改密码
    public function editPwd()
    {
        if (Request::isPost()) {
            $rule = [
                'id' => 'require|number',
            ];
            if (isset($this->request['auth_key'])) $rule['auth_key'] = 'require|max：50|min：8';
            if (isset($this->request['auth_name'])) $rule['auth_name'] = 'require|alphaNum|min:8';
            $msg = [
                'auth_key.require' => '权限key！',
                'auth_key.max' => '权限key不得大于50个字节！',
                'auth_key.min' => '权限key不得少于8个字节！',
                'auth_name.require' => '权限名称不能为空！',
                'auth_name.min' => '权限名称不能低于8个字节！',
            ];
            $validate = validate::make($rule, $msg);
            if ($validate->check($this->request)) {
                $this->error($validate->getError());
            } else {
                if (!Db::name('role')->get($this->reques['id'])) {
                    $this->error('数据不存在！');
                }
                $data = ['role_name'=>$this->request['role_name'],'role_explain'=>$this->request['role_name'],'role_images'=>$this->request['role_name'],'updtime'=>time(),'status'=>$this->request['status'],'action'=>$this->request['action']];
                if (Db::name('role')->where('id', $this->reques['id'])->update($this->request)) {
                    $this->success('编辑成功！');
                } else {
                    $this->error('编辑失败！');
                }
            }
        } else {
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            $list = Db::name('role')->get($this->reques['id']);
            $this->assign('list', $list);
            return $this->fetch();
        }
    }
    //真删除
    public function delete(){
        if(Request::get('id')){
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            if(Db::name('role')->where('id',$id)->delete()){
                $this->success('删除成功！');
            }else{
                $this->error('删除失败！');
            }
        }
    }
    //软删除
    public function deleFales(){
        if(Request::get('id')){
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            if(Db::name('role')->where('id',$id)->update(['status'=>'9'])){
                $this->success('删除成功！');
            }else{
                $this->error('删除失败！');
            }
        }
    }
}