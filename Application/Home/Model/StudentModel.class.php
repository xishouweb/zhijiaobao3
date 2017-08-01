<?php
namespace Home\Model;
use Think\Model\RelationModel;
class StudentModel extends RelationModel{
    //学生表model
	protected $_link = array(
		'studentclass' => array(                          
            'mapping_type' => self::HAS_MANY,  
            'foreign_key'  => 'student_id',
        ),
	);
	//添加新学生
    public function addNewStudent($data){
        if (empty($data)){
            return false;
        }
        $studentId = $this->add($data);
        return $studentId;
    }
	 //按照条件搜索学生
    public function searchStudent($key){
        if (empty($key)){
            return false;
        }
        $map['student_name'] = array('like','%'.$key.'%');
        $map['school'] = array('like','%'.$key.'%');
        $map['address'] = array('like','%'.$key.'%');
        $map['_logic'] = 'OR';
        $list = $this->where($map)->select();
		
        return $list;
    }
	//获取某学生的所有信息
    public function getOneStudent($studentId){
        $student = $this->find($studentId);
        return $student;
    }
	//编辑该学生信息
    public function editStudent($data){
        return $this->save($data);
    }
	//获取学生列表，选择学生添加到班级中
	public function studentList(){
		$result = $this->query("select student_id,student_name,student_sex,birthday,address from t_student   
		where not exists(select student_id from t_studentclass  where t_student.student_id = t_studentclass.student_id )");
		for($i=0;$i<count($result);$i++){
			$studentId['student_id'] = $result[$i]['student_id'];
			$result[$i]['project'] = D('studentclass')->studentProject($studentId);
		}
		return $result;
	}
	//获取某个项目可以添加到该班级的学生
	public function stuInproject($projectId){
		$location = D('project')->getOneProject($projectId);
		$locationId = $location['location_id'];
		if($locationId > 9&&$locationId<100){
			$locationId = '0'.$locationId;
			}elseif($locationId < 10){
					$locationId = '00'.$locationId;
				}
	    
		$result = $this->studentList();
		$k = 0;
		$student = array();
		for($i=0;$i<count($result);$i++){
			$studentId = $result[$i]['student_id'];
			if(substr($studentId,8,3)==$locationId){
				$map['student_id'] = $studentId;
				$class = D('studentclass')->where($map)->order('add_time desc')->select();
				$projectId = substr($class[0]['class_id'],0,11);
				$project   = D('project')->getName($projectId);
				$student[$k]['student_id'] = $studentId;
				$student[$k]['student_name'] = $result[$i]['student_name'];
				$student[$k]['student_sex'] = $result[$i]['student_sex'];
				$student[$k]['birthday'] = $result[$i]['birthday'];
				$student[$k]['address'] = $result[$i]['address'];
				$student[$k]['project'] = $result[$i]['project_name'];
				
				$k++;
			}
		}
		//var_dump($student);
		return $student;
		
	}
   
}
?>