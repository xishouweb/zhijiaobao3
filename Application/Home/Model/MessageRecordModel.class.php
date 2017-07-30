<?php
namespace Home\Model;
use Think\Model\RelationModel;
class MessageRecordModel extends RelationModel{
    //消息记录表model

    //获取用户消息，0未读，1已读
    public function getMessage($readId,$status=NULL) {
        $map['reader_id'] = $readId;
        if ($status != NULL)
            $map['status'] = $status;
        return $this->where($map)->order('time desc')->select();
    }

    //删除消息，实际是将消息状态改为2
    public function deleteReceiveMessage($messageId,$readerId) {
        $map['message_id'] = $messageId;
        $map['reader_id']  = $readerId;
        $data['status'] = '2';
        return $this->where($map)->data($data)->save();
    }

    //修改消息状态
    public function updateReceiveMessage($messageId,$readerId) {
        $map['message_id'] = $messageId;
        $map['reader_id']  = $readerId;
        $data['status'] = '1';
        return $this->where($map)->data($data)->save();
    }

    //插入消息记录
    public function insertMessage($data) {
        return $this->data($data)->add();
    }


}
?>