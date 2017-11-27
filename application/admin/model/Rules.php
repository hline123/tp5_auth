<?php

namespace app\admin\model;

use houdunwang\arr\Arr;
use think\Model;

class Rules extends Model
{
    //定义主键
    protected $pk    = 'id';
    protected $table = 'blog_auth_rule';

    /**
     * 树形获取所有的规则数据
     * @return mixed
     */
    public function getAll()
    {
        // 获取所有规则数据
        $data = $this->select();
        //将规则数据变更为树形结构
        $list = Arr::tree($data, 'title', 'id', 'pid');
        return $list;
    }

    /**
     * 添加规则
     * @param $data
     * @return array
     */
    public function store($data)
    {
        // 验证添加规则
        $result = $this->validate(true)->save($data);
        // 判断输出信息
        if ($result === false) {
            return ['valid' => 0, 'msg' => $this->getError()];
        } else {
            return ['valid' => 1, 'msg' => '新增成功'];
        }
    }

    /**
     * 获取当前规则及子集之外的规则数据
     * @param $id
     * @return mixed
     */
    public function getSonData($id)
    {
        // 查询所有规则数据
        $data = db('auth_rule')->select();
        // 获取所有子集id
        $ids = $this->getSon($data, $id);
        // 将自己的id追加进去
        $ids[] = $id;
        // 查询自己及子集数据之外的数据
        $rule = db('auth_rule')->whereNotIn('id', $ids)->select();
        // 变成树形结构输出
        return Arr::tree($rule, 'title', 'id', 'pid');
    }

    /**
     * 递归获取所有的子集id
     * @param $data
     * @param $id
     * @return array
     */
    public function getSon($data, $id)
    {
        static $arr = [];
        foreach ($data as $k => $v) {
            if ($id == $v['pid']) {
                $arr[] = $v['id'];
                $this->getSon($data, $v['id']);
            }
        }
        return $arr;
    }

    /**
     * 编辑规则
     * @param $data
     * @return array
     */
    public function edit($data)
    {
        //验证编辑数据
        $result = $this->validate(true)->save($data, [$this->pk=>$data['id']]);
        // 判断输出信息
        if ($result === false) {
            return ['valid' => 0, 'msg' => $this->getError()];
        } else {
            return ['valid' => 1, 'msg' => '编辑成功'];
        }
    }
}
