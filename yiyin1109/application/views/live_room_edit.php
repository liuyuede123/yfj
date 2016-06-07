<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">直播室房间管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="live/room_list">直播室房间列表</a> >> <?php echo $info['id'] == 0 ? '添加房间' : '编辑房间--'.$info['name']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">房间名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo $info['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">直播室简介</label>
						<div class="col-sm-10">
							<input class="form-control" name="intro" id="intro" value="<?php echo $info['intro']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="sort" class="col-sm-2 control-label">排序</label>
						<div class="col-sm-10">
							<input class="form-control" name="sort" id="sort" value="<?php echo $info['sort']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="subject" class="col-sm-2 control-label">今日主题</label>
						<div class="col-sm-10">
							<input class="form-control" name="subject" id="subject" value="<?php echo $info['subject']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="point" class="col-sm-2 control-label">今日看点</label>
						<div class="col-sm-10">
							<input class="form-control" name="point" id="point" value="<?php echo $info['point']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="tech" class="col-sm-2 control-label">今日技术</label>
						<div class="col-sm-10">
							<input class="form-control" name="tech" id="tech" value="<?php echo $info['tech']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">主持人</label>
						<div class="col-sm-10">
							<div class="btn-group" >
								<?php
								foreach($admin_list as $v):
								?>
								<label class="btn btn-success"><input type="radio" name="aid" value="<?php echo $v['id']; ?>" <?php if($info['aid'] == $v['id']): ?>checked<?php endif; ?>> <?php echo $v['nick']; ?></label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo $info['id']; ?>">
							<button type="button" class="btn btn-primary" onclick="save_room()">保存</button>
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
	
function save_room(){
	if( $('input[name=aid]:checked').val() == undefined ){
		alert('请选择主持人');
	}else{
		$.post(admin.url+'live/save_room',
		$('form').serialize(),
		function (){
			location.href = admin.url+'live/room_list';
		})
	}
}

</script>