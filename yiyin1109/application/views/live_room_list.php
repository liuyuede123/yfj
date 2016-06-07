<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">直播室房间管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				直播室房间列表 <a class="btn btn-primary" href="live/edit_room">添加房间</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>房间名</th>
								<th>主持人</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($room_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['nick']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="live/edit_room/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_room(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_room(id){
	if(confirm('确认删除该房间？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'live/del_room',
		{'id': id},
		function (){
			location.reload();
		})
	}
}

</script>