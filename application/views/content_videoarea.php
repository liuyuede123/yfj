 <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
 <div class="company_video">
				<!-- 视频专区 -->
				<ul class="company_video_ul">
				<?php 
							$articles = get_article_list($id, $limit = 6, $page);
							foreach($articles as $k => $v){
						?>
					<li class="company_video_li">
						<div class="company_video_li_img h142" >
							<div class="company_video_img"><img src="<?php echo file_exists('upload/web_img/'.$v['img'])&&(!empty($v['img']))?'upload/web_img/'.$v['img']:'images/company_news/vedio/video_img1.jpg'; ?>" alt="" class="scale1"></div>
							<a href="javascript:;" class="company_video_blank"></a>
							<img src="images/company_news/vedio/glass.png" alt="" width="34" class="company_video_glass">
						</div>
						<div class="company_video_li_word"><p>川商所运营中心：<?php echo $v['title']; ?>.....</p></div>
						<?php 
							$urlarr = explode('/',$v['url']);
							$artid = $urlarr[count($urlarr)-1];
							$arts = get_article($artid);
						?>
						<div class="artcontent" style="display:none;"><?php echo $arts['content']; ?></div>
					</li>
					
					<?php } ?>
					
				</ul>
				<div class="soft_loaddown_page">
						<?php include_once('common/paging.php'); ?>
				</div>
				<div class="fangda_video">
					<p class="fangda_video_word"><span class="colorB">视频介绍：</span><span>壹银财富旗下有升昱投资、华瀚企业咨询、广东壹银贵金属、四川壹银添丰有色金属等多家下属单位。壹银贵金属是广东省贵金属交易中心第099号会员、2014贵金属行业发展新锐，是立志打造国内较有影响力的贵金属投资服务平台。针对不同投资人群，公司推出A+B理财计划，在股市、贵金属等多领域均取得骄人战绩</span></p>
					<div class="fangda_video_deatil">
						<!--<iframe src="company_vedioes.html" frameborder="0" cellpadding="100" cellspacing="100"></iframe>-->
						
					</div>
					<div class="video_goback">返 回</div>
				</div>
			</div>


