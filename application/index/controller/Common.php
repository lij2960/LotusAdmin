<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/23
 * Time: 17:14
 */

namespace app\index\controller;


use think\Controller;

class Common extends Controller
{
    protected function _initialize()
    {
        //锁定安装文件
        $lock_file_path = ROOT_PATH . "data/install.lock";
        if (!file_exists($lock_file_path)){
            $this->redirect('install/index/index');
        }
    }
}