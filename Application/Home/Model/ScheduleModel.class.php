<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ScheduleModel extends RelationModel{
    //作息时间表model
    //获取某个项目的作息时间表，如果查询出错，$result值为空或者false，使用时需要数据判空
    public function getSchedule($projectId){
        $map['project_id'] = $projectId;
        $result = $this->where($map)->find();
        return $result;
    }
    //获取该项目一天上几节课
    public function classNumber($projectId){
        $schedule = D('schedule')->getSchedule($projectId);
		if($schedule['fourth']!=null && $schedule['fifth']==null){
			return 4;
		}else if($schedule['fifth']!=null && $schedule['sixth']==null){
			return 5;
		}else if($schedule['sixth']!=null && $schedule['seventh']==null){
			return 6;
		}else if($schedule['seventh']!=null && $schedule['eighth']==null){
			return 7;
		}else if($schedule['eighth']!=null && $schedule['ninth']==null){
			return 8;
		}else if($schedule['ninth']!=null && $schedule['tenth']==null){
			return 9;
		}else if($schedule['ninth']!=null && $schedule['tenth']!=null){
			return 10;
		}
    }
    //创建或更新项目的作息时间表,成功返回项目编号，失败返回false
    public function createSchedule(array $data){
        if (empty($data)){
            return false;//数据为空
        }
        //查询有没有
        $map['project_id'] = $data['project_id'];
        if ($this->where($map)->find()){
            return $this->save($data);
        }else 
        //使用add插入时更新
        return $this->add($data);//如果返回false代表插入失败  
    }
    //删除该项目的作息时间表,成功返回删除的记录数1，失败为false,，返回值如果为0表示没有删除任何数据
    public function deleteSchedule($map){
        return $this->where($map)->delete();
    }
	
}
?>