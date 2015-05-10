<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
use Admin\Model\UserModel;
class UserController extends CommonController {

    public function index(){
    	$this->display();
    }

    public function login() {
    	$email = I('email');
    	$password = I('password');
    	$password = md5($password);

    	$data['email'] = $email;
    	$data['password'] = $password;

    	$user = M('User');
    	$result = $user->where($data)->find();

    	if ($result) {
    		if($result['use']==0) {
	    		$this->ajaxReturn("账号未激活","json");
	    	} else if($result) {
	    		$this->ajaxReturn($result,"json");
	    	}
    	} else {
    		$this->ajaxReturn("账号不存在","json");
    	}


    }

    public function changeInfo() {
    	$id = I('id');
    	$name = I('post.name');
    	$sex = I('post.sex');
    	$phone = I('post.phone');
    	$intro = I('post.intro');
    	$pay = I('post.pay');

    	$user = D('User');
    	$result = $user->changeInfo($id, $name, $sex, $phone, $intro);
    	if($result) {
    		$msg = "信息修改成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "信息修改失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }

    public function changeAvatar() {
    	$id = I('id');

    	if(empty($_FILES)){
    		//没有上传头像就用默认头像
    		$avatar = "/Public/uploadfile/user/avatar/dedfaultAvatar.jpg";
    		$scale = 1;
    	} else {
    		$path = "user/avatar/";
    		$result = upload($id,$path);
    		$scale = $result['scale'];
    		$avatar = $result['path'];
    	}
    	//dump($result);die();
    	$user = D("User");
    	$result = $user->changeAvatar($id, $avatar, $scale);
    	//if($result) {
    		$this->success("操作成功");//数据库遇到原数据提交默认为不成功, 不需要判断,
		//} else {
		//	echo $result;die();
		//	$this->error("操作失败,请联系管理员");
		//}
    }


}