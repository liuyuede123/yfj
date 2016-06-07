<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">会员管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				会员列表 <a href="member/member_edit/" class="btn btn-primary">添加会员</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>会员名</th>
								<th>手机号</th>
								<th>积分</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($member_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['phone']; ?></td>
								<td><?php echo $v['integral']; ?></td>
								<td>
									<div class="btn-group">
										<a href="member/member_edit/<?php echo $v['id']; ?>" class="btn btn-primary">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_member(<?php echo $v['id']; ?>)">删除</button>
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
	
function del_member(id){
	if(confirm('确认删除该会员？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'member/del_member',
		{'id': id},
		function (){
			location.reload();
		})
	}
}

</script>