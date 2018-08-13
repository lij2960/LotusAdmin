<?php
namespace app\admin\controller;

use app\admin\model\AuthGroupAccessModel;
use app\admin\model\AuthGroupModel;
use think\Session;
use org\Auth;
use app\admin\model\UserModel;

class User extends Main
{
    public function index(){
        return $this->fetch('admin/login/index');
    }

    //注销
    public function logOut()
    {
        session('username', null);
        $this->redirect("admin/index/index");
    }

    public function userlist()
    {
        $this->auth(Constant::index_user);
        $admin_id = Session::get('user_id');
        if ($admin_id == 1){
            $data = UserModel::getListUnionGroup();
        }else{
            $role_ids = $this->getRoleIdsByAdminID($admin_id);
            $data = UserModel::getUserByGroupIDS($role_ids);
        }

        //验证权限
        $auth = new Auth();
        $edit_user = $auth->check(Constant::edit_user, $admin_id);
        $del_user = $auth->check(Constant::del_user, $admin_id);
        $add_user = $auth->check(Constant::add_user, $admin_id);

        $this->assign('users', $data);
        $this->assign('edit_user', $edit_user);
        $this->assign('del_user', $del_user);
        $this->assign('add_user', $add_user);
        return $this->fetch();
    }
    //打开新增界面
    public function showAdd()
    {
        $this->auth(Constant::add_user);
        $auth_group = AuthGroupModel::getGoupInfo();
        $auth_group = array2level($auth_group);
        return $this->fetch('add',['auth_group'=>$auth_group]);
    }
    //增加用户
    public function addUser()
    {
        $post     = $this->request->post();
        $group_id = $post['group_id'];
        unset($post['group_id']);
        $validate = validate('User');
        $res      = $validate->check($post);
        if ($res !== true) {
            $this->error($validate->getError());
        } else {
            unset($post['check_password']);
            $salt = randomStr(4);
            $post['password'] = passwordStr($post['password'],$salt);
            $post['last_login_ip'] = '0.0.0.0';
            $post['create_time']   = date('Y-m-d h:i:s', time());
            $post['salt'] = $salt;
            $db = UserModel::insertUser($post);
            $userId = UserModel::getLastInsertID();

            $data['uid'] = $userId;
            $data['group_id'] = $group_id;
            AuthGroupAccessModel::insertData($data);
            $this->success('success');
        }
    }
    //编辑页面
    public function edit($id)
    {
        $this->auth(Constant::edit_user);
        $data = UserModel::getUserByIDJoinAuthGroupAccess($id);
        $auth_group = AuthGroupModel::getGoupInfo();
        $auth_group = array2level($auth_group);
        $this->assign('auth_group', $auth_group);
        $this->assign('data', $data);
        return $this->fetch();
    }
    //编辑提交
    public function editUser()
    {
        $post     = $this->request->post();
        if($post['id']==1){
            $this->error('系统管理员无法修改');
        }
        $group_id = $post['group_id'];
        unset($post['group_id']);
        $validate = validate('User');
        if (empty($post['password']) && empty($post['check_password'])) {
            $res = $validate->scene('edit')->check($post);
            if ($res !== true) {
                $this->error($validate->getError());
            } else {
                unset($post['password']);
                unset($post['check_password']);
                $data['username'] = $post['username'];
                $data['email'] = $post['email'];
                $db = UserModel::updateUserByID($post['id'],$data);
                AuthGroupAccessModel::updateByUID($post['id'],$group_id);
                $this->success('编辑成功');
            }
        } else {
            $res = $validate->scene('editPassword')->check($post);
            if ($res !== true) {
                $this->error($validate->getError());
            } else {
                unset($post['check_password']);
                $salt = randomStr(4);
                $post['password'] = passwordStr($post['password'],$salt);
                $post['salt'] = $salt;
                $db               =  UserModel::updateUserByID($post['id'],$post);
                $this->success('编辑成功');
            }
        }
    }
    //删除用户
    public function deleteUser()
    {
        $this->auth(Constant::del_user);
        $id = $this->request->post('id');
        $user_info = UserModel::getUserByID($id);
        if ((int) $id !== 1) {
            if($user_info['username']!==session('username')){
                $data['is_delete'] = 1;
                $db = UserModel::updateUserByID($id,$data);
                $this->success('删除成功');
            }else{
                 $this->error('无法删除当前登录用户');
            }
        } else {
            $this->error('超级管理员无法删除');
        }
    }

    //个人信息
    public function detail(){
        $admin_id = Session::get('user_id');
        $user_info = UserModel::getUserByID($admin_id);
        $this->assign('user_info', $user_info);
        return $this->fetch();
    }

    //修改密码
    public function updatePWD(){
        return $this->fetch();
    }

    public function doUpdatePWD(){
        $post     = $this->request->post();

        $admin_id = Session::get('user_id');
        $user_info = UserModel::getUserByID($admin_id);

        $old_password = passwordStr($post['old_password'],$user_info['salt']);

        if ($old_password != $user_info['password']){
            $this->error("原密码输入错误");
        }else{
            $validate = validate('User');
            $res = $validate->scene('editOnlyPassword')->check($post);
            if ($res !== true) {
                $this->error($validate->getError());
            } else {
                unset($post['check_password']);
                unset($post['old_password']);
                $salt = randomStr(4);
                $post['password'] = passwordStr($post['password'],$salt);
                $post['salt'] = $salt;
                $db               =  UserModel::updateUserByID($admin_id,$post);
                session('username', null);
                $this->success('编辑成功');
            }
        }

    }

}
