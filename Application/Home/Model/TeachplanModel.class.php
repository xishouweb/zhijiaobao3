<?php
namespace Home\Model;
use Think\Model\RelationModel;
class TeachplanModel extends RelationModel{
    //教案表model

    //获取教案列表
    public function getTeachplanList($key,$CourseId=NULL) {

    }

    //删除教案
    public function deleteTeachplan($teachplanId) {
        $map['teachplan_id'] = $teachplanId;
        return $this->where($map)->delete();
    }

    //更新教案信息
    public function editTeachplan($teachplanId,$data) {
        $map['teachplan_id'] = $teachplanId;
        return $this->where($map)->data($data)->save();
    }

    //创建教案
    public function addTeachplan($data) {
        return $this->data($data)->add();
    }

    //获取教案信息
    public function getTeachplan($teachplanId) {
        $map['teachplan_id'] = $teachplanId;
        return $this->where($map)->select();
    }
    
}
?>