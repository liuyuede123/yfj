<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">专题列表管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				专题列表 <a class="btn btn-primary" href="special/edit_special">添加专题</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>专题标题</th>
								<th>URL</th>
								<th>是否前台显示</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($special_list as $v): ?>
							<tr>
								<td><?php echo $v['title']; ?></td>
								<td><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['url']; ?></a></td>
								<td><?php echo $v['is_show'] == 0 ? '<span style="color:red">否</span>' : '是'; ?></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo $v['url']; ?>" target="_blank" class="btn btn-info">浏览</a>
										<a class="btn btn-primary" href="special/edit_special/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_special(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_special(id){
	if(confirm('确认删除该专题？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'special_action/del_special',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>