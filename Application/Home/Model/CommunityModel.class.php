<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 社团表model
* edit by zouxiaomin
* 2017.07.27
*/
class CommunityModel extends RelationModel{
	
	//验证社团信息,str为phone或者email
	public function checkCommunity($communityId,$key,$value){
		if($key == "email"){
			$data['public_email'] = $value;
		}else if($key == "phone"){
			$data['head_phone'] = $value;
		}
		//$data['community_id'] = array("NEQ",$communityId);
		$result = $this->where($data)->find();
		if($result == null){
			return false;
		}else{
			return true;
		}
	}
	
	//验证登录
	public function login($phone,$password){
		$data['phone'] = $phone;
		$data['password'] = $password;
		$result = $this->where($data)->find();
		return $result;
	}
	
	//根据社团id获取社团信息 
	public function selectCommunityById($communityId){
		$where['community_id'] = $communityId;
		$result = $this->where($where)->find();
		return $result;
	}
	
	//根据学校获取社团信息
	public function selectBySchool($school,$pageSize){
		$data['school'] = $school;
		$result = $this->field('community_name,picture,belong_school')->where($data)->page($_GET['page']%2,$pageSize)->select();
		return $result;
	}
	
	//注册组织帐号
	public function addCommunity($data){
		$result = $this->add($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
	
	//更新组织信息
	public function updateCommunity($data){
		$result = $this->save($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
	
	//获取组织id的组织名称、头像、所属学校
	public function getInfo($communityId){
		return $this->field('community_name,picture,belong_school')->find($volunteerId);
	}
	
}
?>