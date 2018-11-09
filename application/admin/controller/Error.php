<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/10/13
 * Time: 18:52
 * 空控制器 空方法  对用户友好 防止恶意输入
 */


namespace app\admin\controller;
//声明控制器

use think\Controller;

class Error extends Controller{
    //空控制器
    public function index(){
        $this->redirect('/admin/index');
    }
    //空方法
    public function _empty(){
        $this->redirect('/admin/index');
    }
}