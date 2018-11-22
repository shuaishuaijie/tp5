<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/11/4
 * Time: 10:38
 */

namespace app\admin\controller;


class Manager extends Commom
{
    //管理员列表
    public function index()
    {
        $result = db('admin')->field("id,aid,status")->paginate(5);
        $this->assign('manager', $result);
        return view();
    }

    //添加管理员
    public function add()
    {
        if (request()->isPost()) {
            $data = input("post.");
            $validate = validate('Manager');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            //验证通过，数据写入数据库
            unset($data['repassword']);
            //密码加密
            $data['password'] = md5($data['password']);
            if (db('admin')->insert($data)) {
                $this->success('添加成功', "manager/add");
            } else {
                $this->error("添加失败", "manager/add");
            }
        }
        //加载页面
        return view();
    }

    //管理员编辑
    public function edit($id)
    {
        if (request()->isPost()) {
            $data = input('post.');
            if (isset($data['aid'])) {
                unset($data['aid']);
            }
            if (!$data['password']) {
                unset($data['password']);
                unset($data['repassword']);
            } else {
                $validate = validate('Manager');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                }
                unset($data['repassword']);
                $data['password'] = md5($data['password']);
            }
            $result = db('admin')->where('id', $id)->update($data);
            if (!$result) {
                $this->error("更新失败", "");
            }
            $this->success("管理员修改成功", "manager/index");
        }
        $res = db('admin')->where('id', $id)->field('aid,status')->find();
        $this->assign('manager', $res);
        return view();
    }

    //管理员状态
    public function status($id)
    {
        $res = db('admin')->where('id', $id)->field('status')->find();
        if ($res['status'] == 0) {
            $res['status'] = 1;

        } else {
            $res['status'] = 0;
        }
        $result = db('admin')->where('id', $id)->update($res);
        if ($result) {
            $this->success("更新成功", "manager/index");
        } else {
            $this->error("更新失败", "manager/index");
        }
    }

    //管理员删除
    public function del($id)
    {
        $res = db('admin')->where('id', $id)->delete();
        if ($res) {
            $this->success("删除成功", "manager/index");
        } else {
            $this->error("删除失败", "manager/index");
        }
    }

    //管理员登录日志
    public function log()
    {
        //获取登录日志
        $log = db('loginlog')->order('logintime desc')->where('uid', session('loginid', '', 'admin'))->limit(10)->select();
        $this->assign('log', $log);
        //加载页面
        return view();
    }

    //修改密码
    public function setpassword()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $validate = validate('manager');//实例化验证器
            //场景验证
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
            //查询数据库密码
            $res = db('admin')->field('password')->find(session('loginid', '', 'admin'));
            if (md5($data['oldpassword']) != $res['password']) {
                $this->error("旧密码输入错误");
            }
            $result = db('admin')->where('id', session('loginid', '', 'admin'))->setField('password', md5($data['password']));
            if ($result) {
                $this->success('密码更新成功');
            } else {
                $this->error('密码更新失败');
            }
            return;
        }
        return view();
    }
}