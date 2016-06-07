<script src="js/plugins/datepicker/bootstrap-datetimepicker.min.js"></script>
<script src="js/plugins/datepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<link rel="stylesheet" href="css/plugins/datepicker/bootstrap-datetimepicker.min.css">
<style>
.table>tbody>tr>td{vertical-align: middle;}
.date, #is_submit{display: inline; width: 200px;}
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">SEM统计</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<p>选择时间范围：
					<input type="text" class="form-control date" id="start" value="<?php echo $start; ?>" readonly > 至 <input type="text" class="form-control date" id="end" value="<?php echo $end; ?>" readonly >
					选择提交状态
					<select id="is_submit" class="form-control">
						<option value="2" <?php if($is_submit == 2): ?>selected<?php endif; ?>>提交且进呼叫系统</option>
						<option value="1" <?php if($is_submit == 1): ?>selected<?php endif; ?>>提交未进呼叫系统</option>
						<option value="0" <?php if($is_submit == 0): ?>selected<?php endif; ?>>未提交</option>
					</select>
					<button class="btn btn-success" onclick="search();">查看</button>
				</p>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>注册页面</th>
								<th>来源渠道</th>
								<th>留电数量</th>
								<th>合计</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($record_list as $k => $v): ?>
							<?php foreach($v['detail'] as $dk => $dv): ?>
							<tr>
								<?php if($dk == 0): ?>
								<td rowspan="<?php echo count($v['detail']); ?>"><a href="<?php echo $v['page']; ?>" target="_blank" ><?php echo str_replace(rtrim($site_url, '/'), '', $v['page']); ?></a></td>
								<?php endif; ?>
								<td><?php echo $dv['channel']; ?></td>
								<td><?php echo $dv['num']; ?></td>
								<?php if($dk == 0): ?>
								<td rowspan="<?php echo count($v['detail']); ?>"><?php echo $v['total']; ?></td>
								<?php endif; ?>
							</tr>
							<?php endforeach; ?>
						<?php endforeach ?>
						</tbody>
					</table>
					<div class="pull-left">统计：当前时间范围留电数量共<?php echo $record_num; ?>个</div>	
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
	
$('#start, #end').datetimepicker({ format:'yyyy-mm-dd hh:ii:ss', language:'zh-CN', autoclose:true, minView:0, todayBtn:true, todayHighlight:true, minuteStep:1 });

function search(){
	var start = $('#start').val();
	var end = $('#end').val();
	var is_submit = $('#is_submit').val();
	if(start == '' || end == ''){
		alert('请选择起始终止日期');
		return;
	}
	location.href = admin.url+'sem/statistics/'+start+'/'+end+'/'+is_submit;
}

</script>