<?php
namespace app\admin\validate;

use think\Validate;
use think\captcha\Captcha;

class User extends Validate
{
    protected $rule = [
        'username'       => 'require|min:5|max:30|unique:user',
        'password'       => 'require|min:5|max:30',
        'email'          => 'require|email|unique:user',
        'check_password' => 'require|confirm:password',
    ];
    protected $message = [
        'email.unique'           => '邮箱已存在，请更换邮箱',
        'username.require'       => '用户名必须',
        'username.unique'        => '用户名重复',
        'username.min'           => '用户名最短6位',
        'username.max'           => '用户名最长30位',
        'password.require'       => '密码必须',
        'password.min'           => '密码最短6位',
        'password.max'           => '密码最长30位',
        'check_password.require' => '请输入确认密码',
        'check_password.confirm' => '输入密码与确认密码不一致',
    ];
    protected $scene = [
        'login' => [
            'username' => 'require|min:5|max:30',
            'password'
        ],
        'edit'  => [
            'username' => 'require|min:5|max:30|unique:user',
            'email'    => 'require|email',
        ],
        'editPassword'  => [
            'username' => 'require|min:5|max:30|unique:user',
            'email'    => 'require|email',
            'password',
            'check_password',
        ],
        'editOnlyPassword'  => [
            'password',
            'check_password',
        ],
    ];
}
