<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/17
 * Time: 15:57
 */
namespace app\admin\controller;
class Constant{
    //用户操作定义
    const index_user = 'admin/user/userlist'; //用户列表
    const add_user = 'admin/user/showAdd'; //添加用户
    const edit_user = 'admin/user/edit'; //编辑用户
    const del_user = 'admin/user/deleteUser'; //删除用户

    //权限管理
    const index_auth = 'admin/auth/index'; //菜单列表
    const add_auth = 'admin/auth/showAdd'; //添加菜单
    const edit_auth = 'admin/auth/showEdit'; //编辑菜单
    const del_auth = 'admin/auth/delete'; //删除菜单

    //角色管理
    const index_role = 'admin/auth/showRole'; //角色列表
    const add_role = 'admin/auth/addRole'; //添加角色
    const auth_role = 'admin/auth/showAuth'; //角色赋权
    const edit_role = 'admin/auth/showRoleEdit'; //编辑角色
    const del_role = 'admin/auth/delRole'; //删除角色
}