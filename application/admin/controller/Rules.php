<?php

namespace app\admin\controller;

use houdunwang\arr\Arr;
use app\admin\model\Rules as RulesModel;

/**
 * 规则控制器类
 * Class Rules
 * @package app\admin\controller
 */
class Rules extends Common
{
    /**
     * 显示规则列表
     * @param RulesModel $rules
     * @return \think\response\View
     */
    public function index(RulesModel $rules)
    {
        // 获取树形规则树形列表
        $field = $rules->getAll();
        // 分配到页面上
        $this->assign('field', $field);
        return view('index');
    }

    /**
     * 添加规则
     * @param RulesModel $rules
     * @return \think\response\View
     */
    public function store(RulesModel $rules)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res  = $rules->store($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 获取所有规则数据
        $rule = db('auth_rule')->select();
        //将规则数据变更为树形结构
        $rules = Arr::tree($rule, 'title', 'id', 'pid');
        $this->assign('rules', $rules);
        return view('store');
    }

    /**
     * 编辑规则
     * @param RulesModel $rules
     * @return \think\response\View
     */
    public function edit(RulesModel $rules)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $res  = $rules->edit($data);
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        // 获取当前规则id
        $id = input('param.id');
        // 当前要编辑的数据
        $field = $rules->where('id', $id)->find();
        // 获取规则数据
        // 剔除自己和自己的子集数据
        $rules = $rules->getSonData($id);
        $this->assign('field', $field);
        $this->assign('rules', $rules);
        return view('edit');
    }

    /**
     * 删除规则
     * @param $id
     */
    public function delete($id)
    {
        if (RulesModel::destroy($id)) {
            $this->success('删除成功', 'index');
        }else {
            $this->error('删除失败');
        }
    }
}
