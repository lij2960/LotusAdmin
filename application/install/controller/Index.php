<?php
/**
 * Created by PhpStorm.
 * User: 李杰
 * Date: 2017/11/22
 * Time: 9:54
 */

namespace app\install\controller;

use think\Config;
use \think\Controller;
use app\install\controller\CFunction;
use think\Session;
use think\Db;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function step1()
    {
        $result = [];

        //检查文件夹权限
        $runtime = ROOT_PATH . "runtime";
        $data = ROOT_PATH . "data";

        if (is_writable($runtime)) {
            $result['runtime'] = 1;
        } else {
            $result['runtime'] = 0;
        }

        if (is_writable($data)) {
            $result['data'] = 1;
        } else {
            $result['data'] = 0;
        }
        $this->assign('result', $result);

        return $this->fetch();
    }

    public function step2()
    {
        $dbConfig = [];
        $config = Config::get('database');
        $dbConfig['type'] = $config['type'];
        $dbConfig['hostname'] = $config['hostname'];
        $dbConfig['username'] = $config['username'];
        $dbConfig['password'] = $config['password'];
        $dbConfig['hostport'] = $config['hostport'];
        $dbConfig['charset'] = $config['charset'];
        $dbConfig['database'] = $config['database'];

        $sql_file = ROOT_PATH . "application/install/data/install.sql";
        $sqls = CFunction::splitSql($sql_file, $config['database'], $config['prefix']);
        $num = count($sqls);
        $res = "";
        $result = CFunction::checkDatabase($dbConfig);
        if ($result == $dbConfig['database']) {
            $res = "yes";
        } else {
            $res = $result;
        }
        $this->assign("res", $res);
        return $this->fetch();
    }

    public function step3()
    {
        $config = Config::get('database');
        $sql_file = ROOT_PATH . "application/install/data/install.sql";
        $sqls = CFunction::splitSql($sql_file, $config['database'], $config['prefix']);
        if (is_array($sqls)) {
            set_time_limit ( 0 );
            ob_end_clean ();
            ob_start ();

            $html_file = ROOT_PATH . "application/install/view/index/step3.html";
            $html = file_get_contents($html_file);
            echo $html;

            //验证数据库属性
            $result = CFunction::checkDatabase($config);
            if ($result != $config['database']) {
                echo '
                        <script>
                            $("#info").html("请根据合法流程安装");
                        </script>
                        ';
                exit;
            }

            $count = count($sqls);
            $i = 0;

            //建立sql连接
            $link = @mysqli_connect($config['hostname'].":".$config['hostport'],$config['username'],$config['password']);
            foreach ($sqls as $value) {
                $i++;

                //执行sql语句
                $result = mysqli_query($link,$value);

                //输出进度至前端
                $persent = CFunction::showPercent($i,$count);
                if ($persent < 100){
                    echo '
                        <script>
                            $("#info").html("安装进度："+'.$persent.'+"%");
                            function next() {
                              layer.msg("请耐心等待安装完成",{});
                            }
                        </script>
                        ';
                }else{
                    //创建锁定文件
                    $lock_file_path = ROOT_PATH . "data/install.lock";
                    fopen($lock_file_path, "w");

                    echo '
                    <script>
                    $("#info").html("安装进度："+'.$persent.'+"%<br />安装完成，请删除install目录！");
                        function next() {
                           location.href = "/admin/index/index";
                        }
                    </script>
                    ';
                }

                ob_flush ();
                flush ();
            }
        } else {
            $this->error("数据库执行文件不存在");
        }
    }
}