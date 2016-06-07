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
				文章分类列表 <a class="btn btn-primary" href="category/edit_cate">添加分类</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>分类名</th>
								<th>分类URL</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($cate_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><a href="<?php echo $site_url.$v['url']; ?>" target="_blank"><?php echo $site_url.$v['url']; ?></a></td>
								<td>
									<div class="btn-group">
										<a href="category/article_list/<?php echo $v['id']; ?>" class="btn btn-info">查看文章</a>
										<a class="btn btn-primary" href="category/edit_cate/<?php echo $v['id']; ?>">编辑</a>
										<a class="btn btn-success" href="category/edit_album/<?php echo $v['id']; ?>">相册</a>
										<button type="button" class="btn btn-danger" onclick="del_cate(<?php echo $v['id']; ?>)">删除</button>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
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
	
function del_cate(id){
	if(confirm('确认删除该分类？该操作不可恢复，请谨慎操作！若该分类下有文章或相册，请先清空该分类下的文章和相册')){
		$.post(admin.url+'category_action/del_cate',
		{'id': id},
		function (result){
			result = $.parseJSON(result);
			if(result.status){
				alert('删除成功');
				location.reload();
			}else{
				alert(result.msg);
			}
		})
	}
}

</script>