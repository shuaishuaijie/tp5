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
    public function index()
    {
       return $this->fetch();
    }
}