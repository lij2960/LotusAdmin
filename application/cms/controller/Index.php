<?php
namespace app\cms\controller;

use think\Controller;
use think\Db;
class Index extends Controller
{
    function test()
    {
        $arr = Db::name('auth_rule')
        	->select();
        dump($this->array2level($arr));
    }
    function array2level($array,$pid=0,$level=1){
    	static $list = [];
    	foreach($array as $v){
    		if($v['pid']==$pid){
    			$v['level'] = $level;
    			$list[]     = $v;
    			dump($list);
    			$this->array2level($array, $v['id'], $level + 1); 
    		}
    	}
    	return $list;
    }
    function array2tree($array,$pid='pid',){
        if(){

        }
    }


}
