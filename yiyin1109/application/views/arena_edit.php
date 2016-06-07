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
				<a href="arena/">擂台记录</a> >> <?php echo my_echo($info['id'],0) === 0 ? '添加记录' : '编辑记录--"第'.$info['id'].'名"'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">姓名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo my_echo($info['name']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="account" class="col-sm-2 control-label">账号</label>
						<div class="col-sm-10">
							<input class="form-control" name="account" id="account" value="<?php echo my_echo($info['account']); ?>" >
						</div>
					</div>
					<div class="form-group">
						<label for="rate" class="col-sm-2 control-label">收益率</label>
						<div class="col-sm-10">
							<input class="form-control" name="rate" id="rate" value="<?php echo my_echo($info['rate']); ?>" >
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($info['id'],0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_record()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
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

<script>

function save_record(){
	$.post(admin.url+'arena/save_record',
	$('form').serialize(),
	function (id){
		alert('保存成功');
		location.reload();
	})
}

</script>