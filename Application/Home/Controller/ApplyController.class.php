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
        $data['round'] = 1;
        $data['status'] = 0;
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

    //修改志愿者报名结果
    public function editResult(){
        //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $volunteerId = I('get.volunteer_id');
        $data['status'] = I('get.status');
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
        $sum = 0;
        $n = count($volunteerId);
        $data['round'] = 1;
        $data['status'] = 0;
        foreach($volunteerId as $v){
			$data['volunteer_id'] = $v;
            if(D('projectapply')->updateApply($data)){
                    $sum = $sum + 1;
            }
		}
        if($sum == $n ){
            
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
        
        
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');                
    }


    //获取某轮的面试结果
    public function getApplyResult(){

         //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['round'] = I('get.round');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) && empty($data['round'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $result = $this->getAllResult($projectId);
        $round = $data['round'];
        $apply = array();
        for($i=0;$i<count($result);$i++){
            if($round == $result[$i]['round']){
                $apply[$i]['name'] = $result[$i]['name'];
                $apply[$i]['sex'] = $result[$i]['sex'];
                $apply[$i]['phone'] = $result[$i]['phone'];
                $apply[$i]['email'] = $result[$i]['email'];
                $apply[$i]['status'] = $result[$i]['status'];
            }
        }
        if($apply){
        $output['info'] = $apply;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获取某轮的面试结果的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');        
    }

    //设置项目负责人
    public function setLeader(){
         //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['volunteer_id'] = I('post.volunteer_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) && empty($data['volunteer_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        if($this->hasLeader($projectId)){
            $this->error('该项目已经有项目负责人');
        }
        if(D('projectapply')->updateApply($data)){
        $output['info'] = '设置负责人成功';
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '设置负责人失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');        
    }

    //搜索志愿者
    public function searchVolunteer(){
   
        //(1)获取变量
        $key = I('get.key');
        $data['project_id'] = I('get.project_id');
        $data['round'] = I('get.round');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) || empty($key)){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $data['name'] = array('like','%'.$key.'%');
        $result = D('projectapply')->ApplyList($data);
        if($result){
            $output['info'] = $result;
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
            }else{
                $output['info'] = '搜索志愿者失败';
                $output['status'] = 0;//1：表示操作成功
                $output['url'] = "";
                $this->ajaxReturn($output);
        }
        
        
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');             
    }

    //邀请未报名该项目的志愿者(UI没做)
    public function inviteVolunteer(){
   
        //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['volunteer_id'] = I('get.volunteer_id');
        $data['round'] = I('get.round');
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
        $data['status'] = 2;
        if(!D('projectapply')->isHave($data))
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
    //获取该项目所有的面试结果
    public function getAllResult($projectId){

        $result = D('projectapply')->getApplyList($projectId);
        return $result;

    }

    //判断该项目是否已经有项目负责人
    public function hasLeader($projectId){
        $round_end = $this->roundNum($projectId);
        $result = D('projectapply')->getApplyList($projectId);
        for($i=0;$i<count($result);$i++){
            if($result[$i]['round'] == $round_end && $result[$i]['status']==3){
                return true;
            }
        }

        return false;

    }

    //该项目的共有几个面试轮数
    public function roundNum($projectId){

        $project = D('project')->getProject($projectId);
        $num = $project['interview_times'];
        return $num;

    }

    

}