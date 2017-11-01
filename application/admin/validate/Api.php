<?php
namespace app\admin\validate;

use think\Validate;

class Api extends Validate
{
    protected $rule = [
        'name'     => 'require|min:2|max:15|unique:api',
    ];
    protected $message = [
    	
    ];
    protected $scene = [
        'edit'  => [
            'name',
        ],
    ];
}
