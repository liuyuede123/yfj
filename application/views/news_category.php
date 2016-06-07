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
<!-- banner -->
<div class="banner_about data_center_banner"></div>  
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
					<a>资讯中心 &gt;</a>
					<?php echo isset($cateid)?"<a href=".$url.">{$catetitle} &gt;</a>":''; ?>
					<a><?php echo $title; ?></a>
				</div>
			</div>
						<?php if(isset($cateid)){ ?>
						<?php include_once("content_article.php"); ?>   
						<?php }else if($id==1 OR $id==25){ ?>
						<?php include_once("content_dailystrategy.php"); ?>    
						<?php }else{ ?>
						<?php include_once("content_{$url}.php"); ?>   
						<?php } ?>
					
				
			
		</div>
		<!-- 右边 -->
		<div class="about_middle_right">
			<dl class="about_right_title1">
				<dt class="about_word1">资讯<br>中心</dt>
				<?php 
					$siderright = get_category('20,1,23,25,9'); 
					foreach($siderright as $v){
						$id = isset($cateid)?$cateid:$id;
						if($v['id']==$id){
				?>
				<dd class="about_word3"><a href="<?php echo $v['url']; ?>" class="about_word3_nav curent_about_word3_nav"><?php echo $v['title']; ?></a></dd>
						<?php }else{ ?>
				<dd class="about_word3"><a href="<?php echo $v['url']; ?>" class="about_word3_nav"><?php echo $v['title']; ?></a></dd>
					<?php }} ?>
					<dd class="about_word3 about_word3_pages paddingB0" style="margin-top:-19px;">				
					<ul class="about_right_title1_page appear">
						<li><a href="tactics/?f=d" class="about_word3_nav about_word3_nav_small d">日 &nbsp&nbsp&nbsp&nbsp刊</a></li>
						<li><a href="tactics/?f=w" class="about_word3_nav about_word3_nav_small w">周 &nbsp&nbsp&nbsp&nbsp刊</a></li>
						<li><a href="tactics/?f=s" class="about_word3_nav about_word3_nav_small s">月 &nbsp&nbsp&nbsp&nbsp刊</a></li>
					</ul>
				</dd>

				<script>
					var flag = "<?php echo isset($_GET['f'])?$_GET['f']:'d'; ?>";
					var id = "<?php echo $id; ?>";
					if(id == 9){
						$('.about_word3 .'+flag).attr('class','about_word3_nav curent_about_word3_nav_small');
					}
					
				</script>
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