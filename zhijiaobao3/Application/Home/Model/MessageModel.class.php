<?php
namespace Home\Model;
use Think\Model\RelationModel;
class MessageModel extends RelationModel{
    //消息表model

    //获取已发送消息
    public function selectSendMessage($where,$order='time') {
        return $this->where($where)->order($order)->select();
    }

    //添加消息记录
    //插入记录后，在MessageRecord表中同时写入记录??
    public function insertMessage($data) {
        return $this->data($data)->add();
    }

    //更新消息记录
    public function updateMessage($messageId,$data) {
        $map['message_id'] = $messageId;
        return $this->where($map)->data($data)->save();
    }

    //删除消息记录
    public function deleteMessage($where) {
        return $this->where($where)->delete();
    }
}
?>