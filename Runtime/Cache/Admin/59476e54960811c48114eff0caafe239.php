<?php if (!defined('THINK_PATH')) exit();?><!-- meeting Admin 注册页 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>

<body>

<div class="inputBox">
	<pre>name:<input type="text" name="name" id="name" /></pre>
	<pre>email:<input type="text" name="email" id="email" /></pre>
	<pre>password:<input type="password" name="password" id="password" /></pre>
	<pre><button id="btn-register" type="button" value="Register">Register</button></pre>
</div>

<div class="returnMsg">

</div>
<script type="text/javascript" src="/meeting/Public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript">
$("#btn-register").click(function(){
	$.ajax({
		url:'<?php echo U("/Admin/Register/index","","");?>',
		type:'post',
		data:{name:$('#name').val(),email:$('#email').val(),password:$('#password').val()},
		dataType:'json',
		success:function(data) {
			$('.returnMsg').append(data['msg']);
		}
	});
});
</script>
</body>

</html>