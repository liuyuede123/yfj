<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">手机号管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a class="btn btn-primary" href="phone/download">一键下载</a>
				<button type="button" class="btn btn-danger" onclick="del_phone(0);">一键清空</button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<!-- <th>#</th> -->
								<th>姓名</th>
								<th>手机号</th>
								<th>时间</th>
								<th>页面标题</th>
								<!-- <th>着陆页</th> -->
								<th>最终页</th>
								<th>来源引擎</th>
								<th>IP城市</th>
								<!-- <th>标识</th> -->
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($phone_list as $v): ?>
							<tr>
								<!-- <td><?php echo $v['id']; ?></td> -->
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['phone']; ?></td>
								<td><?php echo $v['time']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<!-- <td><a href="<?php echo $v['landing_page']; ?>" target="_blank" ><?php echo str_replace($site_url, '', $v['landing_page']); ?></a></td> -->
								<td><a href="<?php echo $v['last_page']; ?>" target="_blank" ><?php echo str_replace($site_url, '', $v['last_page']); ?></a></td>
								<td><?php echo $v['engine']; ?></td>
								<td><?php echo $v['province']; ?></td>
								<!-- <td><?php echo $v['remark']; ?></td> -->
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-danger" onclick="del_phone(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_phone(id){
	if(confirm('确认删除该手机号？')){
		$.post(admin.url+'phone/del_phone',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>