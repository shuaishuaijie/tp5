<?php
// 声明命名空间
namespace app\index\controller;

use think\Controller;
use think\Request;

class Index extends Controller
{
    /**
     * 后台登录首页
     */
    public function index()
    {
        //加载页面
        return $this->fetch();

    }
}
