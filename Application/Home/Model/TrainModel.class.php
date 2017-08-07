<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 培训表model
* edit by zouxiaomin
* 2017.7.27
*/
class TrainModel extends RelationModel{
    
	//获取培训列表
	public function selectTrainList($pageSize){
		$result = $this->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//根据培训id获取培训详情
	public function selectTrainById($trainId){
		$result = $this->find($trainkId);
		return $result;
	}
	
	//添加或更新培训详情
	public function saveTrain($data){
		if($data['train_id'] == null){
			$result = $this->add($data);
		}else{
			$result = $this->save($data);
		}
		return $result;
	}

}
?>