<?php
namespace app\admin\controller;

use \think\Db;
use \think\Reuquest;
use \app\admin\model\Api as ApiModel;
use \app\admin\model\App as AppModel;

class api extends Main
{
	//app相关
	function app_list(){
		$data = Db::name('app')->paginate('10');
		$this->assign('data',$data);
		return $this->fetch('app_list');
	}

	function show_add_app(){
		return $this->fetch('add_app');
	}

	function add_app(){
		$post = $this->request->post();
		$model = new AppModel();
		$result  =  $model->validate('app')->save($post);
		if(false===$result){
			$this->error($model->getError());
		}else{
			$this->success('success');	
		}
	}
	function show_edit_app($id){
		$data   = Db::name('app')
		->where('id',$id)
		->find();
		return $this->fetch('edit_app',['data'=>$data]);
	}

	function edit_app(){
		$post = $this->request->post();
		$model = new AppModel();
		$res =  $model->validate('app')->save($post,['app_id'=>$post['app_id']]);
		if(false===$res){
			$this->error($model->getError());
		}else{
			$this->success('success');
		}
	}

    function delete_app(){
    	$id = $this->request->post('id');
    	$model  = new AppModel();
    	AppModel::destroy($id);
    	$this->success('success');
    } 
	//api相关
	function index(){
		$data =  Db::name('api')->paginate('10');
		$this->assign('data',$data);
		return $this->fetch();
	}
	function showAddApi(){
		return $this->fetch('add_api');
	}
	function show_edit_api($id){
		$data = Db::name('api')->find($id);
		return $this->fetch('edit_api',['data'=>$data]);
	}
 	function addApi(){
 		$post = $this->request->post();
 		$model = new ApiModel();
 	    $res =  $model->validate('api')->save($post);
 		if(false===$res){
 			$this->error($model->getError());
 		}else{
 			$this->success('success');
 		}
 	}
 	function edit_api(){
 		$post =  $this->request->post();
 		$model  = new ApiModel();
 		if(!in_array('is_token', $post)){
 				$model->is_token = 0;
 		}
 		$result = $model->validate('api')->save($post,['id'=>$post['id']]);
 		if(false===$result){
 			$this->error($model->getError());
 		}else{
 			$this->success('success');
 		}
 	}

 	function change_status(){
 		$post = $this->request->post();
 		if($post['is_token']=='1'){
 			Db::name('api')->where('id',$post['id'])->update(['is_token'=>0]);
 			$this->success('禁用成功');
 		}else{
 			Db::name('api')->where('id',$post['id'])->update(['is_token'=>1]);
 			$this->success('启用成功');
 		}
 	}

 	function delete_api(){
 		$id = $this->request->post('id');
 		$model  = new ApiModel();
    	ApiModel::destroy($id);
    	$this->success('delete success');
 	}

 	function param($id){
 		$data = Db::name('api')->where('id',$id)->field('key,value')->find();
 		return $this->fetch('param',['api_id'=>$id]);
 	}

 	function add_param(){
 		$post = $this->request->post();
 		$id = $post['api_id'];
 		unset($post['api_id']);
 		$a = count(explode('-', $post['key']));
 		$b = count(explode('-', $post['value']));
 		if($a!==$b){
 		 	 $this->error('参数与值数量不匹配');
 		 }else{
 		 	Db::name('api')
 		 		->where('id',$id)
 		 		->update(['key'=>$post['key'],'value'=>$post['value']]);
 		 	$this->success('测试参数添加成功');
 		 }
 	}
 	
}