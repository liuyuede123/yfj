<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">单页面管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="single/page_list/">单页面列表</a> >> <?php echo isset($page_info['title']) ? $page_info['title'] : '添加单页面'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($page_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="ename" class="col-sm-2 control-label">英文名</label>
						<div class="col-sm-10">
							<input class="form-control" name="ename" id="ename" value="<?php echo my_echo($page_info['ename']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><?php echo $site_url; ?></span>
								<input class="form-control" name="url" id="url" value="<?php echo my_echo($page_info['url']); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">文章描述</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description" id="description" cols="30" rows="10"><?php echo my_echo($page_info['description']); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="site_keywords" class="col-sm-2 control-label">SEO关键词</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_keywords"  id="site_keywords" value="<?php echo my_echo($page_info['site_keywords']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_description" class="col-sm-2 control-label">SEO描述</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_description" id="site_description" value="<?php echo my_echo($page_info['site_description']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="container" class="col-sm-2 control-label">文章正文</label>
						<div class="col-sm-10">
							<script id="container" name="content" type="text/plain">
								<?php echo my_echo($page_info['content']); ?>
							</script>
						</div>
					</div>
					<div class="form-group">
						<label for="tpl" class="col-sm-2 control-label">页面模板</label>
						<div class="col-sm-10">
							<input class="form-control" name="tpl"  id="tpl" value="<?php echo my_echo($page_info['tpl'], 'default_page'); ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($page_info['id'], 0); ?>">
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

<!-- 配置文件 -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/ueditor.all.js"></script>
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
var editor = UE.getEditor('container', {'initialFrameHeight' : 600});

function save_page(){
	$.post(admin.url+'single_action/save_page',
	$('form').serialize(),
	function (result){
		result = $.parseJSON(result);
		if(result.status){
			alert('页面保存成功');
			location.href = admin.url+'single/edit_page/'+result.id;
		}else{
			alert(result.msg);
		}
		
	})
}

</script>