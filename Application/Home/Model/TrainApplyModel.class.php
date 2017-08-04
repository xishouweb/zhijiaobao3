<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 培训报名表model
* edit by zouxiaomin
* 2017.7.27
*/
class TrainApplyModel extends RelationModel{
    
	//获取培训报名列表
	public function selectTrainApply($pageSize){
		$result = $this->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//添加培训报名记录
	public function insertTrainApply($data){
		$result = $this->add($data);
		return $result;
	}
	
}
?>