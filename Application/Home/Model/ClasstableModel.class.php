<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ClasstableModel extends RelationModel{
    //课程表Model
    protected $_link = array(
	    'course' => array(
	        'mapping_type' => self::HAS_MANY,
	        'foreign_key' => 'course_id',
	    ),
	    'class' => array(
	        'mapping_type' => self::HAS_MANY,
	        'foreign_key' => 'class_id',
	    )
	);
	
	//创建课表
	public function addClasstable($data){
	    if (empty($data)){
	        return false;
	    }
	    return $this->add($data);
	}
	//判断该班级当天是否有课表
	public function isexistClasstable($classId,$date) {
		$map['class_id'] = $classId;
		$map['classtable_time'] = $date;
		$result = $this->where($map)->select();
		if (empty($result)){
			return false;
		}
		return true;
	}
	//获得起始日期之后6天的课表
	public function getClasstable($date,$classId,$projectId){
	    if (empty($date)){
	        return false;
	    }
	    if (empty($classId)){
	        return false;
	    }
		$date2 = date('Y-m-d',strtotime($date.'+6 days'));
	    $map['classtable_time'] = array(array('EGT',$date),array('ELT',$date2));
	    $map['class_id'] = $classId;
	    $result = $this->where($map)->select();
	    return $result;
	}
	//获得6天内所有的课表
	public function getAllTable($date,$projectId){
	    if (empty($date)){
	        return false;
	    }
		$date2 = date('Y-m-d',strtotime($date.'+6 days'));
	    $map['classtable_time'] = array(array('EGT',$date),array('ELT',$date2));
	    $result = $this->where($map)->select();
	    return $result;
	}
	/**
	*获取教师所上的课程，根据课程获取班级，根据课程获取教案id，通过班级获取课表，对比教案id
		*/

	public function getTeacherClasstable($date,$projectId,$volunteerId){
	    if (empty($date)){
	        return false;
	    }
	    if (empty($classId)){
	        return false;
	    }
		$class = D('class')->getClassList($projectId);
		$classNumber = D('schedule')->classNumber($projectId);//每天上多少节课
		$teachplan = D('course')->getAllTeachplan($volunteerId,$projectId);
		$result = array();
		for($i=0;$i<7;$i++){
			for($j=0;$j<count($class);$j++){
				$where['classtable_time'] = date('Y-m-d',strtotime($date.'+'.$i.' days'));
				$where['class_id'] = $class['class_id'];
				$data = $this->where($where)->find();
				for($k=0;$k<$classNumber;$k++){
					$n = $this->whichClass($k);
					if(!in_array($data[$n])){
						$data[$n] = null;
					}
				}
				array_push($result,$data);
			}
		}
		return $result;
	}
	//更新班级课表信息
	public function updateClasstable($classId,$data,$date){
	    if (empty($data)){
	        return false;
	    }
	    if (empty($date)){
	        return false;
	    }
	    if (empty($classId)){
	        return false;
	    }
	    $map['class_id'] = $classId;
	    $map['classtable_time'] = $date;
	    return $this->where($map)->save($data);
	}
	//清空班级课表
	public function clearClasstable($classId){
	    if (empty($classId)){
	        return false;
	    }
	    $map['class_id'] = $classId;
	    return $this->where($map)->delete();
	}
	
	//一天中的哪一节课
	public function whichClass($i){
		switch($i){
			case 1:
				return "first";break;
			case 2:
				return "second";break;
			case 3:
				return "third";break;
			case 4:
				return "fourth";break;
			case 5:
				return "fifth";break;
			case 6:
				return "sixth";break;
			case 7:
				return "seventh";break;
			case 8:
				return "eighth";break;
			case 9:
				return "ninth";break;
			case 10:
				return "tenth";break;
			default:
				return false;
		}
	}
	
	/*生成课表的约束条件
	* 1个老师同一时间只能出现在一个班级；
	* 1个班级同一时间只能有且只有一个老师在上课；
	* 同一天同一门课只能有0，1，2节课；
	* 一个老师一天上的课数不能超过6节；
	* x-班级，y-日期，z-第几节课
	*/
	public function check($projectId,$table,$x,$y,$z){
		//保证一个老师在同一时间内只出现在一个班级
		$volunteers = D('apply')->getApplyList($projectId);
		for($j=0;$j<$y;$j++){
			$temp=0;$i=0;
			while($i<=$x){
				for($l=0;$l<count($volunteers);$l++){
					$teachplans = D('course')->getAllTeachplan($volunteers['volunteer_id'],$projectId);
					if(in_array($table[$i][$j][$z],$teachplans)){
						$temp++;
						if($temp>=2){
							return false;
						}
					}
				}
			}
		}
		//一个班级同一时间只能有且只有一个老师在上课
		
		//同一个班级同一天，同一门课只能有0，1，2节课；
		$courseId = D('teachplan')->where('teachplan_id='.$table[$x][$y][$z])->field('course_id')->select();
		$temp=0;$k=1;
		while($k<=$z){
			$teachplans = D('teachplan')->getAllTeachplan($courseId['course_id']);
			if(in_array($table[$x][$y][$k],$teachplans)){
				$temp++;
				if($temp>2){
					return false;
				}
			}
		}
		//一个老师一天上的课数不能超过6节；
		$volunteers = D('apply')->getApplyList($projectId);
		$dayTeachplan = array();//今天老师上的所有的课
		for($i=0;$i<$x;$i++){
			for($k=0;$k<$z;$k++){
				array_push($dayTeachplan,$table[$i][$y][$k]);
			}
		}
		for($l=0;$l<count($volunteers);$l++){
			$teachplans = D('course')->getAllTeachplan($volunteers['volunteer_id'],$projectId);
			foreach($teachplans as $t){
				if(in_array($t['teachplan_id'],$dayTeachplan)){
					$temp++;
					if($temp>6){
						return false;
					}
				}
			}
		}
		return true;
	}
	//查看该项目的课表是否存在
	public function isexists($projectId){
		$map['project_id'] = $projectId;
		$class = D('class')->where($map)->select();
		$where['class_id'] = $class[0]['class_id'];
		return $this->where($where)->find();
	}
	//查看该班级这一天的每次节课上什么课
	public function dayClassInfo($classId,$time){
		$map['class_id'] = $classId;
		$map['classtable_time'] = $time;
		$result = D('classtable')->where($map)->find();
		return $result;
		
	}
}
?>