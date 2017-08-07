<?php
namespace Home\Model;
use Think\Model\RelationModel;
class LocationModel extends RelationModel{
    //地点表model
    protected $_link = array (
        'Community' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'  => 'Community',
            'mapping_name'=> 'community',
            'foreign_key' => 'community_id',
            'as_fields'   => 'community_name:community',
        )
    );
    //获取地点列表
    public function getList($userId=NULL,$key=NULL,$order='create_time desc') {
        if (!empty($userId))
            $map['community_id'] = $userId;
        $map['school|city|province|address|bus_station|train_station'] = array('like','%'.$key.'%');
        $list = $this->relation(true)->where($map)->order($order)->field('location_id,school,address,date_format(create_time,"%Y-%m-%d") as time,community_id,is_free,gold')->select();
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