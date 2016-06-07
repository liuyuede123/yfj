<div class="about_left_contain">
				<!-- 月刊 -->
				<ul class="yuekan ">
					<?php 
							$flag = isset($_GET['f'])?$_GET['f']:'d';
							$articles = get_article_list($id, $limit = 8, $page, $flag);
							foreach($articles as $k => $v){
						?>
					<li class="yuekan_book <?php echo ($k+1)%4 == 0?'':'marginR27'; ?>">
					<div class="yuekan_book_img"><a href="<?php echo $v['url']; ?>">
					<?php if($flag == 'd'){ ?>
					<img src="images/rikan.jpg" alt="" width="168">
					<?php }else if($flag == 'w'){ ?>
					<img src="images/zhoukan/book1.jpg" alt="" width="168">
					<?php }else if($flag == 's'){ ?>
					<img src="images/yuekan/book1.jpg" alt="" width="168">
							<?php } ?>
						
						</a></div>
						<a href="" class="yuekan_book_name"><?php echo $v['title']; ?></a>
						<div class="yuekan_num">
							<span class="yuekan_numT"><?php echo $v['create_date']; ?></span>
							<span class="yuekan_numL"><?php echo $v['click']; ?></span>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
