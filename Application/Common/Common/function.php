<?php
/**
 * 将收到的参数返回为数组信息
 */
function returnMsg($result,$msg) {
	$value = array(
			0 => 'error',
			1 => 'success'
		);
	$returnMsg = array(
			'result' => $value[$result],
			'msg' => $msg
		);
	//将数组转化为json格式,用ajaxReturn()时可自动转为json,不需要再转化.
	//$returnMsg = json_encode($returnMsg);
	return $returnMsg;
}

/**
 * 上传图片
 */

    function upload($id,$path){
        $uploadPath = "./Public/uploadfile/".$path;
        //1,引入模块包
        //import('@.Org.Net.UploadFile');
        //2,实例化对象，调用对象的方法
        $file = new \Think\UploadFile();
        //3,上传的话需要做一些设置
        //默认情况下是-1，代表不限制文件的大小
        $file ->maxSize = '5000000';
        //allowExts 设置上传文件的扩展名
        $file ->allowExts = array('jpg','gif','png','jpeg');
        //允许上传文件的类型
        $file ->allowTypes = array('image/png','image/jpg','image/pjpeg','image/gif','image/jpeg');
        //对上传文件进行缩略图处理
        $file->thumb = true;
        //缩略图的最大的宽度
        $file->thumbMaxWidth = '800';
        //缩略图的文件名
        $file->thumbFile = $id;
        //缩略图的最大的高度
        $file->thumbMaxHeight = '800';
        //缩略图的前缀
        $file->thumbPrefix = 'm_';
         // 缩略图保存路径
         $file->thumbPath= $uploadPath;
         //如果上传的图片和原图一样，是否删除原图
         $file->thumbRemoveOrigin = true;
         // 上传文件保存路径
         $file->savePath = $uploadPath;
         // 存在同名是否覆盖
         $file->uploadReplace = true;
         $uploadPath = "/Public/uploadfile/user/avatar/";
         if($file->upload()){
             $info = $file->getUploadFileInfo();
             //dump($info);die();
					//缩略图长宽比
	             	$imageSrc = ".".$uploadPath.$id.".".$info[0]["extension"];
         			$uploadPath = $imageSrc;
	             	$image = new \Think\Image2();
		            $image = $image->open($imageSrc);
		            $height = $image->height();
		            $width = $image->width();
		            if($height>=$width) {
		            	$result['scale'] = 1;
		            	$result['path'] = $uploadPath;
             			return $result;
		            } else {
		            	$result['scale'] = 0;
		            	$result['path'] = $uploadPath;
             			return $result;
		            }

         }else{
             //$this->ajaxReturn(returnMsg(0,$file->getErrorMsg()),'json');
         	$this->error($file->getErrorMsg());
         }
    }
?>