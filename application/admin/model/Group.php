<?php

namespace app\admin\model;

use think\Model;

class Group extends Model
{
    //定义主键
    protected $pk = 'id';
    // 定义数据表
    protected $table = 'blog_auth_group';

    /**
     * 用户组添加操作
     * @param $data
     * @return array
     */
    public function store ($data)
    {
        // 接收规则id,并且以逗号分割成为字符串存入数据库
        $data['rules'] = isset($data['rules'])? implode(',', $data['rules']) : '';
        // 验证数据
        $result = $this->validate(true)->save($data);
        if ($result === false) {
            return ['valid' => 0, 'msg' => $this->getError()];
        } else {
            return ['valid' => 1, 'msg' => '添加成功'];
        }
    }

    /**
     * 用户组编辑操作
     * @param $data
     * @return array
     */
    public function edit ($data)
    {
        // 接收规则id,并且以逗号分割成为字符串存入数据库
        $data['rules'] = isset($data['rules'])? implode(',', $data['rules']) : '';
        // 验证数据
        $result = $this->validate(true)->save($data, [$this->pk=>$data['id']]);
        if ($result === false) {
            return ['valid' => 0, 'msg' => $this->getError()];
        } else {
            return ['valid' => 1, 'msg' => '编辑成功'];
        }
    }
}
