<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2018/11/4
 * Time: 20:58
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller {
    public function index(){
        //判断是否为post提交
        if(request()->isPost())
        {
            //接收数据
            $data=input('post.');
            $result=$this->logincheck($data);
        }
        if(session('loginname','','admin')){
            $this->redirect('index/index');
        }
        //加载页面
        return view();
    }
    /*
     *  登录验证
     */
    protected function logincheck($data){
        //场景验证
        $validate=validate('Manager');
        if(!$validate->scene('login')->check($data)){
            $this->error($validate->getError());
        }
        //数据库验证
        $res=db('admin')->where('aid',$data['aid'])->find();
        if(!$res){
            $this->error('用户名不存在');
        }
        //验证密码
        if(md5($data['password'])!=$res['password']){
            $this->error('密码输入错误');
        }
        //验证状态
        if(!$res['status']){
            $this->error('此账号已锁定请联系系统管理员');
        }
        //保存session(作用域为后台)
        session('loginname',$res['aid'],'admin');
        //这里保存id
        $this->success('登录成功','index/index');

    }
    /*
     * 退出登录
     */
    public function logout(){
        session(null,'admin');
        $this->success('退出成功','login/index');
    }
}