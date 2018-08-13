<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/23
 * Time: 9:52
 */

namespace app\install\controller;

class CFunction
{
    /**
     * 验证数据库用户名密码是否正确，数据库名是否存在
     * @param $dbConfig
     * @return string
     */
    public static function checkDatabase($dbConfig){
        $res = "";
        if(function_exists("mysql_close")==1) {
            $link = @mysqli_connect($dbConfig['hostname'].":".$dbConfig['hostport'],$dbConfig['username'],$dbConfig['password']);
            if ($link){
                $result = mysqli_query($link,'show databases');
                While($row = mysqli_fetch_assoc($result)){
                    $data[] = $row['Database'];
                }
                if (in_array(strtolower($dbConfig['database']), $data))
                {
                    $res = "[".$dbConfig['database']."]数据库已存在";
                } else{
                    $res = $dbConfig['database'];
                }
            } else {
                $res = "无法连接到MySql数据库";
            }
        } else {
            $res = "服务器不支持MySQL数据库";
        }
        return $res;
    }

    /**
     * 切分SQL文件成多个可以单独执行的sql语句
     * @param string $file sql文件路径
     * @param string $tableName 数据库名称
     * @param string $tablePre 表前缀
     * @param string $defaultTableName 默认数据库名称
     * @param string $defaultTablePre 默认表前缀
     * @return array
     */
    public static function splitSql($file, $tableName, $tablePre, $defaultTableName = 'lotus', $defaultTablePre = 'sm_')
    {
        if (file_exists($file)) {
            //读取SQL文件
            $sql = file_get_contents($file);
            $sql = str_replace("\r", "\n", $sql);
            $sql = str_replace("BEGIN;\n", '', $sql);//兼容 navicat 导出的 insert 语句
            $sql = str_replace("COMMIT;\n", '', $sql);//兼容 navicat 导出的 insert 语句
            $sql = trim($sql);
            //替换数据库名称
            $sql  = str_replace("`$defaultTableName`", "`$tableName`", $sql);
            //替换表前缀
            $sql  = str_replace(" `{$defaultTablePre}", " `{$tablePre}", $sql);
            $sqls = explode(";\n", $sql);
            return $sqls;
        }

        return [];
    }

    /**
     * 安装进度
     * @param $now
     * @param $total
     * @return string
     */
    public static function showPercent($now,$total)
    {
        $percent = sprintf('%.0f',$now*100/$total);
        return $percent;
    }
}