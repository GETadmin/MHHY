<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/28
 * Time: 11:33
 */

namespace app\admin\controller;


use app\common\Base;
use think\Db;
use think\facade\Request;
use think\validate;

class Auth extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_all()
    {
        $auth = $this->getAllAuth();
        if (!empty($auth)) {
            $data = [];
            foreach ($auth as $key => $val) {
                if (!Db::name('auth')->where('')->find()) {
                    $data[] = ['auth_key' => $val, 'auth_name' => '', 'addtime' => time()];
                }
            }
            if (!empty($data)) {
                if (Db::name('auth')->insertAll($data)) {
                    $this->success();
                } else {
                    $this->error();
                }
            }

        }
    }

    public function datalist()
    {
        $list = $this->baseInstance('\app\admin\model\Auth')->paginate(10);
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
                if (Db::name('auth')->insertGetId($data)) {
                    $this->success('新增成功！');
                } else {
                    $this->error('新增失败！');
                }
            }
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
                if (!Db::name('auth')->get($this->reques['id'])) {
                    $this->error('数据不存在！');
                }
                $data = ['auth_key' => addcslashes(htmlentities($this->reques['auth_key'])), 'auth_name' => addslashes(htmlentities($this->reques['auth_name'])), 'addtime' => time()];
                if (Db::name('auth')->where('id', $this->reques['id'])->update($data)) {
                    $this->success('编辑成功！');
                } else {
                    $this->error('编辑失败！');
                }
            }
        } else {
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            $list = Db::name('auth')->get($this->reques['id']);
            $this->assign('list', $list);
            return $this->fetch();
        }
    }
    //真删除
    public function delete(){
        if(Request::get('id')){
            $id = Request::get('id');
            if (!is_numeric($id)) $this->error('数据格式有误');
            if(Db::name('auth')->where('id',$id)->delete()){
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
            if(Db::name('auth')->where('id',$id)->update(['status'=>'9'])){
                $this->success('删除成功！');
            }else{
                $this->error('删除失败！');
            }
        }
    }
}