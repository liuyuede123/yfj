 <!-- 月刊 -->
 <div class="about_left_contain" >

				<div class="trade_news_contain" >
					 <div class="trade_news_contain_pages">
					 	<ul class="trade_news_contain_pages_section">
						<?php 
							$articles = get_article_list($id, 4, $page);
							foreach($articles as $v){
						?>
							<li class="plan_li_bg" style="background-image:url(<?php echo file_exists('upload/web_img/'.$v['img'])&&(!empty($v['img']))?'upload/web_img/'.$v['img']:'images/daily_plan/datail_plan_bg1.jpg'; ?>)">
					 			<dl class="plan_li_dl">
					 				<dt><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['title']; ?></a></dt>
					 				<dd class="plan_li_dd_source">来源：壹银添丰&nbsp&nbsp&nbsp&nbsp发布时间：<?php echo $v['create_date']; ?></dd>
					 				<dd class="plan_li_dd_brief"><span class="colorRed">概要</span>：<?php echo $v['intro']; ?><a href="<?php echo $v['url']; ?>" class="goon_a" target="_blank">[继续阅读]</a></dd>
					 			</dl>
					 		</li>
							<?php } ?>
					 	</ul>
					 </div>
					 <div class="soft_loaddown_page">
					 	 <!--<ul class="news_page_change_ul">
					 	 	<li><a href="">首页</a></li>
					 	 	<li><a href="">上一页</a></li>
					 	 	<li><a href="">2</a></li>
					 	 	<li><a href="">3</a></li>
					 	 	<li><a href="">下一页</a></li>
					 	 	<li><a href="">尾页</a></li>
					 	 </ul>-->
						 <?php include_once('common/paging.php'); ?>
					 </div>
				</div>
</div>
