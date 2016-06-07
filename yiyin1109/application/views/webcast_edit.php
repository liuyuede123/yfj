<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">直播视频</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="webcast/cast_list">直播视频</a> >> <?php echo my_echo($info['id'],0) === 0 ? '添加直播' : '编辑直播--'.$info['title']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="time" class="col-sm-2 control-label">时间</label>
						<div class="col-sm-10">
							<input class="form-control" name="time" id="time" value="<?php echo my_echo($info['time']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="title" value="<?php echo my_echo($info['title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="speaker" class="col-sm-2 control-label">主讲人</label>
						<div class="col-sm-10">
							<input class="form-control" name="speaker" id="speaker" value="<?php echo my_echo($info['speaker']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="cast_url" class="col-sm-2 control-label">直播链接</label>
						<div class="col-sm-10">
							<input class="form-control" name="cast_url" id="cast_url" value="<?php echo my_echo($info['cast_url']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="demand_url" class="col-sm-2 control-label">点播链接</label>
						<div class="col-sm-10">
							<input class="form-control" name="demand_url" id="demand_url" value="<?php echo my_echo($info['demand_url']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">是否结束</label>
						<div class="col-sm-10">
							<?php $is_finish = my_echo($info['is_finish'], 0); ?>
							<label class="radio-inline">
								<input type="radio" name="is_finish" value="0" <?php if($is_finish == 0): ?>checked<?php endif; ?> > 否
							</label>
							<label class="radio-inline">
								<input type="radio" name="is_finish" value="1" <?php if($is_finish == 1): ?>checked<?php endif; ?> > 是
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="sort" class="col-sm-2 control-label">排序</label>
						<div class="col-sm-10">
							<input class="form-control" name="sort" id="sort" value="<?php echo my_echo($info['sort']); ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo my_echo($info['id'],0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_cast()">保存</button>
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

function save_cast(){
	$.post(admin.url+'webcast/save_cast',
	$('form').serialize(),
	function (id){
		alert('保存成功');
		location.reload();
	})
}

</script>