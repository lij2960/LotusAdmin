<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/17
 * Time: 16:42
 */
namespace app\admin\model;
use think\Model;
use think\Db;
use think\config;

class UserModel extends Model
{
    private static $table_name='user';

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getUserByName($username){
        $where['username'] = $username;
        $where['is_delete'] = 0;
        $result = Db::name(self::$table_name)
                    ->where($where)
                    ->find();
        return $result;
    }

    /**
     * 根据用户名更新用户信息
     * @param $username
     * @param $data|\要更新的数组信息
     * @return int|string
     */
    public static function updateByName($username,$data){
        $result = Db::name(self::$table_name)
            ->where('username',$username)
            ->update($data);
        return $result;
    }

    /**
     * 获取用户列表
     * @return \think\Paginator
     */
    public static function getList(){
        $where['is_delete'] = 0;
        $paginate = Config::get('paginate');
        $data = Db::name(self::$table_name)
                    ->where($where)
                    ->order('id asc')
                    ->paginate($paginate['list_rows']);
        return $data;
    }

    /**
     * 联合角色查询用户信息
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getListUnionGroup(){
        $where['a.is_delete'] = 0;
        $paginate = Config::get('paginate');
        $result = Db::name(self::$table_name)
            ->alias('a')
            ->join('auth_group_access b','b.uid=a.id','left')
            ->field('a.*,b.group_id')
            ->where($where)
            ->paginate($paginate['list_rows']);
        return $result;
    }

    /**
     * 插入用户数据
     * @param $data
     * @return int|string
     */
    public static function insertUser($data){
        $result = Db::name(self::$table_name)
                    ->insert($data);
        return $result;
    }

    /**
     * 获取最后插入数据的ID
     * @return string
     */
    public static function getLastInsertID(){
        $result = Db::name(self::$table_name)->getLastInsID();
        return $result;
    }

    /**
     * 根据用户ID获取用户信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getUserByIDJoinAuthGroupAccess($id){
        $result = Db::name(self::$table_name)
                    ->alias('a')
                    ->join('auth_group_access b','b.uid=a.id','left')
                    ->field('a.*,b.group_id')
                    ->where('id', $id)
                    ->find();
        return $result;
    }

    /**
     * 根据角色ID获取用户信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getUserByGoupID($id){
        $where['a.is_delete'] = 0;
        $where['b.group_id'] = $id;
        $result = Db::name(self::$table_name)
            ->alias('a')
            ->join('auth_group_access b','b.uid=a.id','left')
            ->field('a.*,b.group_id')
            ->where($where)
            ->find();
        return $result;
    }

    /**
     * 根据ID 更新用户信息
     * @param $id
     * @param $data
     * @return int|string
     */
    public static function updateUserByID($id,$data){
        $result = Db::name(self::$table_name)
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

    /**
     * 根据用户ID获取用户信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getUserByID($id){
        $result = Db::name(self::$table_name)
            ->where('id',$id)
            ->find();
        return $result;
    }

    /**
     * 根据角色ID字符串获取用户信息
     * @param $group_ids
     * @return \think\Paginator
     */
    public static function getUserByGroupIDS($group_ids){
        $paginate = Config::get('paginate');
        $result = Db::name(self::$table_name)
            ->alias('a')
            ->join('auth_group_access b','b.uid=a.id','left')
            ->field('a.*,b.group_id')
            ->where("b.group_id in ($group_ids) and is_delete=0")
            ->paginate($paginate['list_rows']);
        return $result;
    }
}
