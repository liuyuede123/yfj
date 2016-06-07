<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">专题列表管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="special/special_list/">专题列表</a> >> <?php echo isset($special_info['title']) ? $special_info['title'] : '添加专题'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($special_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
							<input class="form-control" name="url"  id="url" value="<?php echo my_echo($special_info['url']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">是否前台显示</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="is_show" value="0" <?php echo my_echo($special_info['is_show'], 0) != 1 ? 'checked' : ''; ?> > 否
							</label>
							<label class="radio-inline">
								<input type="radio" name="is_show" value="1" <?php echo my_echo($special_info['is_show']) == 1 ? 'checked' : ''; ?> > 是
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">简介</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="intro" id="intro" rows="10"><?php echo my_echo($special_info['intro']); ?></textarea>
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
						$img = my_echo($special_info['img']);
						$img_path = '../upload/web_img/'.$img;
						if($img != '' and file_exists($img_path)):
						?>
						<div class="col-sm-5">
							已上传图片: <a href="<?php echo $img_path; ?>" target="_blank"><img src="<?php echo $img_path; ?>" width="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($special_info['id'], 0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_page()">保存</button>
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

<script type="text/javascript">

function save_page(){
	$.post(admin.url+'special_action/save_special',
	$('form').serialize(),
	function (result){
		result = $.parseJSON(result);
		if(result.status){
			alert('页面保存成功');
			location.href = admin.url+'special/edit_special/'+result.id;
		}else{
			alert(result.msg);
		}
		
	})
}

</script>