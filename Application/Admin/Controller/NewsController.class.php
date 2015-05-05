<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\NewsModel;
class NewsController extends Controller {
    public function index(){

    }

    public function addNews(){
    	$title = I('post.title');
    	$content = I('post.content');
    	$intro = I('post.intro');
    	$conferenceID = I('post.conferenceID');
    	$illustration = null;
    	$creatTime = date("Y-m-d H:i:s",time());
    	if($title||$content||$intro||$conferenceID) {
    		$this->error("信息填写不完整");
    	} else if (empty($_FILES)) {
    		$this->error('请选择需要上传的图片');
    	} else {
    		//加入数据库部分
    		$news = D('News');
    		$id = $news->addNews($title, $content, $intro, $conferenceID, $creatTime);
    		if($result) {
    			//上传图片部分
	    		$path = "conference/".$conferenceID."/news/";
	    		$result = upload($id,$path);
	    		//不需要比例结果
	    		//$scale = $result['scale'];
	    		$illustration = $result['path'];
	    		$result = $news->changeillustration($id, $illustration);
	        	$this->success("会议新闻新增成功");
    		} else {
    			$this->error("会议新闻添加失败,导入数据库失败");
    		}
    	}
    }

    public function changeNews() {
    	$id = I('id');
    	$title = I('post.title');
    	$content = I('post.content');
    	$intro = I('post.intro');
    	$data['title'] = $title;
    	$data['content'] = $content;
    	$data['intro'] = $intro;
    	$news = M('News');
    	$result = $news->where(array('id'=>$id))->save($data);
    	if($result) {
    		$msg = "信息修改成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "信息修改失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}

    }

    public function changeIllustration() {
    	$id = I('id');
    	$conferenceID = I('post.conferenceID');
    	if (empty($_FILES)) {
    		$this->error('请选择需要上传的图片');
    	} else {
    		//加入数据库部分
    		$news = D('News');
    			//上传图片部分
	    		$path = "conference/".$conferenceID."/news/";
	    		$result = upload($id,$path);
	    		//不需要比例结果
	    		//$scale = $result['scale'];
	    		$illustration = $result['path'];
	    		$result = $news->changeillustration($id, $illustration);
	        	$this->success("图片修改成功");
    	}
    }

    public function deleteNews() {
    	$id = I('id');
    	$news = M('News');
    	$path = $news->where(array('id'=>$id))->find();
    	$path = $path['illustration'];
    	$path = substr($path,1,strlen($path));
    	unlink($path);
    	$result = $news->delete($id);
    	if($result) {
    		$msg = "删除成功";
    		$result = returnMsg(1,$msg);
    		$this->ajaxReturn($result,"json");
    	} else {
    		$msg = "删除失败";
    		$result = returnMsg(0,$msg);
    		$this->ajaxReturn($result,"json");
    	}
    }
}







