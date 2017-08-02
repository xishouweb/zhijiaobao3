<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //首页控制器类，控制入口文件
    public function index(){
        $this->display();
    }
}