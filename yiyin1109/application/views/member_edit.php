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
				<a href="member/">会员管理列表</a> >> <?php echo my_echo($info['id'], 0) == 0 ? '添加会员管理' : '编辑会员管理--'.$info['name']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">会员名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo my_echo($info['name']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nick" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-10">
							<input class="form-control" name="nick" id="nick" value="<?php echo my_echo($info['nick']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password">
							<?php if(my_echo($info['id'], 0) != 0): ?>
							<span class="label label-info">留空则不修改密码</span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-sm-2 control-label">手机号</label>
						<div class="col-sm-10">
							<input class="form-control" name="phone" id="phone" value="<?php echo my_echo($info['phone']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="integral" class="col-sm-2 control-label">会员积分</label>
						<div class="col-sm-10">
							<input class="form-control" name="integral" id="integral" value="<?php echo my_echo($info['integral'],0); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="permission" class="col-sm-2 control-label">会员等级</label>
						<div class="col-sm-10">
							<div class="btn-group" >
								<?php
								$gid = my_echo($info['gid'], 1);
								foreach($grade as $v):
								?>
								<label class="btn btn-success"><input type="radio" name="gid" value="<?php echo $v['id']; ?>" <?php if($gid == $v['id']): ?>checked<?php endif; ?>> <?php echo $v['name']; ?></label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="permission" class="col-sm-2 control-label">直播室房间</label>
						<div class="col-sm-10">
							<div class="btn-group" >
								<?php
								$lid = my_echo($info['lid'], 5);
								foreach($live as $v):
								?>
								<label class="btn btn-success"><input type="radio" name="lid" value="<?php echo $v['id']; ?>" <?php if($lid == $v['id']): ?>checked<?php endif; ?>> <?php echo $v['name']; ?></label>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo $info['id']; ?>">
							<button type="button" class="btn btn-primary" onclick="save_member()">保存</button>
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
	
function save_member(){
	if( $('#name').val() == '' ){
		alert('请输入会员名');
	}else{
		$.post(admin.url+'member/save_member',
		$('form').serialize(),
		function (result){
			result = $.parseJSON(result);
			if(result.status){
				alert('保存成功');
				location.href = admin.url+'member';
			}else{
				alert(result.msg);
			}
		})
	}
}

</script>