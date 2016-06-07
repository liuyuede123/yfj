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
</head>
<body>
<?php include_once('common/header.php'); ?>      
<!-- banner -->
<div class="banner_about soft_banner"></div>  
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
					<a>下载专区 &gt;</a>
					<?php echo isset($cateid)?"<a href=".$url.">{$catetitle} &gt;</a>":''; ?>
					<a><?php echo $title; ?></a>
				</div>
			</div>
							<?php if(isset($cateid)){ ?>
							<?php include_once("content_article.php"); ?>   
							<?php }else{ ?>
							<?php include_once("content_{$url}.php"); ?>   
							<?php } ?>
			
						 
						
				
			
		</div>
		<!-- 右边 -->
		<div class="about_middle_right">
			<dl class="about_right_title1">
				<dt class="about_word1">下载<br>专区</dt>
				<dd class="about_word3"><a href="soft#hangqing" class="about_word3_nav hangqing">行情软件</a></dd>
				<dd class="about_word3"><a href="soft#jiaoyi" class="about_word3_nav jiaoyi">交易软件</a></dd>
				<dd class="about_word3"><a href="soft#moni" class="about_word3_nav moni">模拟软件</a></dd>
				<dd class="about_word3"><a href="soft#shouji" class="about_word3_nav shouji">手机软件</a></dd>
				<?php $id = isset($cateid)?$cateid:$id; ?>
				<dd class="about_word3"><a href="information" class="about_word3_nav <?php echo $id==24?'curent_about_word3_nav':''; ?>">资料下载</a></dd>
			</dl>
			<dl class="about_right_title2">
				<dt class="about_word2"><a href="soft">软件下载<br><span class="songti">DOWNLOAD</span></a></dt>
			</dl>			
		</div>
		<script>
		var url = location.href;
		var urlarr = url.split('#');
		var flag = urlarr[1];
		console.log(flag);
		if(flag){
			$('.soft_ware .'+flag).css('display','inline-block');
			$('.soft_ware .'+flag).siblings().css('display','none');
			$('.about_word3 .'+flag).attr('class','about_word3_nav curent_about_word3_nav '+flag);
		}
		$('.about_word3').click(function(){
			url = $(this).find('a').attr('href');
			urlarr = url.split('#');
			flag = urlarr[1];
			console.log(flag);
			$(this).siblings().find('a').attr('class','about_word3_nav ');
			if(flag){
				$('.soft_ware .'+flag).css('display','inline-block');
				$('.soft_ware .'+flag).siblings().css('display','none');
				$('.about_word3 .'+flag).attr('class','about_word3_nav curent_about_word3_nav '+flag);
			}
		});
			
			
		</script>
	</div>
</div>  
		<?php //include_once('common/sidebar_about.php'); ?>
		
<?php include_once('common/footer.php'); ?>

</body>
</html>