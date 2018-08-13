<?php
namespace app\index\controller;

use \think\Controller;
class Index extends Common
{
    public function index()
    {
        echo "前台首页";exit;
      return $this->fetch();
    }
    public function test($id,$name){
    	var_dump($id.$name);
    }
}
