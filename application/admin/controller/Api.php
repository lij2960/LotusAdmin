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
 		$data = Db::name('api')->where('id',$id)->field('param')->find();
 		return $this->fetch('param',['api_id'=>$id,'data'=>$data]);
 	}

 	function edit_param(){
 		$post = $this->request->post();
 		$id = $post['api_id'];
 		Db::name('api')
 		 		->where('id',$id)
 		 		->update(['param'=>$post['param']]);
 		$this->success('测试参数添加成功');
 	}

 	function doTest(){
 		$id   = $this->request->post('id');
 		$data = Db::name('api')
 				->where('id',$id)
 				->field('param,base_url,method')
 				->find();
 		if($data['method']=='post'){
 			$post_data = json_decode($data['param']);
 			$this->curl_post($data['base_url'],$post_data);	
 		}else{
 			$get_data = json_decode($data['param']);
 			$this->curl_get($url);
 		}
 	}

 	function curl_get($url){
 		$ch = curl_init();
	　　//设置选项，包括URL
	　　curl_setopt($ch, CURLOPT_URL, $url);
	　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	　　curl_setopt($ch, CURLOPT_HEADER, 0);
	　　//执行并获取HTML文档内容
	　　$output = curl_exec($ch);
	　　//释放curl句柄
	　　curl_close($ch);
	　　//打印获得的数据
	　　return json($output);
 	}

 	function curl_post($url,$post_data){
 			// $url = "http://localhost/web_services.php";
		    // $post_data = array ("username" => "bob","key" => "12345");
		　　$ch = curl_init();
		　　curl_setopt($ch, CURLOPT_URL, $url);
		　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		　　// post数据
		　　curl_setopt($ch, CURLOPT_POST, 1);
		　　// post的变量
		　　curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		　　$output = curl_exec($ch);
		　　curl_close($ch);
		　　//打印获得的数据
		　　return json($output);
 	}

}