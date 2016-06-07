<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">视频管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="video/">视频列表</a> >> <?php echo isset($video_info['title']) ? $video_info['title'] : '添加视频'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">视频标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="title" value="<?php echo my_echo($video_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="cate_id" class="col-sm-2 control-label">视频所属分类</label>
						<div class="col-sm-10">
							<select class="form-control" name="cate_id" id="cate_id">
								<?php
								$list = get_video_category();
								foreach($list as $v):
								?>
								<option value="<?php echo $v['id']; ?>" <?php echo $v['id'] === my_echo($video_info['cate_id'], 0) ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
								<?php endforeach ?>
							</select>
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
						$img = my_echo($video_info['img']);
						$img_path = '../upload/img/'.$img;
						if($img != '' and file_exists($img_path)):
						?>
						<div class="col-sm-5">
							已上传图片: <a href="<?php echo $img_path; ?>" target="_blank"><img src="<?php echo $img_path; ?>" width="100" height="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="speaker" class="col-sm-2 control-label">演讲者</label>
						<div class="col-sm-10">
							<input class="form-control" name="speaker"  id="speaker" value="<?php echo my_echo($video_info['speaker']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">视频链接</label>
						<div class="col-sm-10">
							<input class="form-control" name="url"  id="url" value="<?php echo my_echo($video_info['url']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="click" class="col-sm-2 control-label">点击数</label>
						<div class="col-sm-10">
							<input class="form-control" name="click"  id="click" value="<?php echo my_echo($video_info['click'], 0); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">视频简介</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="intro" id="intro" cols="30" rows="10"><?php echo my_echo($video_info['intro']) ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($video_info['id'], 0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_video()">保存</button>
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

function save_video(){
	$.post(admin.url+'video/save_video',
	$('form').serialize(),
	function (id){
		alert('视频保存成功');
		location.reload();
	})
}

</script>