<?php
namespace Home\Model;
use Think\Model\RelationModel;
class TeachplanCommentModel extends RelationModel{
    //教案评价表model

    //插入教案评价
    public function insertComment($data) {
        return $this->data($data)->add();
    }

    //获取评价
    public function getComments($teachplanId,$order = 'comment_time') {
        $map['teachplan_id'] = $teachplanId;
        return $this->where($map)->order($order)->select();
    }
}
?>