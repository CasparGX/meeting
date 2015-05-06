<?php
namespace Admin\Controller;
use Think\Controller;
class ConferenceController extends Controller {
    public function index(){
    	$this->display();
    }

    /**
     * 新建会议
     * 新建时创建对应ID的文件夹
     */
    public function addConference() {
    	$theme = I('post.theme');
    	$intro = I('post.intro');
    	$identity = I('post.identity');
    	$special = I('post.special');
    	$address = I('post.address');
    	$use = I('post.use');

    	$data['theme'] = $theme;
    	$data['intro'] = $intro;
    	$data['identity'] = $identity;
    	$data['special'] = $special;
    	$data['address'] = $address;
    	$data['use'] = $use;

    	$conference = M('Conference');
    	$result = $conference->add($data);
    	if($result)
    		$conferenceID = $result;
    	else
    		$this->error('信息添加失败');

    	//创建会议ID 对应的文件夹
    	mkdir("/Public/uploadfile/conference/".$conferenceID."/");
    	mkdir("/Public/uploadfile/conference/".$conferenceID."/news/");
    	mkdir("/Public/uploadfile/conference/".$conferenceID."/download/");

    	$this->success("信息添加成功");

    	//预留可能上传map

    }

    public function changeConference(){
    	$id = I('id');
    	$theme = I('post.theme');
    	$intro = I('post.intro');
    	$identity = I('post.identity');
    	$special = I('post.special');
    	$address = I('post.address');
    	$use = I('post.use');

    	$data['theme'] = $theme;
    	$data['intro'] = $intro;
    	$data['identity'] = $identity;
    	$data['special'] = $special;
    	$data['address'] = $address;
    	$data['use'] = $use;

    	$conference = M('Conference');
    	$result = $conference->where(array('id'=>$id))->save($data);
    	if($result) {
    		$this->success("信息修改成功");
    	} else {
    		$this->error('信息修改失败或者信息未变动');
    	}
    }

    public function deleteConference() {
    	$id = I('id');
    	//删除该会议ID的文件
    	$result = deldir("/Public/uploadfile/conference/".$id."/");
    	if($result) {
    		$conference = M('Conference');
    		$result = $conference->delete($id);
    		if($result) {
    			$this->success("删除成功");
    		} else {
    			$this->error("删除失败");
    		}

    	} else {
    		$this->error("文件删除失败,请检查文件权限");
    	}
    }

    public function testMap() {
    	if(empty($_FILES)) {
    		$this->error("请选择上传的图片test");
    	} else {
    		$this->changeMap();
    	}
    }

    public function changeMap($id) {

    	if(empty($_FILES)) {
    		$this->error("请选择上传的图片");
    	} else {
    		echo "!23";
    	}
    }

}