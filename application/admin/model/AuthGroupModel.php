<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/19
 * Time: 12:46
 */
namespace app\admin\model;
use think\Model;
use think\Db;
use think\config;

class AuthGroupModel extends Model
{
    private static $table_name = 'auth_group';

    /**
     * 获取用户角色信息
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getGoupInfo(){
        $where['is_delete'] = 0;
        $result = Db::name(self::$table_name)
            ->where($where)
            ->field('id,title,pid')
            ->order('id desc')
            ->select();
        return $result;
    }

    /**
     *  根据父级ID获取角色信息
     * @param $pid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getGroupByPID($pid){
        $where['is_delete'] = 0;
        $where['pid'] = $pid;
        $result = Db::name(self::$table_name)
            ->where($where)
            ->field('id,title,pid')
            ->select();
        return $result;
    }

    /**
     * 获取分页数据
     * @return \think\Paginator
     */
    public static function getForPage(){
        $where['is_delete'] = 0;
        $paginate = Config::get('paginate');
        $result = Db::name(self::$table_name)
            ->where($where)
            ->order('id desc')
            ->paginate($paginate['list_rows']);
        return $result;
    }

    /**
     * 获取所有数据
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAll(){
        $where['is_delete'] = 0;
        $result = Db::name(self::$table_name)
            ->where($where)
            ->order('id desc')
            ->select();
        return $result;
    }

    /**
     * 根据名称获取数据
     * @param $title
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getByTitle($title){
        $result = Db::name(self::$table_name)
            ->where('title',$title)
            ->find();
        return $result;
    }

    /**
     * 插入数据
     * @param $data
     * @return int|string
     */
    public static function insertData($data){
        $result = Db::name(self::$table_name)
            ->insert($data);
        return $result;
    }

    /**
     * 根据ID获取数据
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getByID($id){
        $result = Db::name(self::$table_name)->find($id);
        return $result;
    }

    public static function getByIDs($ids){
        $result = Db::name(self::$table_name)
            ->where("id in ($ids) and is_delete = 0")
            ->order('id desc')
            ->select();
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