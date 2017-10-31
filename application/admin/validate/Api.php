<?php
namespace app\admin\validate;

use think\Validate;

class Api extends Validate
{
    protected $rule = [
        'name'     => 'require|min:2|max:15|unique:auth_rule',
    ];
    protected $message = [
    	
    ];
    protected $scene = [
        'edit'  => [
            'title',
            'name',
            'sort',
        ],
    ];
}
