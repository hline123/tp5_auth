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
 * 管理员验证器类
 * Class Admin
 * @package app\admin\validate
 */
class Admin extends Validate
{
    protected $rule = [
        'admin_username' => 'require',
        'admin_password' => 'require',
    ];

    protected $message = [
        'admin_username.require' => '请输入用户名',
        'admin_password.require' => '请输入密码',
    ];
}