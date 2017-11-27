<?php

namespace app\admin\controller;

use houdunwang\crypt\Crypt;
use think\Request;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Groupaccess;

/**
 * 管理员管理控制器类
 * Class Admin
 * @package app\admin\controller
 */
class Admin extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = db('admin')->order('admin_id desc')->paginate(20);
        //halt($list);
        $this->assign('list', $list);
        //显示列表页
        return view('index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //显示添加页面
        return view('store');
    }

    /**
     * 新增管理员数据
     * @param Request $request
     */
    public function save(Request $request)
    {
        //获取添加数据
        $data = $request->post();
        // 模型验证处理数据
        $model = new AdminModel();
        $res   = $model->add($data);
        if ($res['valid']) {
            $this->success($res['msg'], 'index');
        } else {
            $this->error($res['msg']);
        }
    }

    /**
     * 编辑管理员
     * @param AdminModel $admin
     * @return \think\response\View
     */
    public function edit(AdminModel $admin)
    {
        //编辑数据
        if (request()->isPost()) {
            $data = input('post.');
            // 模型处理数据
            $res = $admin->edit($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 获取旧数据
        $id                         = input('param.id');
        $userInfo                   = $admin->where('admin_id', $id)->find();
        $userInfo['admin_password'] = Crypt::decrypt($userInfo['admin_password'], md5(config('crypt.key')));
        // 分配到模板中
        $this->assign('userInfo', $userInfo);
        //显示编辑界面
        return view('edit');
    }

    /**
     * 删除管理员
     * @param $id
     */
    public function delete($id)
    {
        if (AdminModel::destroy($id)) {
            $this->success('删除成功', 'index');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 设置用户权限
     * @param Groupaccess $groupaccess
     * @return \think\response\View
     */
    public function setAuth(Groupaccess $groupaccess)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res  = $groupaccess->setAuth(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 获取当前管理员数据
        $id       = input('param.id');
        $userInfo = db('admin')->where('admin_id', $id)->find();
        // 获取用户组数据
        $group = db('auth_group')->select();
        // 获取当前用户已存在的组(角色)id
        $accessData = db('auth_group_access')->where('uid', $id)->column('group_id');
        //halt($accessData);
        $this->assign('userInfo', $userInfo);
        $this->assign('group', $group);
        $this->assign('accessData', $accessData);
        return view();
    }
}
