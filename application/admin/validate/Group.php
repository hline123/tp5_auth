<?php
/**
 * Created by PhpStorm.
 * User: huanglin
 * Date: 2017/11/25
 * Time: 10:38
 */

namespace app\admin\validate;

use think\Validate;

/**
 * 用户组验证器类
 * Class Admin
 * @package app\admin\validate
 */
class Group extends Validate
{
    protected $rule = [
        'title' => 'require',
    ];

    protected $message = [
        'title.require' => '请输入用户名'
    ];
}