<?php
namespace app\admin\controller;

use \think\Db;
use \think\Reuquest;
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
 		dump($data);
 	}
	
}