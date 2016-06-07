
				<!-- 活动内页 -->
				<?php $art = get_article($id); ?>
				<?php 
					if($cateid==5){
						$album = get_art_album_list($id);
						?>
			<div class="active_page">
							<?php if(!empty($album)){?>
				<div class="active_page_contain">
					<ul class="active_page_ul">
					
						<?php 
							
								foreach($album as $k => $v){
						?>
						<li class="<?php echo $k==0?'appear':''; ?>"><img src="upload/img/<?php echo $v['img']; ?>" alt="" width="737" height="487"></li>
								<?php } ?>
								
					</ul>
					<ol class="active_page_btns">
						<li class="active_pren_btn" onclick="banner_side_btn1('pren')"></li>
						<li class="active_next_btn" onclick="banner_side_btn1('next')"></li>
					</ol>
				</div>
				<?php }else{ ?>
								
							<?php } ?>
				<div class="active_page_words">
					<h3><?php echo $art['title']; ?></h3>
					<?php echo $art['content']; ?>
				</div>
				</div>
				<?php }else{ ?>
					<div class="program_inner_page">
				<!-- 文章内页 -->
				<h3 class="program_page_title"><?php echo $art['title']; ?></h3>
				<p class="program_page_time">来源：壹银添丰 &nbsp&nbsp&nbsp&nbsp发布时间：<?php echo $art['create_date']; ?></p>
				<div class="program_page_word">
					<?php echo $art['content']; ?>
				</div>
			</div>

				<?php } ?>
			
