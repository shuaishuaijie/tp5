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
        'aid' => 'require|min:4|unique:admin',
        'password'=>'require|min:6|confirm:repassword',
        'code'=>'require|captcha',
    ];
    protected $message=[
        'aid.require'=>'账号不能为空',
        'aid.min'=>'账号长度不符合规则',
        'aid.unique'=>'该账号已存在',
        'password.require'=>'密码不能为空',
        'password.min'=>'密码长度不符合规则',
        'password.confirm'=>'两次密码不一致',
        'code.require'=>'验证码不能为空',
        'code.captcha'=>'验证码输入错误',

    ];
    protected $scene = [
        'edit'=>['password'=>'require|min:6|confirm:repassword'],
        'login'=>['aid'=>'require|min:4','password'=>'require|min:6','code'=>'require|captcha'],
    ];
}