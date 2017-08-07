<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 用户签到表model
* edit by zouxiaomin
* 2017.7.27
*/
class UserSignModel extends RelationModel{
    
	//添加用户签到记录
	public function insertRecord($data){
		//连续签到天数的赋值
		$where['user_id'] = $data['user_id'];
		$where['user_type'] = $data['user_type'];
		$start_time = date('Y-m-d',strtostring('-1 day'));
		$end_time = date('Y-m-d',strtostring('+1 day'));
		$where['sign_time'] = array(array('gt',$start_time),array('lt',$end_time));
		$record = $this->selectRecord($where);
		if($record == null){
			$data['continuous_days'] = 1;
		}else
			$data['continuous_days'] = $record['continuous_days']+1;
		$data['sign_time'] = date("Y-m-d H:i:s");
		$result = $this->add($data);
		return $result;
	}
	
	public function selectRecord($data){
		$result = $this->where($data)->find();
		return $result;
	}
	
	
	
}
?>