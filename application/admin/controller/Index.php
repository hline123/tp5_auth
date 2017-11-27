<?php
namespace app\admin\controller;

use houdunwang\crypt\Crypt;
use think\Validate;
use app\admin\model\Admin;

class Index extends Common
{
    /**
     * 后台首页
     * @return \think\response\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 退出登录
     */
    public function logout ()
    {
        // 销毁session
        session('admin', null);
        // 返回登录页面
        $this->redirect('admin/login/login');
    }

    /**
     * 修改密码
     * @param Admin $admin
     * @return \think\response\View
     */
    public function pass (Admin $admin)
    {
        if (request()->isPost()) {
            // 接收数据
            $data = input('post.');
            //halt($data);
            // 验证数据
            $validate = new Validate(
                [
                    'new_password' => 'require',
                    'confirm_password' => 'require|confirm:new_password'
                ],
                [
                    'new_password.require' => '请输入密码',
                    'confirm_password.require' => '请输入确认密码',
                    'confirm_password.confirm' => '两次密码不一致',
                ]
            );
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            // 执行修改
            $model = $admin::get($data['admin_id']);
            $model->admin_password = Crypt::encrypt($data['new_password'], md5(config('crypt.key')));
            $res = $model->save();
            if ($res !== false) {
                $this->success('密码修改成功', 'index');
            }else {
                $this->error('修改失败');
            }
        }
        // 根据session获取当前用户信息
        $id = session('admin.admin_id');
        $userInfo = db('admin')->where('admin_id', $id)->find();
        // 解密密码
        $userInfo['admin_password'] = Crypt::decrypt($userInfo['admin_password'], md5(config('crypt.key')));
        // 分配到页面上
        $this->assign('userInfo', $userInfo);
        return view();
    }
}
