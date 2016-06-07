<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">软件管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="soft/">软件列表</a> >> <?php echo isset($soft_info['title']) ? $soft_info['title'] : '添加软件'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">软件名</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($soft_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="content" class="col-sm-2 control-label">软件简介</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="content" id="content" cols="30" rows="10"><?php echo my_echo($soft_info['content']) ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="img" class="col-sm-2 control-label">上传缩略图</label>
						<div class="col-sm-5">
							<input type="hidden" name="img" id="img">
							<div id="fileList" class="uploader-list"></div>
							<div id="filePicker">选择图片</div>
						</div>
						<?php
						$img = my_echo($soft_info['img']);
						$img_path = '../upload/web_img/'.$img;
						if($img != '' and file_exists($img_path)):
						?>
						<div class="col-sm-5">
							已上传图片: <a href="<?php echo $img_path; ?>" target="_blank"><img src="<?php echo $img_path; ?>" width="100" height="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="soft" class="col-sm-2 control-label">上传软件</label>
						<div class="col-sm-5">
							<input type="hidden" name="soft" id="soft">
							<div id="thelist" class="uploader-list"></div>
							<div class="btns">
								<div id="picker">选择文件</div>
								<button type="button" id="ctlBtn" class="btn btn-default">开始上传</button>
							</div>
						</div>
						<?php
						$soft = my_echo($soft_info['soft']);
						$soft_path = '../upload/soft/'.$soft;
						if($soft != '' and file_exists($soft_path)):
						?>
						<div class="col-sm-5">
							已上传软件: <a href="<?php echo $soft_path; ?>" target="_blank">点此下载软件</a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($soft_info['id'], 0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_article()">保存</button>
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

function save_article(){
	$.post(admin.url+'soft/save_soft',
	$('form').serialize(),
	function (id){
		alert('软件保存成功');
		location.href = admin.url+'soft/edit_soft/'+id;
	})
}

</script>