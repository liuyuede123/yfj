<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">财经日历管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="ecalendar/ecalendar_list">日历列表</a> >> <?php echo my_echo($ecalendar_info['id'],0) === 0 ? '添加日历' : '编辑日历--'.$ecalendar_info['title']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="title" value="<?php echo my_echo($ecalendar_info['title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="datetime" class="col-sm-2 control-label">时间</label>
						<div class="col-sm-10">
							<input class="form-control" name="datetime" id="datetime" value="<?php echo my_echo($ecalendar_info['datetime']); ?>" readonly >
						</div>
					</div>
					<div class="form-group">
						<label for="info" class="col-sm-2 control-label">内容</label>
						<div class="col-sm-10">
							<input class="form-control" name="info" id="info" value="<?php echo my_echo($ecalendar_info['info']); ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($ecalendar_info['id'],0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_ecalendar()">保存</button>
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

<script src="<?php echo $site_url; ?>plugins/datepicker/datepicker.min.js"></script>
<script src="<?php echo $site_url; ?>plugins/datepicker/timepicker-addon.js"></script>
<link rel="stylesheet" href="<?php echo $site_url; ?>plugins/datepicker/smoothness/datepicker.min.css">
<link rel="stylesheet" href="<?php echo $site_url; ?>plugins/datepicker/timepicker-addon.css">

<script>

$('#datetime').datetimepicker({dateFormat:'yy-mm-dd', timeFormat:'HH:mm'});

function save_ecalendar(){
	$.post(admin.url+'ecalendar/save_ecalendar',
	$('form').serialize(),
	function (id){
		alert('保存成功');
		// location.href = admin.url+'ecalendar/edit_ecalendar/'+id;
		location.reload();
	})
}

</script>