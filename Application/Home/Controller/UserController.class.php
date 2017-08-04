<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    	/**
	 * session包括：
	 * 志愿者id:volunteer_id
	 * 社团id:community_id
	 * 志愿者姓名:name
	 * 账号类型:0组织，1志愿者
	 * 通过$info数组获取，在其他函数中请勿定义$info
	 */
	 public $info = array();
	
	function __construct(){//构造函数
		$this->info=session();
		parent::__construct();
    }
	//用户控制器
    public function User(){
        $this->display();
    }
	
	public function index(){
		$mail = '442422194qq.com';  //邮箱地址
		$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
		echo preg_match($pattern, $mail, $matches);
		var_dump($matches);  //输出匹配结果
	}
	
	
	
	//注册
	public function register(){
        $type = I('type');
		$username = I("user_name");
		$phone = I('phone');
		$email = I('email');
		$password = I('password');
        $passwordSure = I('password_sure');
		// $type = "0";
		// $username = "zouxiaomin";
		// $phone = "13771913006";
		// $email = "442422194@qq.com";
		// $password = "123456";
        // $passwordSure = "123456";
		// echo "type:".$type.",username:".$username.",phone:".$phone.",email:".$email.",password:".$password.",sure:".$passwordSure;
        //$verifyCode = I('verify_code');
        //$this->checkVerify($verifyCode);//检查图片验证码
        if (strlen($username) > 20 || strlen($username) < 4){
            $this->error('用户名长度不符合！');
        }
        if (strlen($password) > 20 || strlen($password) < 6){
            $this->error('密码长度不符！');
        }
        if ($password != $passwordSure){
            $this->error('两次密码不一致');
        }
		if ($type == '0'){
            //组织社团注册
            $this->checkPhone("0","",$phone);
			$this->checkEmail("",$email);
			$data['type'] = $type;
            $data['community_name'] = $username;
            $data['public_email'] = $email;
			$data['head_phone'] = $phone;
            $data['password'] = md5($password);
            if ($communityId = D('Community')->addCommunity($data)){
				session('community_id',$communityId);
                session('name',$username);
                session('type',$type);
                $this->success('注册成功');
            }else 
				$this->error('注册失败');
        
		}elseif ($type == '1'){//志愿者登录，短信验证码需要另写函数进行调用。
            $data['type'] = $type;
            $data['user_name'] = $username;
            $data['password'] = md5($password);
            $data['phone'] = $phone;
            $this->checkPhone("1","",$phone);
            /* $code = I('code');//手机验证码
            if ($code!=null && $code != session('code')){
                $this->error('手机验证码错误');
                exit;
            } */
            if ($volunteerId = D('Volunteer')->addVolunteer($data)){
				session('volunteer_id',$volunteerId);
                session('name',$username);
                session('type',$type);
                $this->success('注册成功');
            }else 
                $this->error('注册失败');
        }else{
			$this->error("输入参数错误");
		}
    }
	
	//登录
	public function login(){
		$username = I("user_name");
		$password = I("password");
		$result = D('volunteer')->login($phone,md5($password));
		if($result){
			$this->success("登录成功");
		}
	}
	
	//获取志愿者的个人主页信息
	public function getVolunteerInfo(){
		$volunteerId = I('volunteer_id');
		$volunteerInfo = D('volunteer')->selectVolunteerById($volunteerId);
		$volunteer['volunteer_id'] = $volunteerInfo['volunteer_id'];
		$volunteer['name'] = $volunteerInfo['user_name'];
		$volunteer['school'] = $volunteerInfo['school'];
		$volunteer['email'] = $volunteerInfo['email'];
		$volunteer['signature'] = $volunteerInfo['signature'];
		$volunteer['picture'] = $volunteerInfo['picture'];
		$volunteer['gold'] = $volunteerInfo['gold'];
		if($volunteerId == $this->info['volunteer_id']){
			$volunteer['is_focus'] = 1;
		}else{
			$data['fans_id'] = $volunteerId;
			$data['fans_type'] = "1";
			$data['focus_id'] = $this->info['volunteer_id'];
			$data['focus_type'] = $this->info['type'];
			$is_focus = D('fans')->checkIsFans($data);
			$volunteer['is_focus'] = $is_focus;
		}
		$number = D('fans')->selectFansAndFocus($volunteerId,"1");
		$volunteer['fans_num'] = $number['followed_num'];
		$volunteer['focus_num'] = $number['follow_num'];
		if($volunteer == null){
			$this->error("获取志愿者信息失败");
		}else{
			$data['info'] = $volunteer;
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
	}
	
	//获取志愿者详细信息
	public function getVolunteerDetail(){
		$volunteerId = I('volunteer_id');
		$volunteer = D('volunteer')->selectVolunteerById($volunteerId);
		if($volunteer == null){
			$this->error("获取志愿者信息失败");
		}else{
			$data['info'] = $volunteer;
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
	}
	
	//获取组织的主页信息
	public function getCommunity(){
		$communityId = I('community_id');
		$communityInfo = D('community')->selectVolunteerById($communityId);
		$community['community_id'] = $communityInfo['community_id'];
		$community['community_name'] = $communityInfo['community_name'];
		$community['belong_school'] = $communityInfo['belong_school'];
		$community['pulic_email'] = $communityInfo['public_email'];
		$community['signature'] = $communityInfo['signature'];
		$community['picture'] = $communityInfo['picture'];
		$community['gold'] = $communityInfo['gold'];
		if($communityId == $this->info['community_id']){
			$community['is_focus'] = 1;
		}else{
			$data['fans_id'] = $communityId;
			$data['fans_type'] = "0";
			$data['focus_id'] = $this->info['community_id'];
			$data['focus_type'] = $this->info['type'];
			$is_focus = D('fans')->checkIsFans($data);
			$community['is_focus'] = $is_focus;
		}
		$number = D('fans')->selectFansAndFocus($communityId,"0");
		$community['fans_num'] = $number['followed_num'];
		$community['focus_num'] = $number['follow_num'];
		if($community == null){
			$this->error("获取组织信息失败");
		}else{
			$data['info'] = $community;
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
	}
	
	//获取组织详细信息
	public function getCommunityDetail(){
		$communityId = I('community_id');
		$communityInfo = D('community')->selectVolunteerById($communityId);
		if($community == null){
			$this->error("获取组织信息失败");
		}else{
			$data['info'] = $community;
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
	}
	
//检测验证码
	public function checkVerify($code, $id = ''){
        $verify = new \Think\Verify();
        if (!$verify->check($code, $id)) {
            $this->error('验证码错误或过期');
        }
		$this->success("验证码正确");
    }
	
//验证手机号
	public function isUniquePhone(){
		$type = I('type');
		$phone = I('phone');
		if($type == '0'){//组织
			$communityId = $this->info["community_id"];
		}elseif($type == '1'){
			$userId = $this->info["volunteer_id"];
		}
		$this->checkPhone($type,$userId,$phone);
		$this->success("该手机号还没注册");
	}
	
//验证组织的公共邮箱
	public function isUniqueEmail(){
		$email = I('email');
		$communityId = $this->info["community_id"];
		checkEmail($communityId,$email);
		$this->success("该邮箱还没注册");
	}
	
//验证邮箱是否合法及唯一
	public function checkEmail($communityId,$email){
		if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', $email, $matches)){
			$this->error('请输入合法的邮箱！');
		}
		$result = D('community')->checkCommunity($communityId,"email",$email);
		if($result){
			$this->error("该邮箱已存在");
		}
	}
	
//验证手机号是否合法及唯一
	public function checkPhone($type,$userId,$phone){
		if (strlen($phone) != 11 || !preg_match('/1[3-8]+\d{9}/', $phone, $matches)){
            $this->error('请输入合法的手机号！');
        }
		if($type=="0"){
			if(D('community')->checkCommunity($userId,'phone',$phone)){
				$this->error('该手机号已存在');
			}
		}elseif($type=="1"){
			if (D('volunteer')->checkVolunteer($userId,$phone)) {
                $this->error('该手机号已存在');
            }
		}	
	}
	
	
	//发送手机验证码
	public function phoneCode(){
		$phone = I('phone');
        $action = I('action');
        if ($action == 'register') {//注册时，需要判断手机号是否已注册
            if (D('volunteer')->checkVolunteer("",$phone)) {
                $this->error('该手机号已经注册');
            }
        }elseif($action == 'forget'){//忘记密码时，需要判断手机号是否存在
			if (!$this->checkPhone($phone)) {
                $this->error('该手机号不存在');
            }
		}
        $code = mt_rand(1000, 9999);//随机数产生验证码
        session('code',$code,10*60);//设置session值
        $result = sendMsg($code, $phone);//????????????????????????????????
		if ($result == 'ok'){
            $this->success('短信发送成功！');
        }else 
            $this->error('短信发送失败，错误码：'.$result);
    }
	
//生成验证码
    public function pictureCode(){
        //验证码
        $Verify = new \Think\Verify();
        $Verify->fontSize = 30; //设置字体大小
        $Verify->length = 4;
        $Verify->expire = 60;//验证码过期时间(s)
        $Verify->useNoise = false;
        $Verify->entry();
    }
	
	//检测验证码，type=0为手机验证码，type=1为图片验证码
	public function testCode(){
		$type = I('type');
		$code = I('code');
		if($type == 0){
			
		}elseif($type == 1){
			$result = $this->checkVerify($data['verifyCode']);
			if($result){
				$this->success("验证成功");
			}else{
				$this->error("验证失败");
			}
		}else{
			$this->error("参数错误");
		}
		
	}
	
	
	
	//注销
    public function logout(){
        session(null);
        $this->success('注销成功');
    }
	
	//获取问卷所有问题
	public function getAllAnswer(){
		
	}
}