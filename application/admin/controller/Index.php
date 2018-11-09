<?php
namespace app\admin\controller;

use think\Db;

class Index extends Commom
{
    public function index()
    {
        //加载页面
       return view();
    }
    /*
     * 后台首页面
     */
    public function system(){
        //获取服务器信息
        $system=[
                'ip'=>$_SERVER['REMOTE_ADDR'],//获取服务器ip地址
                //服务器域名
                'host'=>$_SERVER['SERVER_NAME'],
                //服务器操作系统
                'os'=>php_uname('s'),
                //运行环境
                'server'=>$_SERVER['SERVER_SOFTWARE'],
                //服务器端口
                'port'=>$_SERVER['SERVER_PORT'],
                //php版本
                'php_ver'=>PHP_VERSION,
                //数据库版本
                'mysql_version'=>Db::query('select version()')[0]['version()'],
                // 数据库名称
                'database'=>config('database')['database'],
            ];
        //分配数据
        $this->assign('system',$system);
        return view();
    }
}
