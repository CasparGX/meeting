<?php if (!defined('THINK_PATH')) exit();?><!-- 用户页 -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

</head>

<body>
	<form action='<?php echo U("/Admin/User/changeAvatar","","","");?>' method='POST' enctype='multipart/form-data'>
	<div id="inputFile">
        <input type='file' name='file[]'/><br/>
    </div>
    <input name="id" type="text" />
        <input type='submit' value='上传'/>
    </form>
</body>
</html>