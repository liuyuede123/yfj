<div class="soft_loaddown">
				<!-- 活动专区 -->
				<ul class="soft_loaddown_ul marginR17">
				<?php 
							$articles = get_article_list($id, $limit = 6, $page);
							foreach($articles as $v){
						?>
					<li class="soft_loaddown_li">
						<div class="company_video_li_img h150" >
							<div class="company_video_img"><img src="<?php echo file_exists('upload/web_img/'.$v['img'])&&(!empty($v['img']))?'upload/web_img/'.$v['img']:'images/company_news/active/active_img1.jpg'; ?>" alt="" class="scale1" width="260" height="150"></div>
							<a href="<?php echo $v['url']; ?>" class="company_video_blank" target="_blank"></a>
							<img src="images/company_news/vedio/glass.png" alt="" width="34" class="company_video_glass">
						</div>
						<div class="company_event">
							<p class="soft_loaddown_li_title_event1">来源：壹银添丰&nbsp&nbsp发布时间：<?php echo $v['create_date']; ?></p>
							<p class="soft_loaddown_li_title_event2"> <?php echo $v['title']; ?></p>
						</div>
					</li>
					<?php } ?>

				</ul>
				<div class="soft_loaddown_page">
						<?php include_once('common/paging.php'); ?>
				</div>
			</div>
