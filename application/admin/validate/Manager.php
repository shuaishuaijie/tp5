<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/11/7
 * Time: 19:46
 */

namespace app\admin\validate;


use think\Validate;

class Manager extends Validate
{
    protected $rule = [
        'aid' => 'require|min:4',
        'password'=>'require|min:6',
        'code'=>'require|captcha',
    ];
    protected $message=[
        'aid.require'=>'账号不合法',
        'code.require'=>'验证码不能为空',
        'code.captcha'=>'验证码输入错误',
    ];
    protected $scene = [
        'edit' => ['name','age'],
        'login'=>['aid'=>'require|min:4','password'=>'require|min:6','code'=>'require|captcha'],
    ];
}