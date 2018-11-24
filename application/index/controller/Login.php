<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2018/11/22
 * Time: 21:27
 */

namespace app\index\controller;


use think\Controller;
use think\Request;

class Login extends Controller
{
    /*
     * 前台登录首页
     */
    public function index()
    {
        if (request()->isPost()) {
            $data = request()->post();
            unset($data['code']);
            $res = db('user')->where('account', $data['login'])->find();
            if (!$res) {
                $responseText = ["Status" => "error", "Text" => "账号或密码错误请重新登录"];
            } else {
                if ($res['password'] != md5($data['pwd'])) {
                    $responseText = ["Status" => "error", "Text" => "账号或密码错误请重新登录"];
                } else {
                    $responseText = ["Status" => "ok", "Text" => "登录成功"];
                }
            }
            return json($responseText);
        }
        return $this->fetch();
    }

    public function test()
    {
        
    }
}