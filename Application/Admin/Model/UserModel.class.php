<?php
namespace Admin\Model;
use Think\Model;

class UserModel extends Model {

	public function addUser($name, $email, $password, $power, $cdkey, $cdkeyTime) {

		$data = array(
    			'name'=>$name,
    			'email'=>$email,
    			'password'=>$password,
    			'power'=>$power,
    			'cdkey'=>$cdkey,
    			'cdkey_time'=>$cdkeyTime
    		);
		$lastInsID = $this->add($data);
		return $lastInsID;
	}

	public function confirm($id,$email,$cdkey) {
		$user = $this->where(array('id'=>$id))->find();
		//判断激活码有效期
		if($user['use']==1) {
			return true;
		} else if(strtotime($user['cdkey_time'])>=date("Y-m-d H:i:s",time())) {
			if(md5($user['email'])!=$email){
				return false;
			} else if ($user['cdkey']!=$cdkey || $cdkey=="") {
				return false;
			} else {
				//将use字段设为1激活,将激活码删除
				$data = array(
						'use'=>1,
						'cdkey'=>''
					);
				$this->where(array('id'=>$id))->save($data);
				return true;
			}
		} else {
			return false;
		}
	}

	public function changeInfo($id, $name, $sex, $phone, $intro) {
		$data = array(
				'name'=>$name,
				'sex'=>$sex,
				'phone'=>$phone,
				'intro'=>$intro
			);
		return $this->where(array('id'=>$id))->save($data);


	}

	public function changeAvatar($id, $avatar, $scale) {
		$data = array(
				'avatar'=>$avatar,
				'scale'=>$scale
			);
		return $this->where(array('id'=>$id))->save($data);
	}

}

?>