<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">直播视频</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a class="btn btn-primary" href="webcast/edit_cast">添加直播</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>时间</th>
								<th>标题</th>
								<th>主讲人</th>
								<th>直播链接</th>
								<th>点播链接</th>
								<th>是否结束</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($cast_list as $v): ?>
							<tr>
								<td><?php echo $v['time']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><?php echo $v['speaker']; ?></td>
								<td><a href="<?php echo $v['cast_url']; ?>" target="_blank">点击查看</a></td>
								<td><a href="<?php echo $v['demand_url']; ?>" target="_blank">点击查看</a></td>
								<td><?php if($v['is_finish']): ?><span style="color:red;">是</span><?php else: ?>否<?php endif; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="webcast/edit_cast/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_cast(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_cast(id){
	if(confirm('确认删除该直播？')){
		$.post(admin.url+'webcast/del_cast',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>