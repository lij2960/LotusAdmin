<?php
namespace app\admin\controller;

use app\admin\model\AuthGroupAccessModel;
use app\admin\model\AuthGroupModel;
use app\admin\model\UserModel;
use \think\Db;
use \think\Reuquest;
use think\Session;
use app\admin\model\AuthRuleModel;
class auth extends Main
{
    function index(){
        $this->auth(Constant::index_auth);
        //获取权限列表
        $auth_data = AuthRuleModel::getAll();
        $auth_data = array2Level($auth_data);

        //验证权限
        $admin_id = Session::get('user_id');
        $auth = new \org\Auth();
        $edit_auth = $auth->check(Constant::edit_auth, $admin_id);
        $del_auth = $auth->check(Constant::del_auth, $admin_id);
        $add_auth = $auth->check(Constant::add_auth, $admin_id);
        $this->assign('edit_auth', $edit_auth);
        $this->assign('del_auth', $del_auth);
        $this->assign('add_auth', $add_auth);

        return $this->fetch('index',['auth'=>$auth_data]);
    }
    function showAdd(){
        $this->auth(Constant::add_auth);
    	$auth = AuthRuleModel::getAll();
        $auth = array2Level($auth);
    	return  $this->fetch('add',['auth'=>$auth]);
    }
    function add(){
    	$post = $this->request->post();
    	$validate = validate('auth');
    	$res = $validate->check($post);
		if($res!==true){
			$this->error($validate->getError());
		}else{
			Db::name('auth_rule')
			->insert($post);
			$this->success('success');
		}
    }
    function showEdit(){
        $this->auth(Constant::edit_auth);
        $id  = $this->request->get('id');
        $auth = AuthRuleModel::getById($id);
        if($auth['pid']!==0){
            $p_title = $auth['title'];
        }else{
            $p_title = '顶级菜单';
        }
        $this->assign('p_title',$p_title);
        $data  =   AuthRuleModel::getById($id);
        return  $this->fetch('edit',['data'=>$data]);
    }
    function edit(){
        $post =  $this->request->post();
        $id = $post['id'];
        if($id<10){
            $this->error('很抱歉,系统默认权限无法编辑');
        }
        $validate = validate('auth');
        $validate->scene('edit');
        $res = $validate->check($post);
        if($res!==true){
            $this->error($validate->getError());
        }else{
            unset($post['id']);
            AuthRuleModel::updateByID($id,$post);
            $this->success('success');            
        }
    }
    function delete(){
        $this->auth(Constant::del_auth);
        $id = $this->request->post('id');
        $juge = AuthRuleModel::getById($id);
       
        if(!empty($juge)){ 
                $this->error('请先删除子权限'); 
        }else{
            if($id<10){
                 $this->error('重要节点无法删除'); 
            }else{
                $data['is_delete'] = 1;
                AuthRuleModel::updateByID($id,$data);
                $this->success('success');
            }
        }
    }
    function showRole(){
        $this->auth(Constant::index_role);
        $admin_id = Session::get('user_id');
        if ($admin_id == 1){
            $role = AuthGroupModel::getAll();
        }else{
            $role_ids = $this->getRoleIdsByAdminID();
            $role = AuthGroupModel::getByIDs($role_ids);
        }
        $role = array2Level($role);

        //验证权限
        $admin_id = Session::get('user_id');
        $auth = new \org\Auth();
        $edit_role = $auth->check(Constant::edit_role, $admin_id);
        $del_role = $auth->check(Constant::del_role, $admin_id);
        $add_role = $auth->check(Constant::add_role, $admin_id);
        $auth_role = $auth->check(Constant::auth_role, $admin_id);
        $this->assign('edit_role', $edit_role);
        $this->assign('del_role', $del_role);
        $this->assign('add_role', $add_role);
        $this->assign('auth_role', $auth_role);

        $this->assign('role',$role);
        return $this->fetch('role');
    }
    public function addRole(){
        $this->auth(Constant::add_role);
        $auth_group = AuthGroupModel::getGoupInfo();
        $auth_group = array2level($auth_group);
        $this->assign('auth_group',$auth_group);
        return $this->fetch();
    }
    function doAddRole(){
        $auth_group = $this->request->post('title');
        $pid = $this->request->post('pid');
        if(!empty($auth_group)){
            $res =AuthGroupModel::getByTitle($auth_group);
            if(empty($res)){
                $data['title'] = $auth_group;
                $data['pid'] = $pid;
                AuthGroupModel::insertData($data);
                $this->success('添加成功');
            }else{
                $this->error('系统中已经存在该用户名');  
            }
        }else{
            $this->error('请输入角色名称再添加');
        }
    }
    function showAuth($id){
        $this->assign('id',$id);
        return $this->fetch('auth');
    }
    //获取规则数据
    public function getJson()
    {   
        $id = $this->request->post('id');
        $auth_group_data = AuthGroupModel::getByID($id);
        $auth_rules      = explode(',', $auth_group_data['rules']);
        $auth_rule_list  = AuthRuleModel::getAll();

        foreach ($auth_rule_list as $key => $value) {
            in_array($value['id'], $auth_rules) && $auth_rule_list[$key]['checked'] = true;
        }
        return $auth_rule_list;
    }
    /**
     * 更新权限组规则
     * @param $id
     * @param $auth_rule_ids
     */
    public function updateAuthGroupRule()
    {
        if ($this->request->isPost()){
            $post = $this->request->post();
            if($post['id']==1){
               $this->error('超级管理员信息无法编辑'); 
            }
            $group_data['id']    = $post['id'];
            $group_data['rules'] = is_array($post['auth_rule_ids']) ? implode(',', $post['auth_rule_ids']) : '';
            $result = AuthGroupModel::updateByID($post['id'],$group_data);
            if ($result !== false) {
                $this->success('授权成功');
            } else {
                $this->error('授权失败');
            }
        }
    }
    function showRoleEdit($id){
        $this->auth(Constant::edit_role);
        $data = AuthGroupModel::getByID($id);
        $auth_group = AuthGroupModel::getGoupInfo();
        $auth_group = array2level($auth_group);
        $this->assign('auth_group',$auth_group);
        return $this->fetch('roleEdit',['data'=>$data]);
    }
    function editRole(){
        $post = $this->request->post();
        if($post['id']==1){
           $this->error('超级管理员信息无法编辑'); 
        }
        if ($post['id'] == $post['pid']){
            $this->error('父级角色不能与子级角色相同');
        }
        $validate = validate('role');
        $res = $validate->scene('edit')->check($post);
        if(!$res){
            $this->error($validate->getError());
        }else{
            $data['title'] = $post['title'];
            $data['status'] = $post['status'];
            $data['pid'] = $post['pid'];
            AuthGroupModel::updateByID($post['id'],$data);
            $this->success('更新成功');
        }
    }
    function delRole(){
        $this->auth(Constant::del_role);
        $id  = $this->request->post('id');
        //判断删除的角色下是否有用户
        $users = UserModel::getUserByGoupID($id);
        if ($users){
            $this->error('角色下有用户，不允许删除');
        }
        //判断删除的角色下是否有角色
        $cgroup = AuthGroupModel::getGroupByPID($id);
        if ($cgroup){
            $this->error('角色下有子角色，不允许删除');
        }
        if($id!=='1'){
            $data['is_delete'] = 1;
            AuthGroupModel::updateByID($id,$data);
            $this->success('删除成功');
        }else{
            $this->error('超级管理员无法删除');
        }
    }

}
