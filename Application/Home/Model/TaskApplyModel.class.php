<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 众包任务报名表model
* edit by zouxiaomin
* 2017.7.27
*/
class TaskApplyModel extends RelationModel{
	
	//获取众包任务报名列表
	public function selectTaskApply($pageSize){
		$result = $this->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//添加众包任务报名记录
	public function insertTaskApply($data){
		$result = $this->add($data);
		return $result;
	}
	
	//更新众包任务报名状态
	public function updateTaskApply($data){
		$result = $this->update($data);
		return $result;
	}
}
?>