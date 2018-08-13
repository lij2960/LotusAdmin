<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/19
 * Time: 12:58
 */

namespace app\admin\model;


use think\Model;
use think\Db;

class AuthGroupAccessModel extends Model
{
    private static $table_name = 'auth_group_access';

    /**
     * 插入数据
     * @param $data
     * @return mixed
     */
    public static function insertData($data){
        $result = Db::name(self::$table_name)
            ->insert($data);
        return $result;
    }

    /**
     * 根据UID更新信息
     * @param $uid
     * @param $group_id
     * @return mixed
     */
    public static function updateByUID($uid,$group_id){
        $result = Db::name(self::$table_name)
            ->where('uid',$uid)
            ->update(['group_id'=>$group_id]);
        return $result;
    }

    /**
     * 根据用户ID获取角色ID
     * @param $uid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRoleIDbyUserID($uid){
        $result = Db::name(self::$table_name)
            ->where('uid',$uid)
            ->find();
        return $result;
    }

    public static function getUIDSByGroupIDs($group_ids){
        $result = Db::name(self::$table_name)
            ->where("group_id in ($group_ids)")
            ->select();
        return $result;
    }
}