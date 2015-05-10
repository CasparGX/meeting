<?php
namespace Admin\Model;
use Think\Model;

class DownloadModel extends Model {

	public function upload($title, $uid, $path, $cid) {
		$data = array(
				'title'=>$title,
				'uid'=>$uid,
				'path'=>$path,
				'conferenceID'=>$cid
			);

		return $this->add($data);
	}

}

?>