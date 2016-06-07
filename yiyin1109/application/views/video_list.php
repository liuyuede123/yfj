<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">视频管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				视频列表 <a class="btn btn-primary" href="video/edit_video">添加视频</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>视频标题</th>
								<th>添加日期</th>
								<th>点击数</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($video_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><?php echo $v['date']; ?></td>
								<td><?php echo $v['click']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="video/edit_video/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_video(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_video(id){
	if(confirm('确认删除该视频？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'video/del_video',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>