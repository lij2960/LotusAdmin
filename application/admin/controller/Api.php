<?php
namespace app\admin\controller;

use \think\Db;
use \think\Reuquest;
use \think\Model;

class api extends Main
{
	function index(){
		return $this->fetch();
	}
	function showAddApi(){
		return $this->fetch();
	}
 	function addApi(){
 		$data = $this->request->post();
 		$api = new Api();
 		var_dump($api);
 	}
 	
}