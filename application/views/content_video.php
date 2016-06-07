<div class="active_page">
				<!-- 活动内页 -->
				<?php $art = get_article($id); ?>
				<div class="active_page_contain">
					<ul class="active_page_ul">
						<?php 
							$album = get_album_list($cateid);
							if(!empty($album)){
								foreach($album as $k => $v){
						?>
						<li class="<?php echo $k==0?'appear':''; ?>"><img src="upload/img/<?php echo $v['img']; ?>" alt="" width="737" height="487"></li>
								<?php }}else{ ?>
								<li class="appear"><img src="images/company_news/page/page_img1.jpg" alt="" width="737" height="487"></li>
						<li><img src="images/company_news/page/page_img2.jpg" alt="" width="737" height="487"></li>
						<li><img src="images/company_news/page/page_img3.jpg" alt="" width="737" height="487"></li>
							<?php } ?>
					</ul>
					<ol class="active_page_btns">
						<li class="active_pren_btn" onclick="banner_side_btn1('pren')"></li>
						<li class="active_next_btn" onclick="banner_side_btn1('next')"></li>
					</ol>
				</div>
				<div class="active_page_words">
					<h3><?php echo $art['title']; ?></h3>
					<?php echo $art['content']; ?>
				</div>
			</div>
