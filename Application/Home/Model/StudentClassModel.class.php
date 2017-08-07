<?php
namespace Home\Model;
use Think\Model\RelationModel;
class StudentClassModel extends RelationModel{
    //学生班级表model
		protected $_link = array(
		'student' => array(                          
            'mapping_type'   => self::BELONGS_TO,  
            'foreign_key'    => 'student_id',
			'mapping_fields' => 'student_id,student_name,father_phone,student_sex,address',
        ),
	);	
	
	//获取某一班级下的所有学生
	public function getStudent($classId){
		if (empty($classId)){
            return false;
        }
		$where['class_id'] = $classId;
        $result = $this->where($where)->relation(true)->select();
		return $result;
	}

	//获取某一学生最后加入的项目
	public function studentProject($studentId){
		$class = $this->order('add_time')->select($studentId);
		$classId['class_id'] = $class[0]['class_id'];
		$project = D('class')->field('project_id')->find($classId);
		$projectName = D('project')->getName($project);
		return $projectName['project_name'];

	//删除该班级下的某一个学生
	public function deleteStudent($data){
		if($data['student_id']!=null && $data['class_id']!=null){
			$result = $this->where($data)->delete();
		}else{
			$list = $this->where($data)->select();
			foreach($list as $v){
				$where['student_id'] = $v['student_id'];
				$where['class_id'] = $v['class_id'];
				$result = $this->where($where)->delete();
			}
		}
		return $result;
	}
	
	//为某班级添加学生
	public function addStudent($data){
		$result = $this->add($data);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
}
?>