<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ClassModel extends RelationModel{
    //班级表model
    //获取年级列表
    public function getList($projectId) {
        $map['project_id'] = $projectId;
        return $this->where($map)->group('grade')->getField('grade');
    }
        //添加新班级，成功返回class_id，失败返回false
    public function addNewClass($data){
        if (empty($data)){
            return false;
        }
        return $this->add($data);
    }
    //删除班级,删除成功返回条数，失败false，没有数据返回0
    public function deleteClass($classId){
		$where['class_id'] = $classId;
		$result = $this->where($where)->delete();
		$result1 = D('classcourse')->deleteRecord($where);//删除班级课程记录
		$result2 = D('classtable')->clearClasstable($classId);//删除班级课程记录
		//echo "class:".$result."classcourse:".$result1."classtable".$result2;
		if(!$result){
			return false;
		}else{
			return true;
		}
    }
    //删除项目下所有班级，成功返回条数，失败false，没有数据返回0
    public function deleteAllClass($projectId){
        if (empty($projectId)){
            return false;
        }
        $allClass = $this->getClassList($projectId);
		foreach($allClass as $v){
			$classId = $v['class_id'];
			$result = $this->deleteClass($classId);
			//echo "remove classid:".$v['class_id']."\n";
			if(!$result){
				return false;
			}
		}
        return true;
    }
    //获取该项目下的所有班级
    public function getClassList($projectId){
        if (empty($projectId)){
            return false;
        }
        $map['project_id'] = $projectId;
        $list = $this->where($map)->select();
        return $list;
    }
	//获取一个班级的信息
	public function getOneClass($classId){
		$map['class_id'] = $classId;
		$class = $this->where($map)->find();
		return $class;
	}
	//获取该项目下的所有年级
	public function getGradeList($projectId){
		$map['project_id'] = $projectId;
		$result = $this->where($map)->field('grade_id')->distinct(true)->order('grade_id asc')->select();
		return $result;
	}
	//获取一个年级下的所有班级信息
	public function getGrade_allclass($projectId,$gradeId){
		$map['project_id'] = $projectId;
		$map['grade_id'] = $gradeId;
		$result = $this->where($map)->field('class_id,class_name')->order('class_id asc')->select();
		return $result;
	}
    //获取该班级的班主任
	public function getHeadteacher($where){
		$result = $this->where($where)->field('headteacher_id')->find();
		return $result;
	}
	//根据条件获取班级列表
	public function getList($where){
		$list = $this->where($where)->field('class_id,class_name')->select();
        return $list;
	}
	//编辑该班级信息
    public function editClass($data){
        return $this->save($data);
    }
}
?>