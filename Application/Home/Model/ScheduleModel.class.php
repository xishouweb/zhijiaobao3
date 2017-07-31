<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ScheduleModel extends RelationModel{
    //作息时间表model
    
    //获取作息时间表
    public function getSchedule($projectId) {
        $map['project_id'] = $projectId;
        $schedule = $this->where($map)->select();
        return $schedule;
    }
}
?>