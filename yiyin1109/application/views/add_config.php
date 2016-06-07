<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">网站配置</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="website/">配置列表</a> >> 添加配置
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">配置名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name">
						</div>
					</div>
					<div class="form-group">
						<label for="attr" class="col-sm-2 control-label">属性名</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">config_</span>
								<input class="form-control" name="attr" id="attr">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="value" class="col-sm-2 control-label">属性值</label>
						<div class="col-sm-10">
							<input class="form-control" name="value" id="value">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="save_config()">保存</button>
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

function save_config(){
	$.post(admin.url+'website/add_config_action',
	$('form').serialize(),
	function (data){
		data = $.parseJSON(data);
		if(data.status){
			alert('添加成功');
			location.href = admin.url+'website/'
		}else{
			alert(data.msg);
		}
	})
}

</script>