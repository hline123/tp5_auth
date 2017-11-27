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
 * 规则验证器类
 * Class Admin
 * @package app\admin\validate
 */
class Rules extends Validate
{
    protected $rule = [
        'title'=>'require',
        'name'=>'require',
        'nav'=>'require'
    ];
    protected $message = [
        'title.require'=>'请输入规则中文名称',
        'name.require'=>'请输入规则标识',
        'nav.require'=>'请输入导航菜单'
    ];
}