<?php
namespace Home\Model;
use Think\Model\RelationModel;
class StudentSignModel extends RelationModel{
    //学生签到表model
	protected $_link = array(
		//通过teachplan_id关联t_teachplan表
		'teachplan' => array(
			'mapping_type' => self::BELONGS_TO,
			'mapping_fields' => "chapter_name,course_id",
			'foreign_key' => "teachplan_id",
		),
	);
	//为学生签到
	public function sign($where){
		$result = $this->add($where);
		if(!$result){
			return false;
		}else{
			return true;
		}
	}
	//某天某个班级某个课程的签到学生
	public function signinStu($time,$classId,$teachplanId){
		$map['teachplan_id'] = $teachplanId;
		$map['signin_time'] = $time;
		$result1 = D('signin')->where($map)->field('student_id')->select();
		$allStu = D('studentclass')->getStudent($classId);//班上所有学生
		for($i=0;$i<count($allStu);$i++){
			$result2[$i]['student_id'] = $allStu[$i]['student_id'];
		}
		$result3 = array_intersect_assoc($result1,$result2);
		$result4 = array_keys($result3);
		for($i=0;$i<count($result3);$i++){
			$k = $result4[$i];
			$result[$i] = $result3[$k];
			$studentId = $result[$i]['student_id'];
			$student = D('student')->getOneStudent($studentId);
			$result[$i]['student_name'] = $student['student_name'];
			$result[$i]['student_sex'] = $student['student_sex'];
			$result[$i]['address'] = $student['address'];
		}
			return $result;
	}
	//某天某个班级某个教案的未签到学生
	public function getOffStu($time,$classId,$teachplanId){
		$allStu = D('studentclass')->getStudent($classId);//班上所有学生
		for($i=0;$i<count($allStu);$i++){
			$result1[$i]['student_id'] = $allStu[$i]['student_id'];
		}
		
		$map['teachplan_id'] = $teachplanId;
		$map['signin_time'] = $time;
		$result2 = D('signin')->where($map)->field('student_id')->select();
		$result3 = array_intersect_assoc($result1,$result2);
		$result = array_diff_assoc($result1,$result3);
		$result2 = array_keys($result);
		//var_dump($result2);
		for($i=0;$i<count($result);$i++){
			$k = $result2[$i];
			$data[$i] = $result[$k]; 
			$studentId = $data[$i]['student_id'];
			$student = D('student')->getOneStudent($studentId);
			$data[$i]['student_name'] = $student['student_name'];
			$data[$i]['student_sex'] = $student['student_sex'];
			$data[$i]['address'] = $student['address'];
		}
		return $data;

	}
}
?>