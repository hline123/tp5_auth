<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;

/**
 * 后台登录控制器类
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 登录执行
     * @param Admin $admin
     * @return \think\response\View
     */
    public function Login (Admin $admin)
    {
        if (request()->isPost()) {
            // 接收数据
            $data = input('post.');
            // 模型验证处理数据
            $res = $admin->login($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'admin/index/index');
            }else {
                $this->error($res['msg']);
            }
        }
        return view('login');
    }
}
