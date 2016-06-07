<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">文章管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				编辑文章 >> <?php echo isset($article_info['title']) ? $article_info['title'] : '添加文章'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">文章名</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($article_info['title']) ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="cate_id" class="col-sm-2 control-label">文章所属分类</label>
						<div class="col-sm-10">
							<select class="form-control" name="cate_id" id="cate_id">
								<?php foreach($cate_list as $v): ?>
								<option value="<?php echo $v['id']; ?>" <?php echo $v['id'] == $article_info['cate_id'] ? 'selected' : ''; ?>><?php echo $v['title']; ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="site_title" class="col-sm-2 control-label">网站Title</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_title" id="site_title" value="<?php echo my_echo($article_info['site_title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_keywords" class="col-sm-2 control-label">网站Keywords</label>
						<div class="col-sm-10">
							<input class="form-control" name="site_keywords" id="site_keywords" value="<?php echo my_echo($article_info['site_keywords']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_description" class="col-sm-2 control-label">网站Description</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="site_description" id="site_description" cols="30" rows="10"><?php echo my_echo($article_info['site_description']); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="tags" class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10">
							<input class="form-control" name="tags" id="title" value="<?php echo my_echo($article_info['tags']); ?>">
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
						$img = my_echo($article_info['img']);
						$img_path = '../upload/web_img/'.$img;
						if($img != '' and file_exists($img_path)):
						?>
						<div class="col-sm-5">
							已上传图片: <a href="<?php echo $img_path; ?>" target="_blank"><img src="<?php echo $img_path; ?>" width="100" height="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">银策略属性</label>
						<div class="col-sm-10">
							<?php
							$flags = explode(',', my_echo($article_info['flag']));
							foreach($flag_list as $v):
							?>
							<label class="checkbox-inline">
								<input type="checkbox" name="flag[]" value="<?php echo $v['flag']; ?>" <?php echo in_array($v['flag'], $flags) ? 'checked' : ''; ?> > <?php echo $v['name']; ?>
							</label>
							<?php endforeach ?>
							<span class="label label-primary">该属性仅针对银策略生效</span>
						</div>

					</div>
					<!--   
					
					<div class="form-group">
						<label for="keywords" class="col-sm-2 control-label">SEO关键词</label>
						<div class="col-sm-10">
							<input class="form-control" name="keywords"  id="keywords" value="<?php echo my_echo($article_info['keywords']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">SEO描述</label>
						<div class="col-sm-10">
							<input class="form-control" name="description" id="description" value="<?php echo my_echo($article_info['description']); ?>">
						</div>
					</div>
					@@@@@@@@@@@暂时没有这些功能的需求
					-->
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">文章简介</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="intro" id="intro" cols="30" rows="10"><?php echo my_echo($article_info['intro']) ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="container" class="col-sm-2 control-label">文章正文</label>
						<div class="col-sm-10">
							<script id="container" name="content" type="text/plain">
								<?php echo my_echo($article_info['content']); ?>
							</script>
						</div>
					</div>
					<div class="form-group">
						<label for="attach" class="col-sm-2 control-label">上传附件</label>
						<div class="col-sm-5">
							<input type="hidden" name="soft" id="soft">
							<div id="thelist" class="uploader-list"></div>
							<div class="btns">
								<div id="picker">选择文件</div>
								<button type="button" id="ctlBtn" class="btn btn-default">开始上传</button>
							</div>
						</div>
						<?php
						$attach = my_echo($article_info['attach']);
						$attach_path = '../upload/soft/'.$attach;
						if($attach != '' and file_exists($attach_path)):
						?>
						<div class="col-sm-5">
							已上传附件: <a href="<?php echo $attach_path; ?>" target="_blank">点此下载附件</a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($article_info['id'], 0); ?>">
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


<!-- ueditor配置文件 -->
<script src="<?php echo $site_url; ?>plugins/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script src="<?php echo $site_url; ?>plugins/ueditor/ueditor.all.js"></script>
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<script src="<?php echo $site_url; ?>plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<script>
	var editor = UE.getEditor('container', {'initialFrameHeight' : 600});

function save_article(){
	$.post(admin.url+'category_action/save_article',
	$('form').serialize(),
	function (id){
		alert('文章保存成功');
		location.reload();
	})
}

</script>