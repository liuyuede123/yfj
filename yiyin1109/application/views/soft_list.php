<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">软件管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				软件列表 <a class="btn btn-primary" href="soft/edit_soft">添加软件</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>标题</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($soft_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="soft/edit_soft/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_soft(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_soft(id){
	if(confirm('确认删除该软件？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'soft/del_soft',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>