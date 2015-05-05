<?php
namespace Admin\Model;
use Think\Model;
use Admin\Model\GuestModel;
class GuestModel extends Model {

	public function addGuest($name, $intro, $identity, $conferenceID, $avatar, $scale) {

		$data = array(
    			'name'=>$name,
    			'intro'=>$intro,
    			'identity'=>$identity,
    			'conferenceID'=>$conferenceID,
    			'avatar'=>$avatar,
    			'scale'=>$scale
    		);
		$lastInsID = $this->add($data);
		return $lastInsID;
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