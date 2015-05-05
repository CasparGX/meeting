<?php
namespace Admin\Model;
use Think\Model;

class ApplicantModel extends Model {

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