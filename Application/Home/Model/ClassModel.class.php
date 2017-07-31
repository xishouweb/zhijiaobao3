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
    
}
?>