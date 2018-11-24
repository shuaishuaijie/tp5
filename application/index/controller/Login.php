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
        if (request()->isPost()) {

            $data = input('post');
            $result = json_decode($data);
            unset($result['code']);
            $res = db('user')->where('login', $result['login'])->find();

            $responseText = ["Status" => "ok", "Text" => "登录成功"];
            //$responseText = ["Status"=> "error", "Text"=>"账号或密码错误请重新登录"];
            return json($responseText);
        }
        return $this->fetch();
    }

    //
    public function test()
    {
        $data = [
            "account"=> 2016301020213,
            "password"=> 123456,
            "name"=> "杰哥",
            "clas" => 1,
            "score"=> null,
            "photo" => null,
        ];
        db('user')->insert($data);
    }
}