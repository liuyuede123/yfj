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
				<a href="member/mem_list">会员列表</a> >> 查看会员：<?php echo $member['name']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label">会员名</label>
						<div class="col-sm-10">
							<input class="form-control" value="<?php echo $member['name']; ?>" readonly >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">邮箱</label>
						<div class="col-sm-10">
							<input class="form-control" value="<?php echo $member['email']; ?>" readonly >
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="javascript:history.go(-1)">返回</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->