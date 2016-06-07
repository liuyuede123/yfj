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
				配置列表 <a class="btn btn-info" href="website/add_config">添加配置</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<?php foreach($config_list as $v): ?>
					<div class="form-group">
						<label for="<?php echo $v['attr']; ?>" class="col-sm-2 control-label"><?php echo $v['name']; ?></label>
						<div class="col-sm-8">
							<input class="form-control" name="value[]" id="<?php echo $v['attr']; ?>" value="<?php echo $v['value']; ?>">
							<input type="hidden" name="id[]" value="<?php echo $v['id']; ?>">

						</div>
						<div class="col-sm-1"><button type="button" class="btn btn-danger" onclick="del_config(<?php echo $v['id']; ?>)">删除</button></div>
						<div class="col-sm-1"><?php echo $v['attr']; ?></div>
					</div>
					<?php endforeach ?>
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
	$.post(admin.url+'website/save_config',
	$('form').serialize(),
	function (){
		alert('保存成功');
		location.reload();
	})
}

function del_config(id){
	if(confirm('确认删除该配置？')){
		$.post(admin.url+'website/del_config',
		{id:id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

</script>