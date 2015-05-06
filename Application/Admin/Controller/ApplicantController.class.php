<?php
namespace Home\Controller;
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
    	$conferenceID = I('conferenceID');

    	//查询该会议是否可报名
    	$conference = M('Conference');
    	$result = $conference->where(array('id'=>$conferenceID))->find();
    	$result = $result['use'];
    	if(!$result) {
    		$msg = "报名已结束";
	    	$result = returnMsg(0,$msg);
	    	$this->ajaxReturn($result,"json");
    	}

    	//插入报名表中
    	$applicant = D('Applicant');
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

    }

}