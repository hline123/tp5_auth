<?php

namespace app\admin\controller;

use think\auth\Auth;
use think\Controller;
use think\Request;

/**
 * 基础控制器类
 * Class Common
 * @package app\admin\controller
 */
class Common extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // 检测是否登录
         $this->checkLogin();
        //权限验证
        $this->checkRules();
    }

    /**
     * 查看管理员是否登录
     */
    public function checkLogin ()
    {
        if (empty(session('admin.admin_id'))) {
            $this->error('无权访问,请先登录', 'admin/login/login');
        }
    }

    /**
     * 用户权限验证
     */
    public function checkRules ()
    {
        //添加规则
        $rule = request ()->module () . '/' . request()->controller () . '/' . request()->action ();
        //执行Auth类中check方法进行验证
        $res = (new Auth())->check ($rule,session('admin.admin_id'));
        //做出判断，没有权限的给出提示信息
        if(!$res){
            $this->error('没有操作权限');
        }
    }
}
