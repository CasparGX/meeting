<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\UserModel;
class CommonController extends Controller {

    protected function _initialize()
    {

		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Headers:Content-Type");
		header("Access-Control-Allow-Methods:*");


		$uid = session("uid");
		$email = session("email");

		$user = M('User');
		$result = $user->where(array('id'=>$uid))->find();
		//判断信息是否符合
		if($email!=$result['email']) {
			$this->error("登陆异常,请重新登陆");
		} else {
			//判断是否管理员权限
			if($result['power']==0) {
				//等于0为管理员权限,跳过验证
			} else {
				//不等于0则为用户权限,进行权限认证
				//获取当前控制器及操作
        		$this->controller = CONTROLLER_NAME;
				$this->action = ACTION_NAME;
				//判断调用控制器是否为用户权限内,否则返回错误
				if($this->controller=="Schedule" || $this->controller=="Download" || $this->controller=="User") {

				}
				switch($this->controller) {
					case "Schedule":

						break;
					case "Download":

						break;
					case "User":

						break;
					default:
						$this->error("页面错误");
				}

			}
		}
    }


    //判断权限
    protected function power() {

    }

}