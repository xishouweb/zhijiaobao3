<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 粉丝表model
* edit by zouxiaomin
* 2017.07.27
*/
class FansModel extends RelationModel{
	 
	//获取粉丝列表，需要验证是否已关注该粉丝
	public function selectFansList($userId,$userType,$pageSize){
		$data['followed_id'] = $userId;
		$data['followed_type'] = $userType;
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		for($i=0;$i<count($result);$i++){
			$result = $this->infoList($result);
			$where['follow_id'] = $userId;
			$where['follow_type'] = $userType;
			$where['followed_id'] = $result[$i]['followed_id'];
			$where['followed_type'] = $result[$i]['followed_type'];
			$result[$i]['is_focus'] = $this->checkIsFans($where);
		}
		return $result;
	}
	
	//获取关注列表
	public function selectFocusList($userId,$userType,$pageSize){
		$data['follow_id'] = $userId;
		$data['follow_type'] = $userType;
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		for($i=0;$i<count($result);$i++){
			$result = $this->infoList($result);
		}
		return $result;
	}
	
	//根据学校推荐相关的志愿者或组织
	public function recommentList($userId,$userType,$pageSize){
		if($userType == 1){
			$user = D('volunteer')->getInfo($userId);
		}elseif($userType == 0){
			$user = D('community')->getInfo($userId);
		}
		$school = $user['school'];
		if($_GET['page']/2 == 0){//页码为偶数时，获取志愿者推荐列表
			$result = D('volunteer')->selectBySchool($school,$pageSize);
		}else{//页码为奇数时，获取组织推荐列表
			$result = D('community')->selectBySchool($school,$pageSize);
		}
		for($i=0;$i<count($result);$i++){            //推荐列表中的用户都是没有关注的?????
			$result[$i]['is_focus'] = false;
		}
		return $result;
	}
	
	//输出结果组装
	public function infoList($result){
		if($result[$i]['follow_type']==1){//为志愿者
			$volunteer = D('volunteer')->getInfo($result[$i]['follow_id']);
			$result[$i]['user_name'] = $volunteer['user_name'];
			$result[$i]['picture'] = $volunteer['picture'];
			$result[$i]['school'] = $communit['school'];
		}elseif($result[$i]['follow_type']==0){//为组织
			$community = D('community')->getInfo($result[$i]['follow_id']);
			$result[$i]['user_name'] = $community['community_name'];
			$result[$i]['picture'] = $volunteer['picture'];
			$result[$i]['school'] = $communit['belong_school'];
		}
		return $result;
	}
	
	//验证用户1是否关注了用户2
	public function checkIsFans($data){
		$result = $this->where($data)->find();
		if($result == null){
			return 0;
		}else
			return 1;
	}
	
	//获取用户的粉丝总数和关注总数
	public function selectFansAndFocus($userId,$userType){
		$data['follow_id'] = $userId;
		$data['follow_type'] = $user_type;
		$result['follow_num'] = $this->where($data)->count();
		$data1['followed_id'] = $userId;
		$data1['followed_type'] = $user_type;
		$result['followed_num'] = $this->where($data1)->count();
		return $result;
	}
	
	//插入关注记录
	public function insertFansFocus($data){
		$result = $this->add($data);
		return $result;
	}
	
	//更新关注记录，关注亲密度加10，访问亲密度加2
	public function updateFansFocus($data){
		$result = $this->update($data);
		return $result;
	}
}
?>