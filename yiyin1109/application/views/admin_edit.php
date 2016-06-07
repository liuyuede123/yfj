<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">管理员管理</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="admin/">管理员列表</a> >> <?php echo $admin['id'] === 0 ? '添加管理员' : '编辑管理员--'.$admin['nick']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8 col-lg-offset-2" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">账号</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo $admin['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password">
							<?php if($admin['id'] != 0): ?>
							<span class="label label-info">留空则不修改密码</span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="nick" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-10">
							<input class="form-control" name="nick" id="nick" value="<?php echo $admin['nick']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">简介</label>
						<div class="col-sm-10">
							<input class="form-control" name="intro" id="intro" value="<?php echo $admin['intro']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="permission" class="col-sm-2 control-label">权限</label>
						<div class="col-sm-10">
							<div class="btn-group" >
								<?php $permission = explode(',', $admin['permission']); ?>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="base" <?php if(in_array('base', $permission)): ?>checked<?php endif; ?>> 基本内容管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="sem" <?php if(in_array('sem', $permission)): ?>checked<?php endif; ?>> SEM</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="phone" <?php if(in_array('phone', $permission)): ?>checked<?php endif; ?>> 查看手机号</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="member" <?php if(in_array('member', $permission)): ?>checked<?php endif; ?>> 会员管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="live" <?php if(in_array('live', $permission)): ?>checked<?php endif; ?>> 直播室</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
							<button type="button" class="btn btn-primary" onclick="save_admin()">保存</button>
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
	
function save_admin(){
	$.post(admin.url+'admin/save_admin',
	$('form').serialize(),
	function (result){
		result = $.parseJSON(result);
		if(result.status){
			alert('保存成功');
			location.href = admin.url+'admin';
		}else{
			alert(result.msg);
		}
	})

}

</script>