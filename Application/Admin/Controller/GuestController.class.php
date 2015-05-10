<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class GuestController extends CommonController {
    public function index(){

    }

    public function addGuest() {
    	$name = I('post.name');
    	$intro = I('post.intro');
    	$identity = I('post.identity');
    	$conferenceID = I('post.conferenceID');
    	$avatar = null;
    	$scale = null;
    	if($name==""||$intro==""||$identity==""||$conferenceID=="")
    		$this->error("信息不完整");
    	if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        }else{
        	$path = "guest/avatar/";
    		$result = upload($id,$path);
    		$scale = $result['scale'];
    		$avatar = $result['path'];

    		$guest = D('Guest');
    		$result = $guest->addGuest($name, $intro, $identity, $conferenceID, $avatar, $scale);
        	if($result) {
        		$this->success("操作成功");
        	} else {
        		$this->error("操作失败,请联系管理员");
        	}
        }
    }

    public function changeInfo() {
    	$id = I('id');
    	$data['name'] = I('post.name');
    	$data['intro'] = I('post.intro');
    	$data['identity'] = I('post.identity');
    	if($data['name']==""||$data['intro']==""||$data['identity']==""||$id=="")
    		$this->error("信息不完整");
    	$guest = M('Guest');
    	$result = $guest->where(array('id'=>$id))->save($data);
    	if($result) {
    		$msg = "嘉宾信息修改成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "嘉宾信息修改失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }

    public function changeAvatar() {
    	$id = I('id');
    	if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        }else{
        	$path = "guest/avatar/";
    		$result = upload($id,$path);
    		$scale = $result['scale'];
    		$avatar = $result['path'];

    		$guest = D('Guest');
    		$result = $guest->changeAvatar($id, $avatar, $scale);
        	$this->success("嘉宾图片修改成功");
        }
    }

    public function deleteGuest() {
    	$id = I('id');
    	$guest = M('Guest');
    	$result = $guest->delete($id);
    	if ($result==0){
    		$msg = "无此嘉宾记录";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	} else if ($result==false) {
    		$msg = "数据删除失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "嘉宾信息删除成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }

}