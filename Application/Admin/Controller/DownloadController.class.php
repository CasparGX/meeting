<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class DownloadController extends CommonController {
    public function index(){
        $this->display();
    }

    public function upload($cid) {
    	$uploadPath = "./Public/uploadfile/conference/".$cid."/download/";
        //1,引入模块包
        //import('@.Org.Net.UploadFile');
        //2,实例化对象，调用对象的方法
        $file = new \Think\UploadFile();
        //3,上传的话需要做一些设置
    /*
        //文件保存为原文件名
        $file ->saveRule = "";
    */
        //默认情况下是-1，代表不限制文件的大小
        $file ->maxSize = '50000000';
        //allowExts 设置上传文件的扩展名
        $file ->allowExts = array('txt','doc','cls','ppt','pdf');
        //允许上传文件的类型
        //$file ->allowTypes = array('image/png','image/jpg','image/pjpeg','image/gif','image/jpeg');
         // 上传文件保存路径
         $file->savePath = $uploadPath;
         // 存在同名是否覆盖
         $file->uploadReplace = true;
         $uploadPath = "/Public/uploadfile/conference/".$cid."/download/";
         if($file->upload()){
             $info = $file->getUploadFileInfo();
             //dump($info);die();
			 $result['title'] = $info['name'];
			 $result['path'] = $info['savapath'].$info['savename'];

         }else{
             //$this->ajaxReturn(returnMsg(0,$file->getErrorMsg()),'json');
         	$this->error($file->getErrorMsg());
         }
    }

    public function uploadPaper() {
    	//正式使用时用session();
    	//$uid = session('uid');
    	$uid = I('uid');
    	//$name = session('username');
    	//$name = I('name');//取消引用name
    	$cid = I('post.cid');
    	if(empty($_FILES)) {
    		$this->error("请选择上传的文件");
    	} else {
    		$result = $this->upload($uid);
    		$title = $result['title'];
    		$path = $result['path'];

    		$download = D('Downlaod');
    		$result = $download->upload($title, $uid, $path, $cid);
    		if($result) {
    			$this->success("文件上传成功");
    		} else {
    			$this->error("文件上传失败");
    		}
    	}
    }

    public function deleteFile() {
        $id = I('id');
        $download = M('Downlaod');
        $result = $download->delete($id);

        //删除文件
        $path = $news->where(array('id'=>$id))->find();
        $path = '.'.$path['path'];
        unlink($path);
        //数据库操作
        if($result) {
            $msg = "文件删除成功";
            $result = returnMsg(1,$msg);
            $this->ajaxReturn($result,"json");
        } else {
            $msg = "文件删除失败";
            $result = returnMsg(0,$msg);
            $this->ajaxReturn($result,"json");
        }

    }


}