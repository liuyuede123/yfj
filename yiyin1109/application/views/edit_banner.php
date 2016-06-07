<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Banner图片管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="banner/">Banner图片列表</a> >> <?php echo isset($banner_info['title']) ? $banner_info['title'] : '添加Banner'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($banner_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">链接</label>
						<div class="col-sm-10">
							<input class="form-control" name="url" id="url" value="<?php echo my_echo($banner_info['url']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="sort" class="col-sm-2 control-label">排序</label>
						<div class="col-sm-10">
							<input class="form-control" name="sort" id="sort" value="<?php echo my_echo($banner_info['sort'],1) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="img" class="col-sm-2 control-label">上传新图片</label>
						<div class="col-sm-10">
							<input type="hidden" name="img" id="img">
							<div id="fileList" class="uploader-list"></div>
							<div id="filePicker">选择图片</div>
						</div>
					</div>
					<?php
					$img = my_echo($banner_info['img']);
					$img_path = '../upload/web_img/'.$img;
					if($img != '' and file_exists($img_path)):
					?>
					<div class="form-group">
						<label for="img" class="col-sm-2 control-label">已上传图片</label>
						<div class="col-sm-10">
							<a href="<?php echo $img_path; ?>" target="_blank"><img src="<?php echo $img_path; ?>" width="400" height="auto"></a>
						</div>
					</div>
					<?php endif ?>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" id="id" value="<?php echo my_echo($banner_info['id'], 0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_banner()">保存</button>
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

function save_banner(){
	if($('#id').val() == 0 && $('#img').val() == ''){
		alert('请上传图片');
	}else{
		$.post(admin.url+'banner/save_banner',
		$('form').serialize(),
		function (id){
			alert('Banner保存成功');
			location.href = admin.url+'banner/edit_banner/'+id;
		})
	}
}

</script>