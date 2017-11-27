<?php

namespace app\admin\model;

use think\Model;

class Groupaccess extends Model
{
    //定义数据表
    protected $table = 'blog_auth_group_access';

    /**
     * 设置用户权限
     * @param $data
     * @return array
     */
    public function setAuth($data)
    {
        // 验证用户组
        if (!isset($data['group_id'])) {
            return ['valid' => 0, 'msg' => '请选择用户组'];
        }
        // 判断当前用户权限是否已存在
        $find = $this->where('uid', $data['admin_id'])->find();
        if ($find) {
            //将原先数据先删除
            $this->where('uid', $data['admin_id'])->delete();
        }
        //执行数据添加
        foreach($data['group_id'] as $k=>$v){
            $model = new Groupaccess();
            $model->uid = $data['admin_id'];
            $model->group_id = $v;
            $model->save();
        }
        return ['valid'=>1,'msg'=>'操作成功'];
    }
}
