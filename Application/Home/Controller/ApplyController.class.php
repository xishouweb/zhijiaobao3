<?php
namespace Home\Controller;
use Think\Controller;
class ApplyController extends Controller {
    //报名控制器
    public function Apply(){
        $this->display();
    }
    //添加报名信息
    public function addApply(){
   
        //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['volunteer_id'] = I('get.volunteer_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) || empty($data['volunteer_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        if(!D('projectapply')->isHave($data)){
            if(D('projectapply')->addApply($data)){
            $output['info'] = '添加报名信息成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
            }else{
                $output['info'] = '添加报名信息失败';
                $output['status'] = 0;//1：表示操作成功
                $output['url'] = "";
                $this->ajaxReturn($output);
            }
        }
        
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');        
    }

}