<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/11/4
 * Time: 20:58
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller
{
    public function index()
    {
        //判断是否为post提交
        if (request()->isPost()) {
            //接收数据
            $data = input('post.');
            $result = $this->logincheck($data);

            //返回数据判断，插入log表记录日志
            if (isset($result['uid'])) {
                $data_log = [
                    'uid' => $result['uid'],
                    'ip' => request()->ip(),
                    'logintime' => time(),
                    'loginmsg' => $result['msg'],
                ];
                //获取登录次数
                $log_rows = db('loginlog')->where('uid', $result['uid'])->count();

                //保留最近30条登录日志
                if ($log_rows = 30) {
                    //获取logintime 最小值
                    $log_min = db('loginlog')->where('uid', $result['uid'])->min('logintime');
                    db('loginlog')->where('uid', $result['uid'])->where('logintime', $log_min)->delete();
                }

                db('loginlog')->insert($data_log);
            }

            if ($result['code'] == 1) {
                $this->success($result['msg'], url('index/index'));
            } else {
                $this->error($result['msg']);

            }


        }
        if (session('loginname', '', 'admin') && session('loginid', '', 'admin')) {
            $this->redirect('index/index');
        }
        //加载页面
        return view();
    }

    /*
     *  登录验证
     *  return code 0:登录失败 1：登录成功  msg：登录提示信息
     */
    protected function logincheck($data)
    {
        //场景验证
        $validate = validate('manager');
        if (!$validate->scene('login')->check($data)) {
            //$this->error($validate->getError());
            return ['code' => 0, 'msg' => $validate->getError()];
        }
        //数据库验证
        $res = db('admin')->where('aid', $data['aid'])->find();
        if (!$res) {
//            $this->error('用户名不存在');
            return ['code' => 0, 'msg' => '用户名不存在'];
        }
        //验证密码
        if (md5($data['password']) != $res['password']) {
//            $this->error('密码输入错误');
            return ['code' => 0, 'msg' => '密码输入错误', 'uid' => $res['id']];
        }
        //验证状态
        if ($res['status']) {
//            $this->error('此账号已锁定请联系系统管理员');
            return ['code' => 0, 'msg' => '此账号已锁定请联系系统管理员', 'uid' => $res['id']];
        }
        //保存session(作用域为后台)
        session('loginname', $res['name'], 'admin');
        //这里保存id
        session('loginid', $res['id'], 'admin');
//        $this->success('登录成功','index/index');
        return ['code' => 1, 'msg' => '登录成功', 'uid' => $res['id']];
    }

    /*
     * 退出登录
     */
    public function logout()
    {
        session(null, 'admin');
        $this->success('退出成功', 'login/index');
    }
}