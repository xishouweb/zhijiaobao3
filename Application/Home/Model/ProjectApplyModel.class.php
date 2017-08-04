<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ProjectApplyModel extends RelationModel{
    //项目报名表model
    protected $_link = array(
		//通过volunteer_id关联t_volunteer表
		'volunteer' => array(
			'mapping_type' => self::BELONGS_TO,
			'mapping_fields' => "volunteer_id,name,sex,phone,email",
			'foreign_key' => "volunteer_id",
		),
		
		//通过project_id关联t_project表
		'project' => array(
			'mapping_type' => self::BELONGS_TO,
			'mapping_fields' => "project_name,project_id,project_picture,project_status,recruit_start,community_id",
			'foreign_key' => "project_id",
		),
	);
    //判断数据是否重复
	public function isHave($data){
    	$result = $this->where($data)->find();
    	if ($result){
    	    return true;
    	}else 
    	    return false;
	}
	//添加报名信息
	public function addApply($data){
		$data['time'] = date('Y-m-d H:i:s');
		$result = $this->add($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
    //修改志愿者报名状态
	public function updateApply($data){
		$where['volunteer_id'] = $data['volunteer_id'];
		$where['project_id'] = $data['project_id'];
		$result = $this->where($where)->save($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
    //获取项目的所有报名信息
	public function getApplyList($projectId){
		$where['project_id'] = $projectId;
		$result = $this->where($where)->relation('volunteer')->select();
		return $result;
	}
    //根据条件获取该项目的报名信息
	public function ApplyList($data){
		$list = $this->where($data)->relation('volunteer')->select();
		return $list;
	}
    //获取某项目报名通过的志愿者
	public function getTeachers($projectId){
	    $where['project_id'] = $projectId;
	    $where['status'] = array(array('eq','3'),array('eq','2'),'or');
	    $result = $this->where($where)->relation('volunteer')->select();
	    return $result;
	}
    
    //获取该项目中该志愿者的报名状态
	public function projectStatus($where){
		$status = $this->where($where)->find();
		return $status['status'];
	}	
    //删除该项目的所有报名信息，必须先以project_id查找出对应的报名信息，然后再删除
	public function deleteApply($where){
		if($where['project_id']!=null && $where['volunteer_id']!=null){
			$result = $this->where($where)->delete();
		}else{
			$apply = $this->where($where)->select();
			foreach($apply as $v){
				$data['volunteer_id'] = $v['volunteer_id'];
				$data['project_id'] = $v['project_id'];
				$result = $this->where($data)->delete();
			}
		}
		return $result;
	}

}
?>