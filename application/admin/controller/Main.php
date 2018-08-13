<?php
namespace app\admin\controller;

use app\admin\model\AuthGroupAccessModel;
use app\admin\model\AuthGroupModel;
use app\admin\model\UserModel;
use org\Auth;
use think\Controller;
use think\Db;
use think\Session;

class Main extends Controller
{
    public function _initialize()
    {
        $username  = session('username');
        if (empty($username)) {
            $this->redirect('admin/login/index');
        }
        $this->getMenu();
    }
    /**
     * 获取侧边栏菜单
     */
    protected function getMenu()
    {

//        import('org.PHPExcel');
//        $excel = new \PHPExcel();
//        print_r($excel);exit;

        $menu           = [];
        $admin_id       = Session::get('user_id');
        $auth           = new Auth();
        $auth_rule_list = Db::name('auth_rule')->where('status', 1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();
        foreach ($auth_rule_list as $value) {
            if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
                $menu[] = $value;
            }
        }
        $menu = !empty($menu) ? array2tree($menu) : [];
        $this->assign('menu', $menu);
    }

    /**
     * 验证用户操作权限
     * @param $action
     */
    public function auth($action){
        $admin_id = Session::get('user_id');
        $auth = new Auth();
        if (empty($admin_id) || !$auth->check($action, $admin_id)) {
            $this->redirect('admin/index/index');
            exit;
        }
    }

    /**
     * 根据用户ID获取其下属所有角色ID
     * @param int $admin_id
     * @return string
     */
    public function getRoleIdsByAdminID($admin_id = 0){
        if($admin_id == 0){
            $admin_id = Session::get('user_id');
        }
        $user_info = UserModel::getUserByID($admin_id);
        $role_id = AuthGroupAccessModel::getRoleIDbyUserID($user_info['id']);

        //目前是一个用户对应一个角色ID
        $role_ids = $this->getRoles($role_id['group_id']);
        return $role_ids;
    }

    private $str = "";
    private $initI = 0;
    /**
     * 递归获取角色ID
     * @param $role_id
     * @param $str
     * @return string
     */
    public function getRoles($role_id,$str=""){
        if($this->initI){
            $this->str = $str . "," . $role_id;
        } else {
            $this->str = $role_id;
        }
        $this->initI = $this->initI + 1;
        $group_info = AuthGroupModel::getGroupByPID($role_id);
        if (is_array($group_info)){
            foreach ($group_info as $value){
                $this->getRoles($value['id'],$this->str);
            }
        }
        return $this->str;
    }
}
