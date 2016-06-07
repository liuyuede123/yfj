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
				Banner图片列表 <a class="btn btn-primary" href="banner/edit_banner">添加Banner</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>标题</th>
								<th>图片预览</th>
								<th>URL</th>
								<th>排序</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($banner_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><a href="../upload/web_img/<?php echo $v['img']; ?>"  target="_blank"><img src="../upload/web_img/<?php echo $v['img']; ?>" height="100" width="auto"></a> 
								</td>
								<td><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['url']; ?></a></td>
								<td><?php echo $v['sort']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="banner/edit_banner/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_banner(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_banner(id){
	if(confirm('确认删除该Banner？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'banner/del_banner',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>