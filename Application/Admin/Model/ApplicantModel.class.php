<?php
namespace Admin\Model;
use Think\Model;

class ApplicantModel extends Model {

	/**
	 * 新增报名
	 */
	public function join($uid, $conferenceID) {
		$data = array(
				'uid'=>$uid,
				'conferenceID'=>$conferenceID
			);

		$result = $this->add($data);
		return $result;
	}

	/**
	 * 取消报名,或审核未通过
	 */
	public function cancle($id) {
		$data['use'] = -1;
		$result = $this->where(array('id'=>$id))->save($data);
		return $result;
	}

	/**
	 * 通过报名
	 */
	public function pass($id) {
		$data['use'] = 1;
		$result = $this->where(array('id'=>$id))->save($data);
		return $result;
	}
}

?>