<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2018/11/22
 * Time: 21:27
 */

namespace app\index\controller;


use think\Controller;

class Login extends Controller
{
    /*
     * 前台登录首页
     */
    public function index()
    {
       return $this->fetch();
    }
    //
    public function test(){
        return json("ajax成功！");
    }
}