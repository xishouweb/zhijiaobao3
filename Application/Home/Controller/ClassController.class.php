<?php
namespace Home\Controller;
use Think\Controller;
class ClassController extends Controller {
    //班级控制器
    public function Class(){
        $this->display();
    }

    //添加班级
    public function addClass(){
   
        //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['grade'] = I('get.grade');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) || empty($data['grade'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $result = $this->getClassNum($grade,$projectId);
        $className = array('一班','二班','三班','四班','五班','六班','七班','八班','九班');
        $n = $result['total']
        $k = $n + 1;
        $class_id = $data['project_id'].$result['grade_id'].'0'.$k;
        $data['class_id'] = $class_id;
        $data['class_name'] = $grade.$className[$n];
        $data['headteacher_id'] = '';
        if(D('class')->addNewClass($data)){
            $output['info'] = '添加班级成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '添加班级失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
    }

    //删除班级
    public function deleteClass(){
        //(1)获取变量
        $data['class_id'] = I('get.class_id');
        
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $classId = data['class_id'];
        $result = $this->hadStu($classId);
        if($result == 1){
            D('class')->deleteClass($classId);
            $output['info'] = '删除班级成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '删除班级失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
    }

    //修改班级名字
    public function modifyClassName(){
        //(1)获取变量
        $data['class_id'] = I('get.class_id');
        $data['class_name'] = I('post.class_name');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($data['class_name'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        if(D('class')->editClass($data)){
            $output['info'] = '修改班级名成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '修改班级名失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
    }

    //添加年级
    public function addGrade(){
         //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['grade'] = I('get.grade');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($data['grade'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $data['class_id'] = '00';
        if(D('class')->addNewClass($data)){
        $output['info'] = '添加年级成功';
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '添加年级失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
    }

    //设置班主任
    public function setHeadteacher(){
         //(1)获取变量
        $data['project_id'] = I('get.project_id');
        $data['class_id'] = I('get.class_id');
        $data['volunteer_id'] = I('post.volunteer_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($data['class_id']) || empty($data['volunteer_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        
        if(D('class')->editClass($data)){
        $output['info'] = '设置班主任成功';
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '设置班主任失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
    }
   
   //添加学生进入该班级
   public function addStuInClass(){
          
        //(1)获取变量
        $data['class_id'] = I('get.class_id');
        $studentId = I('post.student_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($studentId)){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $sum = 0;
        $n = count($studentId);
        foreach($studentId as $v){
            $data['student_id'] = $v;
            $data['time'] = date("Y-m-d",time());
            if(D('studentclass')->addStudent($data)){
                $sum = $sum + 1;
            }
        }
        if($sum == $n){
            $output['info'] = '添加学生进入班级成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '添加学生进入班级失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //从班级里剔除学生
   public function deleteStuInClass(){
         
        //(1)获取变量
        $data['class_id'] = I('get.class_id');
        $studentId = I('post.student_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($studentId)){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $sum = 0;
        $n = count($studentId);
        foreach($studentId as $v){
            $data['student_id'] = $v;
            if(D('studentclass')->deleteStudent($data)){
                $sum = $sum + 1;
            }
        }
        if($sum == $n){
            $output['info'] = '从班级里删除学生成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '从班级里删除学生失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');   
   }

   //创建学生
   public function createStu(){
        //获取变量
        $data['project_id'] = I('get.project_id');
        $data['student_name'] = I('post.student_name');
		$data['student_sex'] = I('post.student_sex');
		$data['birthday'] = I('post.birthday');
		$data['address'] = I('post.address');
		$data['grade'] = I('post.grade');
		$data['primary_school'] = I('post.primary_school');
		$data['primary_entry_time'] = I('post.primary_entry_time');
		$data['middle_school'] = I('post.middle_school');
		$data['middle_entry_time'] = I('post.middle_entry_time');
		$data['qq'] = I('post.qq');
		$data['mother_name'] = I('post.mother_name');
		$data['mother_phone'] = I('post.mother_phone');
		$data['father_name'] = I('post.father_name');
		$data['father_phone'] = I('post.father_phone');
		$data['emergency_name'] = I('post.emergency_name');
		$data['emergency_phone'] = I('post.emergency_phone');
		$data['emergency_relation'] = I('post.emergency_phone');
        $data['children_character'] = I('post.children_character');
        $data['note'] = I('post.note');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id']) || empty($data['student_name'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $locationId = $this->getLocationId(projectId);
        $time = date('Y-m-d');
		$time1 = explode("-",$time);
        $num = $this->getStuInToday($locationId);
        $studentId = $time1[0].$time1[1].$time1[2].$locationId.$num;
        $data['student_id'] = $studentId;
        $data['location_id'] = $locationId;
        if(D('student')->addNewStudent($data)){
            $output['info'] = '创建学生成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '创建学生失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //修改学生
   public function editStu(){

        //(1)获取变量
        $data['student_id'] = I('get.student_id');
        $data['student_name'] = I('post.student_name');
		$data['student_sex'] = I('post.student_sex');
		$data['birthday'] = I('post.birthday');
		$data['address'] = I('post.address');
		$data['grade'] = I('post.grade');
		$data['primary_school'] = I('post.primary_school');
		$data['primary_entry_time'] = I('post.primary_entry_time');
		$data['middle_school'] = I('post.middle_school');
		$data['middle_entry_time'] = I('post.middle_entry_time');
		$data['qq'] = I('post.qq');
		$data['mother_name'] = I('post.mother_name');
		$data['mother_phone'] = I('post.mother_phone');
		$data['father_name'] = I('post.father_name');
		$data['father_phone'] = I('post.father_phone');
		$data['emergency_name'] = I('post.emergency_name');
		$data['emergency_phone'] = I('post.emergency_phone');
		$data['emergency_relation'] = I('post.emergency_phone');
        $data['children_character'] = I('post.children_character');
        $data['note'] = I('post.note');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['student_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        if(D('student')->editStudent($data)){
            $output['info'] = '编辑学生成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '编辑学生失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //获取班上所有学生
   public function  allStuInClass(){

         //(1)获取变量
        $data['class_id'] = I('get.class_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $result = D('studentclass')->getStudent($classId);
        if($result){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获取该班级所有学生的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //获取该项目里的所有班级
   public function allClassInProject(){
        //(1)获取变量
        $data['project_id'] = I('get.project_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $allGrade = D('class')->getGradeList($projectId);
        for($i=0;$i<count($allGrade);$i++){
            $data['grade'] = $allGrade[$i]['grade'];
            $class = D('class')->getGrade_allclass($projectId,$grade);
            for($j=0;$j<count($class);$j++){
                $allClass[$i]['class'][$j]['grade'] = $allGrade[$i]['grade'];
                if($class[$j]['class_id'] == '00'){
                    $allClass[$i]['class'][$j]['class_id'] = $class[$j]['class_id'];
                    $allClass[$i]['class'][$j]['class_name'] = null;
                }else{
                    $allClass[$i]['class'][$j]['class_id'] = $class[$j]['class_id'];
                    $allClass[$i]['class'][$j]['class_name'] = $class[$j]['class_name'];
                }
                
            }
        }
        if($allClass){
        $output['info'] = $allClass;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获取该项目里所有班级的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');

   }

   //获取该学生库的所有未被添加进入班级里的学生
   public function allStuOffClass(){

        //(1)获取变量
        $data['project_id'] = I('get.project_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['project_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $projectId = $data['project_id'];
        $student = D('student')->allStuOffClass($projectId);
        for($i=0;$i<count($student);$i++){
            $student_grade[$i] = $student[$i]['grade']; 
        }
        $a = array_unique($student_grade);
        $b = array_keys($a);
        $result = array();
        for($i=0;$i<count($a);$i++){
            $t = $b[$i];
            $grade = $a[$t];
            $k = 0;
            for($j=0;$j<count($student);$j++){
                if($student[$j]['grade'] == $grade){
                    $result[$i]['student'][$k]['grade'] = $grade;
                    $result[$i]['student'][$k]['student_id'] = $student[$j]['student_id'];
                    $result[$i]['student'][$k]['student_name'] = $student[$j]['student_name'];
                    $result[$i]['student'][$k]['student_sex'] = $student[$j]['student_sex'];
                    $result[$i]['student'][$k]['birthday'] = $student[$j]['birthday'];
                    $result[$i]['student'][$k]['address'] = $student[$j]['address'];
                }
            }
        }
        if($result){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获取该学生库的所有未被添加进入班级里的学生的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   
   }

   //获取该学生的信息
   public function getStuInfo(){
       //(1)获取变量
        $data['student_id'] = I('get.student_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['student_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $result = D('student')->getOneStudent($studentId);
        if($result){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获取该班级所有学生的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

 //获得该老师当天上课的课程
   public function getTeacherClass(){
         //(1)获取变量
        $data['volunteer_id'] = I('get.volunteer_id');
        $data['class_id'] = I('get.class_id');
        $data['project_id'] = I('get.project_id');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) && empty($data['volunteer_id']) && empty($data['project_id'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $classId     = $data['class_id'];
        $projectId   = $data['project_id'];
        $volunteerId = $data['volunteer_id'];
        $result = $this->getTeachToday($classId,$projectId);
        $k = 0;
        $teachplan = array();
        for($i=0;$i<count($result);$i++){
            if($result[$i]['volunteer_id'] == $volunteerId){
                $teachplan[$k] = $result[$i]['teachplan_id'];
                $k++;
            }
        }
        $a = array_unique($teachplan);
        $b = array_keys($a);
        for($i=0;$i<count($a);$i++){
            $t = $b[$i];
            $class[$i]['teachplan_id'] = $a[$t];
            $class[$i]['chapter_name'] = $result[$t]['chapter_name'];
            $class[$i]['course_name'] = $result[$t]['course_name'];
        }
        if($class){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获得该老师当天上课的课程的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //获得该教案已签到的学生
   public function getSignInStu(){
        //(1)获取变量
        $data['teachplan_id'] = I('get.teachplan_id');
        $data['class_id']     = I('get.class_id');
        $data['signin_time']  = I('get.time');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['teachplan_id']) && empty($data['class_id']) && empty($data['signin_time'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $time = $data['signin_time'] ;
        $teachplanId = $data['teachplan_id'];
        $classId     = $data['class_id'];
        $result = D('studentsign')->signinStu($time,$classId,$teachplanId);
        if($result){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获得该教案已签到的学生的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //获得该教案未签到的学生
   public function getLateStu(){
        //(1)获取变量
        $data['teachplan_id'] = I('get.teachplan_id');
        $data['class_id']     = I('get.class_id');
        $data['signin_time']  = I('get.time');
        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['teachplan_id']) && empty($data['class_id']) && empty($data['signin_time'])){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $time = $data['signin_time'] ;
        $teachplanId = $data['teachplan_id'];
        $classId     = $data['class_id'];
        $result = D('studentsign')->getOffStu($time,$classId,$teachplanId);
        if($result){
        $output['info'] = $result;
		$output['status'] = 1;//1：表示操作成功
		$output['url'] = "";
		$this->ajaxReturn($output);
        }else{
            $output['info'] = '获得该教案未签到的学生的操作失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');
   }

   //签到
   public function signIn(){

        //(1)获取变量
        $data['teachplan_id'] = I('get.teachplan_id');
        $studentId = I('post.student_id');

        //(2)权限判断（判断用户是否为项目负责人）
        $userId = $_SESSION['user_id'];  //用户id
        $result = xxx($data['project_id'],$userId);
        if (!$result){
            $this->error('该用户没有权限');
        }

        //(3)变量有效性判断
        if (empty($data['class_id']) || empty($studentId)){
            $this->error('获取数据有错误');
        }

        //(4)接口主要功能实现(简单说明逻辑)
        $sum = 0;
        $n = count($studentId);
        foreach($studentId as $v){
            $data['student_id'] = $v;
            $data['time'] = date("Y-m-d",time());
            if(D('studentsign')->sign($data)){
                $sum = $sum + 1;
            }
        }
        if($sum == $n){
            $output['info'] = '签到成功';
            $output['status'] = 1;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }else{
            $output['info'] = '签到失败';
            $output['status'] = 0;//1：表示操作成功
            $output['url'] = "";
            $this->ajaxReturn($output);
        }
        //(5)返回数据
        //$this->success('result'); //$this->error('reason');    
   }

   //获得该班级当天每节课的教案详情
   public function getTplanToday($classId,$projectId){
        $date = date("Y-m-d",time());
		$date = explode('-',$date);
		$this->assign('date',$date);
		$total_class_num = D('schedule')->classNumber($projectId);//这一天有多少节课
		$classInfo = D('classtable')->dayClassInfo($classId,$date);//这一天课的安排
		$someclass = array('第一节','第二节','第三节','第四节','第五节','第六节','第七节','第八节','第九节','第十节');
		$teachplan =array();
		$teachplan[0] = $classInfo['first'];
		$teachplan[1] = $classInfo['second'];
		$teachplan[2] = $classInfo['third'];
		$teachplan[3] = $classInfo['fourth'];
		$teachplan[4] = $classInfo['fifth'];
		$teachplan[5] = $classInfo['sixth'];
		$teachplan[6] = $classInfo['seventh'];
		$teachplan[7] = $classInfo['eighth'];
		$teachplan[8] = $classInfo['ninth'];
		$teachplan[9] = $classInfo['tenth'];
		for($m=0;$m<$total_class_num;$m++){
			$class[$m]['teachplan_id'] = $teachplan[$m];
			$class[$m]['class_name'] = $someclass[$m];
			$teachplanId = $class[$m]['teachplan_id'];
			$result = D('teachplan')->getTeachplan($teachplanId);
            $class[$m]['chapter_name'] = $class[$m]['chapter_name'];
            $courseId = $result['course_id'];
            $result1 = D('course')->getCourse($courseId);
			$class[$m]['course_name'] = $result1['course_name'];
			$volunteerId = $result1['volunteer_id'];
            $class[$m]['volunteer_id'] = $result1['volunteer_id'];
			$result2 = D('volunteer')->selectVolunteerById($volunteerId)；
            $class[$m]['name'] = $result1['name'];
		} 
        return $class;
   }

   //获得该班级当天上课的老师详情
   public function getTeachToday($classId,$projectId){
       $result = $this->getTplanToday($classId,$projectId);
       $teacher = array();
       $teacherName = array();
       for($i=0;$i<count($result);$i++){
           $teacher[$i] = $result[$i]['volunteer_id'];
           $teacherName[$i] = $result[$i]['name'];
       }
       $a = array_unique($teacher);
       $b = array_keys($a);
       for($i=0;$i<count($a);$i++){
            $t = $b[$i];
            $teacher[$i]['volunteer_id'] = $a[$t];
            $teacher[$i]['name'] = $teacherName[$t];
            $teacher[$i]['teachplan_id'] = $result[$t]['teachplan_id'];
            $teacher[$i]['chapter_name'] = $result[$t]['chapter_name'];
            $teacher[$i]['class_name'] = $result[$t]['class_name'];
            $teacher[$i]['course_name'] = $result[$t]['course_name'];
       }
       return $teacher;

   }

    //获取特定班级的数目
    public function getClassNum($grade,$projectId){
        $class = D('class')->getGrade_allclass($projectId,$grade);
        $classNum = count($class);
        if ($classNum == 9){
            $this->error('该年级拥有班级数至多为9个');
        }
        switch($grade){
                    case '一年级':
                        $result['grade_id'] = '01';
                        break;
                    case '二年级':
                        $result['grade_id'] = '02';
                        break;
                    case '三年级':
                        $result['grade_id'] = '03';
                        break;
                    case '四年级':
                        $result['grade_id'] = '04';
                        break;
                    case '五年级':
                        $result['grade_id'] = '05';
                        break;
                    case '六年级':
                        $result['grade_id'] = '06';
                        break;
                    case '初一':
                        $result['grade_id'] = '07';
                        break;
                    case '初二':
                        $result['grade_id'] = '08';
                        break;
                    case '初三':
                        $result['grade_id'] = '09';
                        break;
                    default:;
            }
        $sum = 0;
        if($class[0]['class_id'] != '00'){
            for($i=0;$i<$classNum;$i++){
            $str = $class[$i]['class_name'];
            $length = strlen($str);
            $a = strlen($str);
            $name = substr($str,$a,$length);
                switch($name){
                    case '一班':
                        $sum = $sum + 1;
                        break;
                    case '二班':
                        $sum = $sum + 1;
                        break;
                    case '三班':
                        $sum = $sum + 1;
                        break;
                    case '四班':
                        $sum = $sum + 1;
                        break;
                    case '五班':
                        $sum = $sum + 1;
                        break;
                    case '六班':
                        $sum = $sum + 1;
                        break;
                    case '七班':
                        $sum = $sum + 1;
                        break;
                    case '八班':
                        $sum = $sum + 1;
                        break;
                    case '九班':
                        $sum = $sum + 1;
                        break;
                    default:;
            }
         }
         $result['num'] = $sum;
         $result['total'] = $classNum;
         $result['grade_id'] = $grade_id;
        }else{
            $result['num'] = 0;
            $result['total'] = 0;
            $result['grade_id'] = $grade_id;
        }
        
        return $result;
    
    }
    //判断该班级是否有学生
    public function hadStu($classId){
        $result = D('studentclass')->getStudent($classId);
        $num = count($result);
        if($num == 0){
            return 1;
        }
        else{
            return 0;
        }
        
    }
    //获取该班级的所有志愿者
    public function allvolunInClass($classId){
        $result = D('classcourse')->allVolunInClass($classId);
        return $result;
    }
    //获取该项目的特定地点的编号
    public function getLocationId(projectId){
        $project = D("project")->getProject($projectId);
        $locationId = $project['location_id'];
        if($locationId > 9 && $locationId < 100){
            
            $locationId = '0'.$locationId;
			
        }else{

		    $locationId = '00'.$locationId;

			}
        return $locationId;

    }
    //获取当天该地点创建学生需要的编号
    public function getStuInToday($locationId){
        $result = D('student')->getTodaystu($locationId);
        $num = count($result);
        switch ($num) {
            case '9':
                    $num = '010';
                    break;
            case '99':
                    $num = '100';
                    break;
            case '0':
                    $num = '001';
                    break;
            case null:
                    $num = '001';
                    break;
            case $num > 100:
                    $num = $num + 1;
                    break;
            case $num > 9 && $num < 99:
                    $num = $num + 1;
                    $num = '0'.$num;
                    break;
            
            case 0<$num && $num < 9:
                    $num = $num + 1;
                    $num = '00'.$num;
                    break;
            default:;
        }
        return $num;
    }
}