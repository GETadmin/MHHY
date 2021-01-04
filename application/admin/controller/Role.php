<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/28
 * Time: 15:46
 */

namespace app\admin\controller;

use app\common\Base;
use think\Db;
use think\facade\Request;
use think\validate;
class Role extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function datalist()
    {
        $list = $this->baseInstance('\app\admin\model\Role')->alias('a')->leftJoin('role_auth b','a.id=b.role_id')->leftJoin('auth c','b.auth_id = c.id')->field('a.*.c.auth_key,group_concat(c.auth_key) as auth_key')->group('a.id')->paginate(10);
        $this->assign('list', $list);
        return $this->fetch();

    }

    public function insert()
    {
        if (Request::isPost()) {
            $rule = ['auth_key' => 'require|max：50|min：8',
                'auth_name' => 'alphaNum|min:8'];
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
                $data = ['auth_key' => addcslashes(htmlentities($this->reques['auth_key'])), 'auth_name' => addslashes(htmlentities($this->reques['auth_name'])), 'addtime' => time()];
                if (Db::name('role')->insertGetId($data)) {
                    $this->success('新增成功！');
                } else {
                    $this->error('新增失败！');
                }
            }
        }else{

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