<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ProjectModel extends RelationModel{
    //项目表Model
    private $_link = array(
        'Community' => array(
           'mapping_type' => self::BELONGS_TO,
            'class_name'  => 'Community',
            'mapping_name'=> 'community',
            'foreign_key' => 'community_id'
        )
    );
    protected $pk = 'project_id';

    //创建项目
    public function addProject($data) {
        $result = $this->data($data)->add();
        if ($result)
            return true;
        return false;
    }

    //获取项目信息
    public function getProject($projectId) {
        $map['project_id'] = $projectId;
        $project = $this->where($map)->relation('Community')->select();
        return $project;
    }

    //保存信息
    public function editProject($projectId, $data) {
        $map['project_id'] = $projectId;
        $result = $this->data($data)->where($map)->save();
        if ($result)
            return true;
        return false;
    }  

}
?>