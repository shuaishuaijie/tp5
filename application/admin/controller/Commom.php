<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/11/7
 * Time: 20:36
 */

namespace app\admin\controller;


use think\Controller;

class Commom extends Controller
{
    protected function _initialize()
    {
        parent::_initialize(); // 继承父类的初始化方法
        //登录验证  这里加一个loginid
        if(!session('loginname','','admin')){
            $controller=$this->request->controller();
            $action=$this->request->action();
            if($controller==='Index'&&$action==='index'){
                $this->redirect('login/index');
            }
            $this->error('未登录不允许访问','login/index');

        }
    }
}