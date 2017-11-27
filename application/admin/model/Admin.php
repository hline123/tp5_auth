<?php

namespace app\admin\model;

use houdunwang\crypt\Crypt;
use think\Loader;
use think\Model;
use think\Validate;

class Admin extends Model
{
    //定义主键
    protected $pk = 'admin_id';
    //定义数据表
    protected $table = 'blog_admin';

    /**
     * 添加管理员
     * @param $data
     * @return array
     */
    public function add($data)
    {
        // 验证数据
        $validate = Loader::validate('Admin');
        if (!$validate->check($data)) {
            return ['valid'=>0, 'msg'=> $validate->getError()];
        }
        //2.验证管理员是否存在
        $userInfo = $this->where('admin_username', $data['admin_username'])->find();
        if ($userInfo) {
            return ['valid'=>0, 'msg'=>'管理员已存在，请勿重复添加'];
        }
        // 加密密码添加数据
        $data['admin_password'] = Crypt::encrypt($data['admin_password'], md5(config('crypt.key')));
        $result = $this->save($data);
        if (!$result) {
            return ['valid'=>0, 'msg'=> '操作失败'];
        }
        return ['valid'=>1, 'msg'=> '操作成功'];
    }

    /**
     * 编辑管理员
     * @param $data
     * @return array
     */
    public function edit ($data)
    {
        // 验证数据
        $validate = Loader::validate('Admin');
        if (!$validate->check($data)) {
            return ['valid'=>0, 'msg'=> $validate->getError()];
        }
        // 2.验证管理员是否存在
        $userInfo = $this->where("admin_id != {$data['admin_id']}")->where('admin_username', $data['admin_username'])->find();
        if ($userInfo) {
            return ['valid'=>0, 'msg'=>'管理员已存在，请勿重复添加'];
        }
        // 加密密码
        $data['admin_password'] = Crypt::encrypt($data['admin_password'], md5(config('crypt.key')));
        // 执行修改
        $result = $this->save($data, ['admin_id' => $data['admin_id']]);
        if ($result !== false) {
            return ['valid'=>1, 'msg'=> '操作成功'];
        }else {
            return ['valid'=>0, 'msg'=> '操作失败'];
        }
    }

    /**
     * 后台管理员登录操作
     * @param $data
     * @return array
     */
    public function login ($data)
    {
        //halt($data);
        // 验证数据
        $validate = new Validate(
            [
                'admin_username' => 'require',
                'admin_password' => 'require',
                'code' => 'captcha|require',
            ],
            [
                'admin_username.require' => '请输入用户名',
                'admin_password.require' => '请输入密码',
                'code.require' => '请输入验证码',
                'code.captcha' => '验证码错误',
            ]
        );
        if (!$validate->check($data)) {
            return ['valid'=>0, 'msg'=>$validate->getError()];
        }
        // 对比数据库中的账号及密码
        $userInfo = $this->where('admin_username', $data['admin_username'])
            ->where('admin_password', Crypt::encrypt($data['admin_password'], md5(config('crypt.key'))))
            ->find();
        // halt($userInfo);
        if (!$userInfo) {
            return ['valid'=>0, 'msg'=>'用户名或密码错误'];
        }
        // 将当前管理员信息存入session中
        session('admin.admin_id', $userInfo['admin_id']);
        session('admin.admin_username', $userInfo['admin_username']);
        return ['valid'=>1, 'msg'=> '登录成功'];
    }
}
