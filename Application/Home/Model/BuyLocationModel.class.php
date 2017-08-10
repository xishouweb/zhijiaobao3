<?php
namespace Home\Model;
use Think\Model\RelationModel;
class BuyLocationModel extends RelationModel{
    //地点购买表model
    
    // 获取购买记录
    public function getRecord($buyerId, $locationId=NULL) {
        $map['buyer_id'] = $buyerId;
        if (!empty($locationId))
            $map['location_id'] = $locationId;
        return $this->where($map)->order('time desc')->select();
    }
}
?>