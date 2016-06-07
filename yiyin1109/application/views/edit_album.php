<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">文章分类管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="category/manage_cate">文章分类列表</a> >> <?php echo '编辑分类相册--'.$cate_info['title']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<input type="hidden" value="<?php echo $cate_info['id']; ?>" id="cate_id">
				<div id="fileList" class="uploader-list"></div>
				<div id="filePicker">上传图片</div>
				<div class="row">
				<?php foreach($album_list as $v): ?>
					<div class="col-lg-3">
						<div class="panel panel-default">
							<div class="panel-body">
								<a href="<?php echo $site_url.'upload/img/'.$v['img']; ?>"  target="_blank"><img src="<?php echo $site_url.'upload/img/'.$v['img']; ?>" class="img-responsive"></a>
							</div>
							<div class="panel-footer">
								<div class="input-group">
									<input type="text" class="form-control" value="<?php echo $v['text']; ?>" id="text_<?php echo $v['id']; ?>">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" onclick="save_text(<?php echo $v['id']; ?>)">保存</button>
										<button class="btn btn-default" type="button" onclick="del_picture(<?php echo $v['id']; ?>)">删除</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				</div>

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
<script src="plugins/webuploader/webuploader.multi.config.js"></script>

<script>
	
function save_text(id){
	var text = $('#text_'+id).val();
	$.post(admin.url+'category_action/save_text',
	{id:id, text:text},
	function (){
		alert('保存成功');
		location.reload();
	})
}

function del_picture(id){
	if(confirm('确认删除该图片？')){
		$.post(admin.url+'category_action/del_album',
		{id:id},
		function (){
			alert("删除成功");
			location.reload();
		})
	}
}

</script>