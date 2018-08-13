<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/20
 * Time: 15:26
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\UserModel;
use think\captcha\Captcha;

class Login extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function verify(){
        $captcha = new Captcha();
        $captcha->fontSize = 15;
        $captcha->imageH = 50;
        $captcha->imageW = 110;
        $captcha->length   = 4;
        $captcha->useNoise = false;
        return $captcha->entry();
    }

    public function login()
    {
        $post     = $this->request->post();
        if(empty($post)){
            $this->redirect('index');
        }

        if(!captcha_check($post['verify'])){
            $this->error('验证码输入错误！');
            $this->redirect('index');
        }

        $validate = validate('User');
        $validate->scene('login');
        $username  =  $post['username'];
        $user_info = UserModel::getUserByName($username);
        if (!$validate->check($post)) {
            $this->error($validate->getError());
        } else {
            if (passwordStr($post['password'],$user_info['salt']) !== $user_info['password']) {
                $this->error('密码错误');
            } else {
                session('username', $post['username']);
                session('user_id', $user_info['id']);
                //更新登录信息
                $data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $data['last_login_time'] = date('Y-m-d h:i:s',time());
                UserModel::updateByName($username,$data);
                $this->success('登陆成功', 'admin/index/index');
            }
        }
    }
}