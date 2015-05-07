<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\ApplicantModel;

class ApplicantController extends Controller {
    public function index(){
    	$this->display();
    }

    /**
     * 报名加入
     */
    public function join() {
    	//正式启用时用session
    	//$uid = session('uid');
    	$uid = I('post.uid');
    	$conferenceID = I('post.conferenceID');

    	//查询该会议是否可报名
    	$conference = M('Conference');
    	$result = $conference->where(array('id'=>$conferenceID))->find();
    	$result = $result['use'];
    	if(!$result) {
    		$msg = "报名已结束";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}


    	$applicant = D('Applicant');
    	//查询是否已经报名
    	$data['uid'] = $uid;
    	$data['conferenceID'] = $conferenceID;
    	$result = $applicant->where($data)->select();
    	if($result) {
    		$msg = "不能重复报名";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}

    	//插入报名表中
    	$result = $applicant->join($uid, $conferenceID);
    	if ($result) {
    		$msg = "报名申请提交成功";
	    	$result = returnMsg(1,$msg);
	    	$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "报名申请提交失败";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}
    }

    /**
     * 取消报名,use字段设为-1
     */
    public function cancle() {
    	//正式启用时用session
    	//$uid = session('uid');
    	$id = I('id');
    	$uid = I('post.uid');
    	$conferenceID = I('post.conferenceID');

    	$applicant = D('Applicant');

    	//判断是否是该用户的报名记录
    	$result = $applicant->where(array('id'=>$id))->find();
    	if ($result['uid']!=$uid) {
    		$msg = "取消申请提交失败";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}

    	$result = $applicant->cancle($id);
    	if($result) {
    		$msg = "取消成功";
	    	$result = returnMsg(1,$msg);
	    	$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "取消失败";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}
    }

    /**
     * 用户查询自己的报名信息
     */
    public function query() {
    	//正式使用时用session
    	//$uid = session('uid');
    	$uid = I('uid');
    	$applicant = M('Applicant');
    	$result = $applicant->where(array('uid'=>$uid))->select();

    	if(!$result) {
    		$this->ajaxReturn('NULL',"json");
    	}

    	$conference = D('Conference');

    	$count = count($result);
    	for($i=0;$i<$count;$i++) {
    		$info[$i] = $conference->where(array('id'=>$result[$i]['conferenceid']))->select();
    	}
    	//dump($info);die();
    	$result = $info;
    	$this->ajaxReturn($result, "json");
    }

}