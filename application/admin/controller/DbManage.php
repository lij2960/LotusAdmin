<?php
namespace app\admin\controller;

use think\Db;
class DbManage extends Main
{
  function index(){
    $db_names =  Db::getTables();
    $this->assign('db_names',$db_names);
    return $this->fetch();
  }


}
