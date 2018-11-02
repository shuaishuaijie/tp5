<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2018/10/13
 * Time: 19:58
 */
namespace app\index\controller;

use think\Request;

//导入系统控制器类
use think\Controller;
//引入系统类
use think\Db;

class Login extends Controller {

    //加载首页
    public function index(){
        return view();
    }

    //登录检查
    public function check(Request $request){

        if(Request::instance()->isPost())       //判断是否为post请求
        {
            $user = input('post.');
            //转实体 对引号过滤
            $request->filter(["htmlspecialchars","strip_tags"]);

            $username=$user['username'];
            $password=md5($user['password']);

            //获取学号 密码
            $username=$request->post("username");
            $password=$request->post("password");
            //密码加密
            $md5password=md5($password);
            //查询数据
            $data=DB::name('admin')->where(['aid' =>$username])->find();
            if(empty($data)){
                $this->error('账号不存在，请重新输入');
            }else{
                if($data['status']==2){
                    $this->error('此账号已被禁用，请联系系统管理员');
                }
                if($md5password!=$data['password']){
                    $this->error('密码错误');
                }

                if(($username==$data['aid'])&&($md5password==$data['password'])){
                    //存入session
                    session('user', $user);
                    $this->success('登录成功，正在进入系统...', '/index.php/index/user');
                }
                
            }

        
        }
       

       






    }
}