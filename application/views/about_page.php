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
<link rel="stylesheet" href="css/contact.css">
</head>
<body>
<?php include_once('common/header.php'); ?>      
<!-- banner -->
<div class="banner_about about_us_banner"></div>  
<!-- index中间部分 -->
<div class="middle_section">
	<div class="middle_about">
		<!-- 左边 -->
		<div class="contact_middle_left">
			<div class="about_left_head">
				<div class="about_left_head_left">
					<span class="about_left_head_left_h"><?php echo $title; ?></span>
					<span class="about_left_head_left_p"><?php echo $ename; ?></span>
				</div>
				<div class="about_left_head_right">
					<span>您的当前位置:</span>
					<a href="/">首页 &gt;</a>
					<a>关于我们 &gt;</a>
					<a><?php echo $title; ?></a>
				</div>
			</div>
			
						<?php include_once("content_{$url}.php"); ?>    
					
				
			
		</div>
		<!-- 右边 -->
		<div class="about_middle_right">
			<dl class="about_right_title1">
				<dt class="about_word1">关于<br>我们</dt>
				<?php 
					$siderright = get_page('3,14,11,12,10,16,2'); 
					foreach($siderright as $v){
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