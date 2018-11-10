<?php
/**
 * Created by PhpStorm.
 * manager: pc
 * Date: 2018/11/4
 * Time: 10:38
 */

namespace app\admin\controller;



class Manager extends Commom {
    //管理员列表
    public function index(){
        $result=db('admin')->field("id,aid,status")->paginate(5);
        $this->assign('manager',$result);
        return view();
    }
    //添加管理员
    public function add(){
        if(request()->isPost()){
            $data=input("post.");
            $validate=validate('Manager');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            //验证通过，数据写入数据库
            unset($data['repassword']);
            //密码加密
            $data['password']=md5($data['password']);
            if(db('admin')->insert($data)){
                $this->success('添加成功',"manager/add");
            }else{
                $this->error("添加失败","manager/add");
            }
        }
        //加载页面
        return view();
    }
    //管理员编辑
    public function edit($id){
        if(request()->isPost()){
            $data=input('post.');
            if(isset($data['aid'])){
                unset($data['aid']);
            }
            if(!$data['password']){
                unset($data['password']);
                unset($data['repassword']);
            }else {
                $validate =validate('Manager');
                if(!$validate->scene('edit')->check($data)){
                    $this->error($validate->getError());
                }
                unset($data['repassword']);
                $data['password']=md5($data['password']);
            }
            $result=db('admin')->where('id',$id)->update($data);
            if(!$result){
                $this->error("更新失败","");
            }
            $this->success("管理员修改成功","manager/index");
        }
        $res=db('admin')->where('id',$id)->field('aid,status')->find();
        $this->assign('manager',$res);
        return view();
    }
    //管理员状态
    public function status($id){
        $res=db('admin')->where('id',$id)->field('status')->find();
        if($res['status']==0){
            $res['status']=1;

        }else{
            $res['status']=0;
        }
        $result=db('admin')->where('id',$id)->update($res);
        if($result){
            $this->success("更新成功","manager/index");
        }else{
            $this->error("更新失败","manager/index");
        }
    }
}