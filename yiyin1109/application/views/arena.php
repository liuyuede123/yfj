<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">擂台记录</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a class="btn btn-primary" href="arena/edit_record">添加擂台记录</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>名次</th>
								<th>姓名</th>
								<th>账号</th>
								<th>收益率</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($arena_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['account']; ?></td>
								<td><?php echo $v['rate']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="arena/edit_record/<?php echo $v['id']; ?>">编辑</a>
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