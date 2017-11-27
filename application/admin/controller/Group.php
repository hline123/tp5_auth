<?php

namespace app\admin\controller;

use app\admin\model\Group as GroupModel;

class Group extends Common
{
    /**
     * 用户组列表
     * @return \think\response\View
     */
    public function index()
    {
        $field = db('auth_group')->order('id desc')->select();
        //halt($field);
        $this->assign('field', $field);
        return view('index');
    }

    /**
     * 用户组添加操作
     * @param GroupModel $group
     * @return \think\response\View
     */
    public function store(GroupModel $group)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res  = $group->store($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 查询所有规则
        $rules = $this->getRules();
        $this->assign('rules', $rules);
        return view('store');
    }

    /**
     * 获取规则数据
     * @return array
     */
    public function getRules()
    {
        // 获取规则表数据
        $rules = db('auth_rule')->select();
        // 根据nav对规则分类
        $arr = [];
        foreach ($rules as $k => $v) {
            $arr[ $v['nav'] ][] = $v;
        }
        return $arr;
    }

    /**
     * 用户组编辑处理
     * @param GroupModel $group
     * @return \think\response\View
     */
    public function edit(GroupModel $group)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res  = $group->edit($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 获取编辑原数据
        $id    = input('param.id');
        $field = $group->where('id', $id)->find();
        // 将存储的规则数据，切割成数据
        $field['rules'] = explode(',', $field['rules']);
        // 查询所有规则
        $rules = $this->getRules();
        $this->assign('rules', $rules);
        $this->assign('field', $field);
        return view();
    }

    /**
     * 用户组删除
     */
    public function delete()
    {
        $id = input('param.id');
        //执行删除
        $res = GroupModel::destroy($id);
        if ($res) {
            $this->success('操作成功', 'index');
        } else {
            $this->error('操作失败');
        }
    }
}
