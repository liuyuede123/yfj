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
				<a href="category/manage_cate">文章分类列表</a> >> <?php echo $cate_info['id'] === 0 ? '添加文章分类' : '编辑分类--'.$cate_info['title']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">分类名</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="title" value="<?php echo my_echo($cate_info['title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="ename" class="col-sm-2 control-label">英文名</label>
						<div class="col-sm-10">
							<input class="form-control" name="ename" id="ename" value="<?php echo my_echo($cate_info['ename']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">分类URL</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><?php echo $site_url; ?></span>
								<input class="form-control" name="url" id="url" value="<?php echo my_echo($cate_info['url']); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="site_title" class="col-sm-2 control-label">网站Title</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_title" id="site_title" value="<?php echo my_echo($cate_info['site_title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_keywords" class="col-sm-2 control-label">网站Keywords</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_keywords" id="site_keywords" value="<?php echo my_echo($cate_info['site_keywords']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_description" class="col-sm-2 control-label">网站Description</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="site_description" id="site_description" cols="30" rows="10"><?php echo my_echo($cate_info['site_description']); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">分类简介</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="intro" id="intro" cols="30" rows="10"><?php echo my_echo($cate_info['intro']); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="tpl" class="col-sm-2 control-label">分类模板</label>
						<div class="col-sm-10">
							<input class="form-control" name="tpl" id="tpl" value="<?php echo my_echo($cate_info['tpl'], 'default_category'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="arc_tpl" class="col-sm-2 control-label">文章默认模板</label>
						<div class="col-sm-10">
							<input class="form-control" name="arc_tpl" id="arc_tpl" value="<?php echo my_echo($cate_info['arc_tpl'], 'default_article'); ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo $cate_info['id']; ?>">
							<button type="button" class="btn btn-primary" onclick="save_cate()">保存</button>
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

<script>
	
function save_cate(){
	if($.trim($('#title').val()) == '' || $.trim($('#url').val()) == ''){
		alert('请完成表单');
	}else{
		$.post(admin.url+'category_action/save_cate',
		$('form').serialize(),
		function (result){
			result = $.parseJSON(result);
			if(result.status){
				alert('保存成功');
				location.href = admin.url+'category/manage_cate/';
			}else{
				alert(result.msg);
			}
		})
	}
}

</script>