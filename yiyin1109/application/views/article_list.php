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
				<?php echo $cate_info['title']; ?> >> 文章列表 <a class="btn btn-primary" href="category/edit_article/<?php echo $cate_id; ?>">添加文章</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>文章标题</th>
								<th>点击量</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($article_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><?php echo $v['click']; ?></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo $site_url.$cate_info['url'].'/'.$v['id']; ?>" target="_blank" class="btn btn-info">浏览</a>
										<a class="btn btn-primary" href="category/edit_article/<?php echo $cate_id.'/'.$v['id']; ?>">编辑</a>
										<?php if($cate_id == 5){?>
										<a class="btn btn-success" href="category/edit_art_album/<?php echo $v['id']; ?>">相册</a><?php } ?>
										<button type="button" class="btn btn-danger" onclick="del_article(<?php echo $v['id']; ?>)">删除</button>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
					<div class="pull-right"><?php echo $pagin; ?></div>	
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<script>
	
function del_article(id){
	if(confirm('确认删除该文章？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'category_action/del_article',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>