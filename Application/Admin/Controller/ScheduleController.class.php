<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
use Admin\Model\ScheduleModel;
class ScheduleController extends CommonController {
    public function index(){

    }

    public function addSchedule() {
    	$date = I('post.date');
    	$time = I('post.time');
    	$theme = I('post.theme');
    	$identity = I('post.identity');
    	$conferenceID = I('post.conferenceID');

    	$data['date'] = $date;
    	$data['time'] = $time;
    	$data['theme'] = $theme;
    	$data['identity'] = $identity;
    	$data['conferenceID'] = $conferenceID;

    	$schedule = M('Schedule');
    	$result = $schedule->add($data);
    	if($result) {
    		$msg = "信息添加成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "信息添加失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }

    public function changeSchedule() {
    	$id = I('id');
    	$date = I('post.date');
    	$time = I('post.time');
    	$theme = I('post.theme');
    	$identity = I('post.identity');
    	$conferenceID = I('post.conferenceID');

    	$data['date'] = $date;
    	$data['time'] = $time;
    	$data['theme'] = $theme;
    	$data['identity'] = $identity;
    	$data['conferenceID'] = $conferenceID;

    	$shcedule = M('Schedule');
    	$result = $schedule->where(array('id'=>$id))->save($data);
    	if($result) {
    		$msg = "信息修改成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "信息未变动或修改失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}

    	public function deleteSchedule(){
    		$id = I('id');
    		$schedule = M('Schedule');
    		$result = $shcedule->delete($id);
	    	if($result) {
	    		$msg = "信息删除成功";
	    		$result = returnMsg(1,$msg);
	    		$this->ajaxReturn($result,"json");
	    	} else {
	    		$msg = "信息删除失败";
	    		$result = returnMsg(0,$msg);
	    		$this->ajaxReturn($result,"json");
	    	}
    	}

    	public function Schedule() {
    		$id = I('id');
    		$date = I('date');
    		$theme = I('theme');
    		$conferenceID = I('conferenceID');

    		$schedule = M('Schedule');

    		if($id||$date||$theme||$conferenceID) {
    			$msg = "无查询条件";
	    		$result = returnMsg(0,$msg);
	    		$this->ajaxReturn($result,"json");
    		} else if ($id) {
    			//如果id存在, 则忽略其他查询数据
    			$result = $schedule->where(array('id'=>$id))->select();
    			if ($result)
    				$this->ajaxReturn($result,"json");
    			else {
	    			$msg = "NULL";
		    		$this->ajaxReturn($msg,"json");
    			}
    		} else if ($date)
    			$data['date'] = $date;
    		  else if ($theme)
    		  	$data['theme'] = array('like', '%'.$theme.'%');
    		  else if ($conferenceID)
    		  	$data['conferenceID'] = $conferenceID;

    		$result = $schedule->where($data)->select();
    		if ($result)
    			$this->ajaxReturn($result,"json");
    		else
    			$this->ajaxReturn('NULL','json');
    	}
    }
}