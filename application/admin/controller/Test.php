<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/20
 * Time: 16:12
 */

namespace app\admin\controller;


use think\Controller;
use think\Validate;

class Test extends Controller
{
    public function index(){
        echo randomStr(4);
    }
}