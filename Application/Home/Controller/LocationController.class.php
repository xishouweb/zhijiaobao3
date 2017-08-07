<?php
namespace Home\Controller;
use Think\Controller;
class LocationController extends Controller {
    //地点控制器类
    public $location;

    public function _initialize() {
        $this->location = D('Location');
    }

    public function index(){
        $this->display();
    }

    // 搜索功能
    public function searchLocation() {

        //获取变量
        $keyword = I('key_word');  // 关键字
        $keyword = tranSql($keyword);

        $list = $this->location->getList(0,$keyword);
        // 返回数据
        $this->success($list);
    }

    // 地点列表
    public function locationList() {
        $list = $this->location->getList();

        $this->success($list);
    }

    // 推荐地点列表
    public function recommendLocal() {
        $search = 'visit desc limit 6';
        $list = $this->location->getList(0,'',$search);

        $this->success($list);
    }

    // 地点详情
}