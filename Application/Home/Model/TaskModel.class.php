<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 众包任务表model
* edit by zouxiaomin
* 2017.7.27
*/
class TaskModel extends RelationModel{
    
	//获取众包任务列表
	public function selectTaskList($pageSize){
		$result = $this->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//根据任务id获取众包任务详情
	public function selectTaskById($taskId){
		$result = $this->find($taskId);
		return $result;
	}
	
	//根据关键字获取推荐众包任务列表
	public function selectTaskBykey($key,$pageSize){
		$data['place'] = "%".$key."%";
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//添加或更新任务详情
	public function saveTask($data){
		if($data['task_id'] == null){
			$result = $this->add($data);
		}else{
			$result = $this->save($data);
		}
		return $result;
	}

}
?>