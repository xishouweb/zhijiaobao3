<?php
namespace Home\Model;
use Think\Model\RelationModel;
/**
* 访客表model
* edit by zouxiaomin
* 2017.7.27
*/
class VisitorsModel extends RelationModel{
	
	//获取访客列表，需要验证是否已关注该访客
	public function selectVisitList($userId,$userType,$pageSize){
		$data['visited_id'] = $userId;
		$data['visited_type'] = $userType;
		$result = $this->where($data)->page($_GET['page'],$pageSize)->select();
		for($i=0;$i<count($result);$i++){
			$where['visited_id'] = $userId;
			$where['visited_type'] = $userType;
			$where['visit_id'] = $result[$i]['visit_id'];
			$where['visit_type'] = $result[$i]['visit_type'];
			$result[$i]['is_focus'] = $this->checkIsFans($where);//验证是否关注了该粉丝
			if($result[$i]['visited_type']==1){//为志愿者
				$volunteer = D('volunteer')->getInfo($result[$i]['visited_id']);
				$result[$i]['user_name'] = $volunteer['user_name'];
				$result[$i]['picture'] = $volunteer['picture'];
				$result[$i]['school'] = $communit['school'];
			}elseif($result[$i]['visited_type']==0){//为组织
				$community = D('community')->getInfo($result[$i]['visited_id']);
				$result[$i]['user_name'] = $community['community_name'];
				$result[$i]['picture'] = $volunteer['picture'];
				$result[$i]['school'] = $communit['belong_school'];
			}
		}
		return $result;
	}
	
	//添加访客记录，如果访客记录不存在，则新建；如果已存在，则更新访问时间
	public function addVistit($data){
		$data['time'] = date();
		$result = $this->save($data);
		return $result;
	}

}
?>