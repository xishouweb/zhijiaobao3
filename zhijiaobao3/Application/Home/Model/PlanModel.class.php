<?php
namespace Home\Model;
use Think\Model\RelationModel;
class PlanModel extends RelationModel{
    //项目规划表model
	 //获取某项目的所有课程规划，返回结果集，使用时需要判空。
    public function getPlan($projectId){
        if (empty($projectId)){
            return false;
        }
        $map['project_id'] = $projectId;
        $list = $this->where($map)->select();
        return $list;
    }
    //删除某项目的一条课程规划
    public function deleteOnePlan($planId){
        if (empty($planId)){
            return false;
        }
        $map['plan_id'] = $planId;
        $result = $this->where($map)->delete();
        if ($result){//删除成功
            return true;
        }else {//删除失败
            return false;
        }
    }
    //删除该项目所有的规划
    public function deletePlan($projectId){
		$map['project_id'] = $projectId;
        $result = $this->where($map)->delete();
        if ($result){//删除成功
            return true;
        }else {//删除失败
            return false;
        }
    }
    //添加一条课程规划，成功返回规划id，失败返回false
    public function addPlan($data){
        if (empty($data)){
            return false;
        }
        $planId = $this->add($data);
        return $planId;
    }
}
?>