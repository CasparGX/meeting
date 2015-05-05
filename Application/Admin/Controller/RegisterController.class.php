<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\UserModel;
use Admin\Controller\ConfirmEmailController;
class RegisterController extends Controller {

	/**
	 * 注册页,回复邮件,添加信息进入数据库
	 */
    public function index(){
    	//获取post数据
    	$name = I('post.name');
    	$email = I('post.email');
    	$password = I('post.password');
    	$power = 4;
    	$cdkeyTime = date("Y-m-d H:i:s",strtotime("+7 day"));
    	$cdkey = md5($cdkeyTime);

    	//检测信息是否完整
    	if ($name==""||$email==""||$password=="") {
    		$result = returnMsg(0,"信息填写不完整");
    		$this->ajaxReturn($result,"json");
    	}

    	//数据库操作
    	$user = D('User');
    	$result = $user->where(array('email'=>$email))->select();
		if($result) {
			$msg = "该邮箱已被注册";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
		}

    	$result = $user->addUser($name, $email, $password, $power, $cdkey, $cdkeyTime);
    	if(!$result) {
    		$result = returnMsg(0,"注册失败,请联系管理员");
    		$this->ajaxReturn($result,"json");
    	}
    	$id = $result;

    	//邮件主题
    	$subject = "欢迎注册我们";
    	//邮件确认点击链接
    	$mailURL = U("/Admin/Register/confirm/id/".$id."/email/".md5($email)."/cdkey/".$cdkey,"","",true);
    	//echo $mailURL;
    	//邮件正文
    	$mailBody = "欢迎注册我们的会议召集系统<br/>";
    	$mailBody .= "你的用户名为:".$name."<br/>";
    	$mailBody .= "请点击<a href='".$mailURL."' target='_blank'>确认邮箱并激活账号</a><br/>";
    	$mailBody .= "如果链接打不开,请复制下面的地址到浏览器打开<br/>";
    	$mailBody .= $mailURL."<br/>";
    	//发送邮件
    	$mail = ConfirmEmailController::think_send_mail($email, $name, $subject, $mailBody, null);
    	if ($mail!=1) {
    		$result = returnMsg(0,$mail);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$result = returnMsg(1,"注册成功");
    		$this->ajaxReturn($result,"json");
    	}
    }

    public function confirm($id,$email,$cdkey) {
    	$user = D("User");
    	$result = $user->confirm($id,$email,$cdkey);
    	if($result) {
    		$msg = "账户激活成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "账户激活失败,请重新验证";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }



    public function testRegister() {
    	$this->display();
    }




}