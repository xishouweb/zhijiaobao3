<?php
namespace Home\Model;
use Think\Model\RelationModel;
class LocationModel extends RelationModel{
    //地点表model

    //获取地点列表
    public function getList($userId=NULL,$key=NULL) {
        $map['1'] = 1;
        if (!empty($userId))
            $map['community_id'] = $userId;
        if (!empty($key))
            $map['school|city|province|address|bus_station|train_station'] = array('like','%'.$key.'%');
        $list = $this->where($map)->select();
        return $list;
    }

    //获取地点详细信息
    public function getLocation($locationId) {
        $map['location_id'] = $locationId;
        $location = $this->where($map)->select();
        return $location;
    }

    //添加地点信息
    public function addLocation($data) {
        return $this->data($data)->add();
    }

    //锁定地点
    public function lock($locationId,$status) {
        $map['location_id'] = $locationId;
        $map['is_free']     = $status;
        if ($this->where($map)->find())
            return true;
        $data['is_free'] = $status;
        unset($map['is_free']);
        return $this->where($map)->data($data)->save();
    }

    //修改地点信息
    public function editLocation($locationId,$data) {
        $map['location_id'] = $locationId;
        return $this->where($map)->data($data)->save();
    }

}
?>