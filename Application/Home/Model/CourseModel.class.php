<?php
namespace Home\Model;
use Think\Model\RelationModel;
class CourseModel extends RelationModel{
    //课程表model

    //获取课程列表
    public function getCourseList($projectId,$userId=NULL,$grade=NULL) {
        $map['peoject_id'] = $projectId;
        if (!empty($userId))
            $map['volunteer_id'] = $userId;
        if (!empty($grade)) {
            $Model = new \Think\Model();
            return $Model->query("select * from t_course a,t_classcourse b,
            t_class c where a.project_id = '".$projectId."' and a.volunteer_id = '".$userId."' 
            and a.course_id = b.course_id and c.class_id = b.class_id and c.class_id in (select 
            class_id from t_class where grade = '".$grade."' )");
        }
        return $this->where($map)->select();
    }

    //获取课程信息
    public function getCourse($courseId) {
        $map['course_id'] = $courseId;
        return $this->where($map)->select();
    }

    //创建课程
    public function addCourse($data) {
        return $this->data($data)->add();
    }

    //修改课程信息
    public function editCourse($data,$courseId) {
        $map['course_id'] = $courseId;
        return $this->where($map)->data($data)->save();
    }

}
?>