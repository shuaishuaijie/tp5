<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2018/10/30
 * Time: 20:22
 */
namespace app\index\controller;

use think\Controller;

class Code extends Controller {
    public function index(){
        return $this->fetch();
    }
    public  function check(){
        $code=input('post.code');

        if(captcha_check($code)){
            echo "hello";
        }else{
            echo "error";
        }
    }
}
