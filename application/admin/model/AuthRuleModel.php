<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/20
 * Time: 13:14
 */

namespace app\admin\model;


use think\Model;
use think\Db;
use think\Session;

class AuthRuleModel extends Model
{
    private static $table_name = 'auth_rule';

    /**
     * 获取所有数据
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAll(){
        $admin_id = Session::get("user_id");
        if ($admin_id == 1){
            $where['is_delete'] = 0;
            $result = Db::name(self::$table_name)
                ->where($where)
                ->order(['sort' => 'DESC', 'id' => 'ASC'])
                ->select();
        }else{
            $role_id = AuthGroupAccessModel::getRoleIDbyUserID($admin_id);
            $group_info = AuthGroupModel::getByID($role_id);
            $rules = $group_info['rules'];
            $result = Db::name(self::$table_name)
                ->where("id in ($rules) and is_delete = 0")
                ->order(['sort' => 'DESC', 'id' => 'ASC'])
                ->select();
        }

        return $result;
    }

    /**
     * 根据ID获取信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getById($id){
        $result = Db::name(self::$table_name)
                    ->where('id',$id)
                    ->find();
        return $result;
    }

    /**
     * 根据ID更新数据
     * @param $id
     * @param $data
     * @return int|string
     */
    public static function updateByID($id,$data){
        $result = Db::name(self::$table_name)
                    ->where('id',$id)
                    ->update($data);
        return $result;
    }
}