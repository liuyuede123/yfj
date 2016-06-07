<?php
$config = get_website_config();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo $config['config_title']; ?></title>
	<meta name="keywords" content="<?php echo $config['config_keywords']; ?>"/>
	<meta name="description" content="<?php echo $config['config_description']; ?>"/>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/index.css">
	<base target="_blank" />
</head>
<body onresize="resize();">
<?php include_once('common/header.php'); ?>
<!-- banner -->
<div class="banner">
	<ul class="banner_ul">
		<li class="current_banner"><a href="" style="background-image:url(images/banner/index_banner1.jpg)"></a></li>
		<li ><a href="javascript:;" style="background-image:url(images/banner/banner_weixin.jpg)"></a></li>
		<!--<li ><a href="" style="background-image:url(images/banner/banner3.jpg)"></a></li>
		<li ><a href="" style="background-image:url(images/banner/banner4.jpg)"></a></li>-->
	</ul>
	<div class="banner_circle_btn">
		<span class="current_circle_btn"></span>
		<span ></span>
		<!--<span ></span>
		<span ></span>-->
	</div>
	<span class="banner_btn_pren" onclick="banner_side_btn('pren')"></span>
	<span class="banner_btn_next" onclick="banner_side_btn('next')"></span>

</div>
<!-- index中间部分 -->
<div class="middle_section">
	<div class="inner_middle">
		<!-- 1 -->
		<div class="index_company Fleft width500 height280">
			<div class="bline1 title_word_all">
				<span class="title_word">公司简介</span><span class="title_word_late">COMPANY PROFILE</span>
			</div>
			<dl class="index_company_contain">
			<?php $page = get_page(3); ?>
				<dt class="positionR"><img src="images/company.jpg" alt="" width="261"><a href="<?php echo isset($page['url'])?$page['url']:''; ?>" class="positionA"></a></dt>
				<dd>
					<p class="positionR"><?php echo isset($page['description'])?$page['description']:''; ?>...<a href="<?php echo isset($page['url'])?$page['url']:''; ?>" class="more">[更多]</a></p>
				</dd>
			</dl>
		</div>
		<!-- 2 -->
		<div class="index_serve Fleft width430 height280">
			<div class="bline1 title_word_all">
				<span class="title_word">快捷服务</span><span class="title_word_late">QUICK SERVICE</span>
			</div>
			<div class="index_serve_contain">
				<a href="http://kh.sccsce.com/index.php/online/default/register?code=009000" class="servr_iocn1 curent_serve_contain_a">在线开户</a>
				<?php 
					$pageall1 = get_page('20,4'); 
					foreach($pageall1 as $k => $v){
						$flagp = $k+2;
				?>
				<a href="<?php echo $v['url']; ?>" class="servr_iocn<?php echo $flagp; ?>"><?php echo $v['title']; ?></a>
					<?php } ?>
				<?php 
					$cate23 = get_category('15,9'); 
					$softll[] = get_page('6');
					$cate23 = array_merge($softll,$cate23);					
					foreach($cate23 as $k => $v){
						$flagp = $k+4;
				?>
				<a href="<?php echo $v['url']=='soft'?'soft#hangqing':$v['url']; ?>" class="servr_iocn<?php echo $flagp; ?> <?php echo $flagp==4?'marginR0B10':''; ?>"><?php echo $v['title']; ?></a>
				<?php } ?>
				<?php 
					$pageall2 = get_page('5,24'); 
					foreach($pageall2 as $k => $v){
						$flagp = $k+7;
				?>
				<a href="<?php echo $v['url']; ?>" class="servr_iocn<?php echo $flagp; ?> <?php echo $flagp==8?'marginR0B10':''; ?>"><?php echo $v['title']; ?></a>
					<?php } ?>
			</div>
		</div>
		<!-- 3 -->
		<div class="index_static Fleft width500 height320">
			<div class="bline1 index_static_contain_btn positionR">
				<?php 
					$cates = get_category('1,25'); 
					
					foreach($cates as $k => $v){
						$curr = ($k == 0)?'title_word3':'';
				?>
				<span class="title_word2 <?php echo $curr; ?>"><?php echo $v['title'];?><a class="getmore" style="display:none;"><?php echo $v['url'];?></a></span>
				<?php } ?>
				<!--<span class="title_word2 title_word3">每日策略</span><span class="title_word2">行业新闻</span><span class="title_word2">媒体报道</span>--><a href="" class="more">更多&gt;&gt;</a>
			</div>
			<ul class="index_static_contain">
				<?php 
					$cates1 = get_category('1,25'); 
					
					foreach($cates1 as $k => $v){
						$curr = ($k == 0)?'static_li_appear':'';
				?>
				<li class="<?php echo $curr; ?>">
					<?php 
						$article = get_article_list($v['id'], 5, 0);
						//var_dump($article);
						foreach($article as $k1 => $v1){
							if($k1 == 0){
					?>
					<dl class="index_static_contain_title">
						<dt><img src="images/policy.jpg" alt="" width="162"></dt>
						<dd class="index_static_contain_title_dd">
							<a href="<?php echo $v1['url'] ?>" class="static_title_a1" title="<?php echo $v1['title'] ?>"><?php echo $v1['title'] ?></a>
							<p class="static_title_p2 positionR"><?php echo mb_substr($v1['intro'],0,40); ?>...<a href="<?php echo $v1['url'] ?>" class="more">[详情]</a></p>
							<p class="static_title_p2"><?php echo $v1['create_date'] ?></p>
						</dd>
					</dl>
							<?php }else{ ?>
					<p class="tatic_contain_program">
						<a href="<?php echo $v1['url'] ?>" title="<?php echo $v1['title'] ?>"><span>[<?php echo $v['title'] ?>]：</span><span class="width250"><?php echo $v1['title'] ?></span><em class="hot">HOT</em></a>
						<span><?php echo $v1['create_date'] ?></span>
				    </p>
						<?php }} ?>
				</li>
				<?php } ?>
			</ul>
		</div>
		<!-- 4 -->
		<div class="index_notice Fleft width430 height320">
			<div class="bline1 positionR title_word_all">
				<?php $cate4 = get_category('15'); ?>
				<span class="title_word"><?php echo $cate4['title']; ?></span><span class="title_word_late"><?php echo $cate4['ename']; ?></span><a href="<?php echo $cate4['url']; ?>" class="more">更多&gt;&gt;</a>
			</div>
			<div class="index_notice_program">
				<?php 
					$article4 = get_article_list(15, 5, 0);
					//var_dump($article);
					foreach($article4 as $k => $v){
				?>
				<div class="index_notice_program_contain">
					<span class="Fleft notice_day"><?php echo get_chinese_date($v['create_date']);?>前</span>
					<a href="<?php echo $v['url'] ?>" title="<?php echo $v['title']; ?>"  class="Fleft notice_p">[<?php echo $cate4['title']; ?>]：<?php echo $v['title']; ?></a>
					<span class="Fright notice_time"><?php echo $v['create_date'] ?></span>
				</div>
				<?php } ?>
				<i class="line_shu"></i>
			</div>
		</div>
	</div>
</div>
<!-- 尾部1 -->
<?php include_once('common/footer.php'); ?>
</body>
</html>
