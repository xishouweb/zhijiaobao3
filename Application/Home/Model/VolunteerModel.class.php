<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 志愿者model
* edit by zouxiaomin
* 2017.07,27
*/
class VolunteerModel extends RelationModel{
    
	//验证志愿者信息
	public function checkVolunteer($volunteerId,$phone){
		$data['phone'] = $phone;
		//$data['volunteer_id'] = array("NEQ",$volunteerId);
		$result = $this->where($data)->find();
		if($result == null){
			return false;
		}else{
			return true;
		}
	}
	
	//根据志愿者id获取志愿者信息 
	public function selectVolunteerById($volunteerId){
		$result = $this->find($volunteerId);
		return $result;
	}
	
	//验证登录
	public function login($phone,$password){
		$data['phone'] = $phone;
		$data['password'] = $password;
		$result = $this->where($data)->find();
		return $result;
	}
	
	
	//注册志愿者帐号
	public function addVolunteer($data){
		$data['volunteer_id'] = $this->generateId();
		$result = $this->add($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
	
	//更新志愿者信息
	public function updateVolunteer($data){
		$result = $this->save($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
	
	//根据学校获取志愿者信息
	public function selectBySchool($school,$pageSize){
		$data['school'] = $school;
		$result = $this->field('volunteer_id,user_name,picture,school')->where($data)->page($_GET['page']%2,$pageSize)->select();
		return $result;
	}
	
	//获取志愿者id的用户名、头像、学校
	public function getInfo($volunteerId){
		return $this->field('user_name,picture,school')->find($volunteerId);
	}
	
	//生成志愿者id
	public function generateId(){
		$time = date('YmdHis');
		$map['volunteer_id'] = array('like',"$time%");
		$count = $this->where($map)->count();
		$count = sprintf("%03d",$count);
		return $time.$count;
	}
    
}
?>