<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">编辑我的信息</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">用户名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo $info['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nick" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-10">
							<input class="form-control" name="nick" id="nick" value="<?php echo $info['nick']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">上传头像</label>
						<div class="col-sm-5">
							<input type="hidden" name="avatar" id="img">
							<div id="fileList" class="uploader-list"></div>
							<div id="filePicker">选择图片</div>
						</div>
						<?php
						$avatar = $info['avatar'];
						$avatar_path = '../avatar/admin/'.$avatar;
						if($avatar != '' and file_exists($avatar_path)):
						?>
						<div class="col-sm-5">
							已上传头像: <a href="<?php echo $avatar_path; ?>" target="_blank"><img src="<?php echo $avatar_path; ?>" width="100" height="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password">
							<span class="label label-info">留空则不修改</span>
						</div>
					</div>
					<div class="form-group">
						<label for="repassword" class="col-sm-2 control-label">确认密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="repassword">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">简介</label>
						<div class="col-sm-10">
							<input class="form-control" name="intro" id="intro" value="<?php echo $info['intro']; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="save_user()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<!-- webuploader -->
<link rel="stylesheet" type="text/css" href="plugins/webuploader/webuploader.css">
<script src="plugins/webuploader/webuploader.min.js"></script>
<script src="plugins/webuploader/webuploader.config.js"></script>

<script>
	
function save_user(){
	if($.trim($('#name').val()) == ''){
		alert('请输入用户名');
	}else if( $.trim( $('#password').val() ) != $.trim( $('#repassword').val() ) ){
		alert('两次密码输入不一致');
	}else{
		$.post(admin.url+'user/save_user',
		$('form').serialize(),
		function (d){
			d = $.parseJSON(d);
			alert(d.msg);
			location.reload();
		})
	}
}

</script>