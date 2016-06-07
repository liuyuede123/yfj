 <?php
$config = get_website_config();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?php echo $title.'——'.$config['config_title']; ?></title>
<meta name="keywords" content="<?php echo $site_keywords?$site_keywords:$config['config_keywords']; ?>"/>
<meta name="description" content="<?php echo $site_description?$site_description:$config['config_description']; ?>"/>
<base href="<?php echo base_url(); ?>"/>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/about.css">
<link rel="stylesheet" href="css/soft.css">
<link rel="stylesheet" href="css/company_news.css">
</head>
<body>
<?php include_once('common/header.php'); ?>      
<?php //include_once('common/banner.php'); ?>    
<!-- banner -->
<div class="banner_about company_trend_banner"></div>
<!-- index中间部分 -->
<div class="middle_section">
	<div class="middle_about">
		<!-- 左边 -->
		<div class="about_middle_left">
			<div class="about_left_head">
				<div class="about_left_head_left">
					<?php if(isset($cateid)){ ?>
						<span class="about_left_head_left_h"><?php echo $catetitle; ?></span>
						<span class="about_left_head_left_p"><?php echo $cateename; ?></span>
					<?php }else{ ?>
						<span class="about_left_head_left_h"><?php echo $title; ?></span>
						<span class="about_left_head_left_p"><?php echo $ename; ?></span>
					<?php } ?>
				</div>
				<div class="about_left_head_right">
					<span>您的当前位置:</span>
					<a href="/">首页 &gt;</a>
					<a>公司动态 &gt;</a>
					<?php echo isset($cateid)?"<a href=".$url.">{$catetitle} &gt;</a>":''; ?>
					<a><?php echo $title; ?></a>
				</div>
			</div>
						<?php if(isset($cateid)){ ?>
							<?php //if($cateid == 22){ ?>
							<?php //include_once("content_video.php"); ?>   
							<?php //}else{ ?>
							<?php include_once("content_article.php"); ?>   
							<?php //} ?>
						
						<?php }else if($id==17 OR $id==21){  ?>
						<?php include_once("content_activity.php"); ?>    
						<?php }else{ ?>
						<?php include_once("content_{$url}.php"); ?>   
						<?php } ?>
					
				
			
		</div>
		<!-- 右边 -->
		<div class="about_middle_right">
			<dl class="about_right_title1">
				<dt class="about_word1">公司<br>动态</dt>
				<?php 
					$siderright = get_category('15,5,17,22,21'); 
					foreach($siderright as $v){
						$id = isset($cateid)?$cateid:$id;
						if($v['id']==$id){
				?>
				<dd class="about_word3"><a href="<?php echo $v['url']; ?>" class="about_word3_nav curent_about_word3_nav"><?php echo $v['title']; ?></a></dd>
						<?php }else{ ?>
				<dd class="about_word3"><a href="<?php echo $v['url']; ?>" class="about_word3_nav"><?php echo $v['title']; ?></a></dd>
					<?php }} ?>
				<!--<dd class="about_word3"><a href="javascript:;" class="about_word3_nav curent_about_word3_nav">陕金所介绍</a></dd>
				<dd class="about_word3"><a href="javascript:;" class="about_word3_nav ">股东背景</a></dd>
				<dd class="about_word3"><a href="javascript:;" class="about_word3_nav">中心资质</a></dd>
				<dd class="about_word3"><a href="javascript:;" class="about_word3_nav ">董事长致辞</a></dd>-->
			</dl>
			<dl class="about_right_title2">
				<dt class="about_word2"><a href="soft">软件下载<br><span class="songti">DOWNLOAD</span></a></dt>
			</dl>			
		</div>
	</div>
</div>  
		<?php //include_once('common/sidebar_about.php'); ?>
		
<?php include_once('common/footer.php'); ?>
</body>
</html>