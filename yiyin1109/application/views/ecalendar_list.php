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
				日历列表 <!-- <a class="btn btn-primary" href="ecalendar/edit_ecalendar">添加日历</a> --> <button class="btn btn-primary" onclick="collection()">采集日历</button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>时间</th>
								<th>国家</th>
								<th>指标名称</th>
								<th>重要性</th>
								<th>前值</th>
								<th>预测值</th>
								<th>公布值</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($ecalendar_list as $v): ?>
							<tr>
								<td><?php echo $v['date'].' '.$v['time']; ?></td>
								<td><?php echo $v['areaname']; ?></td>
								<td><?php echo $v['indexname']; ?></td>
								<td><?php
								$arr = array('低', '中', '高');
								echo $arr[$v['importantlever']-1]; 
								?></td>
								<td><?php echo $v['prevalue']; ?></td>
								<td><?php echo $v['nextvalue']; ?></td>
								<td><?php echo $v['economicdata']; ?></td>
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


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">努力采集中......</h4>
			</div>
			<div class="modal-body">
				亲，请稍等，本程序正在使出吃奶的力气从世界各地采集财经信息，大脑都快要短路了...... 
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	
function del_ecalendar(id){
	if(confirm('确认删除该日历？该操作不可恢复，请谨慎操作！')){
		$.post(admin.url+'ecalendar/del_ecalendar',
		{'id': id},
		function (){
			alert('删除成功');
			location.reload();
		})
	}
}

function collection(){
	$('#myModal').modal({keyboard: false});
	$.post(admin.url+'ecalendar/collection',
	'',
	function (){
		$('#myModal').modal('hide');
		location.reload();
	})
}

</script>