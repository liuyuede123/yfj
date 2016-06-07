 <div class="company_notice">
				<!-- 重要公告 -->
				<div class="company_notice_section">
				<?php 
							$articles = get_article_list($id, 4, $page);
							foreach($articles as $v){
						?>
					<dl class="company_notice_contain">
						<dt><img src="<?php echo file_exists('upload/web_img/'.$v['img'])&&(!empty($v['img']))?'upload/web_img/'.$v['img']:'images/company_news/notice/notice_img.jpg'; ?>" alt="" width="236"></dt>
						<dd>
							<h4><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['title']; ?></a></h4>
							<p class="color999">来源：壹银添丰   发布时间：<?php echo $v['create_date']; ?></p>
							<p class="sumary">概要：<?php echo $v['intro']; ?>...</p>
							<div class="notice_more"><a href="<?php echo $v['url']; ?>" target="_blank">查看更多 <i></i></a></div>
						</dd>
					</dl>
					<?php } ?>
				</div>
				<div class="soft_loaddown_page">
					<?php include_once('common/paging.php'); ?>
				</div>
			</div>
