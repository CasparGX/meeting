<?php
namespace Admin\Model;
use Think\Model;

class ScheduleModel extends Model {

	public function addSchedule($title, $content, $intro, $conferenceID, $creatTime) {

		$data = array(
    			'title'=>$title,
    			'content'=>$content,
    			'intro'=>$intro,
    			'conferenceID'=>$conferenceID,
    			'creatTime'=>$creatTime
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

	public function changeillustration($id, $illustration) {
		$data = array(
				'illustration'=>$illustration
			);
		return $this->where(array('id'=>$id))->save($data);
	}

}

?>