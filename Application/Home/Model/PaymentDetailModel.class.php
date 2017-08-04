<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 金币收支明细表model
* edit by zouxiaomin
* 2017.07.27
*/
class PaymentDetailModel extends RelationModel{
    
	//获取金币收入记录
	public function incomeDetail($userId,$userType,$pageSize){
		$data['user_id'] = $userId;
		$data['user_type'] = $userType;
		$data["type"] = 0;//type=0表示收入
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//获取金币支出记录
	public function payDetail($userId,$userType,$pageSize){
		$data['user_id'] = $userId;
		$data['user_type'] = $userType;
		$data['type'] = 1;//type=0表示支出
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		return $result;
	}
	
	//插入金币收支记录
	public function insertPaymentRecord($data){
		$result = $this->add($data);
		return $result;
	}

}
?>