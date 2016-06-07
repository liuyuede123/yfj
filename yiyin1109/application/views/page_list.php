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
				单页面列表 <a class="btn btn-primary" href="single/edit_page">添加单页面</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>页面标题</th>
								<th>URL</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($page_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><a href="<?php echo $site_url.$v['url']; ?>" target="_blank"><?php echo $site_url.$v['url']; ?></a></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo $site_url.$v['url']; ?>" target="_blank" class="btn btn-info">浏览</a>
										<a class="btn btn-primary" href="single/edit_page/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_single(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_single(id){
	if(confirm('确认删除该页面？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'single_action/del_page',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>