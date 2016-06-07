<?php
$role = $this->session->userdata('role') == 'admin' ? true : false;
$permission = $this->session->userdata('permission');
$permission = explode(',', $permission);
?>
<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<?php
			if($role OR in_array('base', $permission) ):
			?>
			<!--<li>
				<a href="category/manage_parentcate"><i class="fa fa-sitemap fa-fw"></i> 顶级分类分类管理</a>
			</li>-->
			<li>
				<a href="category/manage_cate"><i class="fa fa-sitemap fa-fw"></i> 文章分类管理</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-file-text fa-fw"></i> 文章管理<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<?php foreach($cate_list as $v): ?>
					<li><a href="category/article_list/<?php echo $v['id']; ?>"><?php echo $v['title']; ?></a></li>
					<?php endforeach ?>
				</ul>
			</li>
			<!--<li>
				<a href="#"><i class="fa fa-video-camera fa-fw"></i> 视频管理<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="video/">全部视频</a></li>
					<?php
					//$list = get_video_category();
					//foreach($list as $v):
					?>
					<li><a href="video/video_list/<?php //echo $v['id']; ?>"><?php //echo $v['name']; ?></a></li>
					<?php //endforeach ?>
				</ul>
			</li>-->
			<li>
				<a href="single/page_list"><i class="fa fa-file fa-fw"></i> 单页面管理</a>
			</li>
			<!--<li>
				<a href="wenjuan/get_wenjuan"><i class="fa fa-file fa-fw"></i> 问卷调查管理</a>
			</li>-->
			<!-- <li>
				<a href="banner/"><i class="fa fa-picture-o fa-fw"></i> Banner图片管理</a>
			</li> 
			<li>
				<a href="ecalendar/"><i class="fa fa-calendar fa-fw"></i> 财经日历</a>
			</li>-->
			<li>
				<a href="soft/"><i class="fa fa-download fa-fw"></i> 软件下载</a>
			</li>
			<!--<li>
				<a href="special/"><i class="fa fa-file fa-fw"></i> 专题列表</a>
			</li>
			<li>
				<a href="webcast/cast_list"><i class="fa fa-video-camera fa-fw"></i> 视频直播</a>
			</li>-->
			<?php endif; ?>
			<?php
			if($role OR in_array('phone', $permission) ):
			?>
			<li><a href="phone/"><i class="fa fa-mobile fa-fw"></i> 手机号列表</a></li>
			<?php endif; ?>

			<?php if($role): ?>
			<li><a href="admin/"><i class="fa fa-users fa-fw"></i> 管理员管理</a></li>
			<?php endif; ?>

		

			

		</ul>
	<!-- /#side-menu -->
	</div>
	<!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->