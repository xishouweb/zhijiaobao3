<?php
// 此文件用于定义公共调用的函数，如mail()，upload()，发送短信等函数

/**
*图片上传
*@param string $path 图片存储路径,对于主要根据用途不同进行存放，用户头像user/，项目project/,地点location/
*@return string
*/
function uploadImage($path) {
    $upload = new  \Think\Upload();
    $upload->maxSize  = 2048000;
    $upload->exts     = array('jpg','gif','jpeg','png');
    $upload->saveName = 'com_create_guid';
    $upload->rootPath = './Uploads/';
    $upload->autoSub  = false;
    $upload->savePath = $path; //根据图片来源不同选择不同路径
    $info = $upload->upload();
    if (!$info) {
        return $upload->getError();
    }
    else {
        zipImage($upload->rootPath,$info);
        return $info;
    }
}

/**
*图片压缩处理
*@param array 
*@return void
*/
function zipImage($path,$info) {
    $image = new \Think\Image();
    foreach ($info as $key => $value) {
        $image->open($path.$value['savepath'].$value['savename']);
        $image->thumb(450,450)->save($path.$value['savepath'].$value['savename']);
    }
}



?>