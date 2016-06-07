<div class="soft_loaddown">
				<!-- 资料下载 -->
				<ul class="soft_loaddown_ul">
				<?php 
							$articles = get_article_list($id, $limit = 6, $page);
							foreach($articles as $v){
						?>
					<li class="soft_loaddown_li">
						<div class="soft_loaddown_li_img"><a href="<?php echo $v['url']; ?>" target="_blank"><img src="images/soft/ziliao.jpg" alt="" width="260"></a><i></i><img src="images/soft/hover_jia.png" alt="" width="50"></div>
						<div class="soft_loaddown_li_title">
							<p class="soft_loaddown_li_theme"><?php echo $v['title']; ?>.....</p>
							<p class="soft_loaddown_li_time"><?php echo $v['create_date']; ?></p>
						</div>
					</li>
						<?php } ?>
				</ul>
				<div class="soft_loaddown_page">
					<?php include_once('common/paging.php'); ?>
				</div>
			</div>
