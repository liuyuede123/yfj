$(function(){
	//index nav下拉效果
	$('.navlist_ul>li').hover(function(){
		$(this).children('.nav_ul').stop().slideDown();
	},function(){
		$(this).children('.nav_ul').stop().slideUp();
	})

	//index nav点击效果
	$('.navlist_a').click(function(){
		$('.navlist_a').removeClass('present_nav');
		$(this).addClass('present_nav');

	})
	//banner效果
	$('.banner_circle_btn>span').click(function(){
		var this_index = $(this).index();
		$(this).addClass('current_circle_btn').siblings().removeClass('current_circle_btn');
		$('.banner_ul>li:eq('+this_index+')').addClass('current_banner').siblings().removeClass('current_banner');
		num1 = this_index;
	});
	
	var banner_time = null;
	banner_time = setInterval(banner_slide,3000);
	function banner_slide(){
		var bannerl_li_length = $('.banner_ul>li').length;
		num1++;
		if(num1 > bannerl_li_length -1 ){num1 = 0}
		$('.banner_ul>li:eq('+num1+')').addClass('current_banner').siblings().removeClass('current_banner');
		$('.banner_circle_btn>span:eq('+num1+')').addClass('current_circle_btn').siblings().removeClass('current_circle_btn');
	}
	$('.banner').hover(function(){
		clearInterval(banner_time);
	},function(){
		clearInterval(banner_time);
		banner_time = setInterval(banner_slide,3000);
	})

	resize();

	// index 快捷服务切换效果
	$('.index_serve_contain>a').mouseover(function(){
		$(this).addClass('curent_serve_contain_a').siblings().removeClass('curent_serve_contain_a');
	})

	// index 每日策略切换效果
	var getmore = $('.title_word3 .getmore').text();
	$('.index_static_contain_btn .more').attr('href',getmore);
	$('.index_static_contain_btn>span').mouseover(function(){
		var this_index = $(this).index();
		$(this).addClass('title_word3').siblings().removeClass('title_word3');
		$('.index_static_contain>li:eq('+this_index+')').addClass('static_li_appear').siblings().removeClass('static_li_appear');
		var getmore = $('.title_word3 .getmore').text();
		$('.index_static_contain_btn .more').attr('href',getmore);
	})

	// 月刊
	$('.yuekan_book').mouseover(function(){
		$(this).siblings().css({'opacity':'0.8','filter':'alpha(opacity=80)'});
		$(this).css({'opacity':'1.0','filter':'alpha(opacity=100)'});
	})

	//中心资质点击放大效果图片
	$('.centerQU_img').click(function(){
		$('.centerQU_show_big_img').show();
		$('.centerQU_img').hide();
	})
	$('.centerQU_img').hover(function(){
		$(this).children('.centerQU_bg_blue').show();
		$(this).children('.centerQU_bg_glass').show();
	},function(){
		$(this).children('.centerQU_bg_blue').hide();
		$(this).children('.centerQU_bg_glass').hide();
	})

	//公司简介
	$('.company_brief_team_btns>li').mouseover(function(){
		var this_index = $(this).index();
		var left_num = 100+285*this_index;
		$('.company_brief_team_contain>li:eq('+this_index+')').addClass('current_teacher_word').siblings().removeClass('current_teacher_word');
		$('.company_brief_team_contain>li').children('i').removeClass('current_teacher_word_i');
		$('.company_brief_team_contain>li:eq('+this_index+')').children('i').addClass('current_teacher_word_i').css('left',left_num);

	})

	//战略伙伴效果
	$('.parter_fan').mouseenter(function(){
		var this_height = $(this).height();
		var this_move = this_height/2;
		$(this).children('.fan_children_stand').stop().animate({'top':this_move,'height':0,'opacity':'0'},300);
		$(this).children('.fan_children_move').stop().animate({'height':this_height,'top':0,'opacity':'1'},300);
	})
	$('.parter_fan').mouseleave(function(){
		var this_height = $(this).height();
		var this_move = this_height/2;
		$(this).children('.fan_children_stand').stop().animate({'height':this_height,'top':0,'opacity':'1'},300);
		$(this).children('.fan_children_move').stop().animate({'top':this_move,'height':0,'opacity':'0'},300);
	})	

	$('.parter_fan2').hover(function(){
		$(this).children('.parter_fan2_move').stop().animate({'top':-30},400);
		$(this).children('.parter_fan2_move').children('.parter_fan2_move_word').hide().delay(300).fadeIn(500)
	},function(){
		$(this).children('.parter_fan2_move').stop().animate({'top':0},400);
	})

	// 办公环境
	$('.environment_btn>li').mouseover(function(){
		var this_index = $(this).index();
		$(this).addClass('current_btn').siblings().removeClass('current_btn');
		$('.environment_contain_imgs>li:eq('+this_index+')').addClass('current_environment').siblings().removeClass('current_environment');
	})

	var num4 = 0	
	$('.environment_pren').click(function(){
		num4 --;
		var block_length =$('.current_environment>img').length;
		if(num4 < 0){num4 = block_length -1;}
		$('.current_environment>img').removeClass('show_img');
		$('.current_environment>img:eq('+num4+')').addClass('show_img');
	})
	$('.environment_next').click(function(event){
		event.stopPropagation();
		num4 ++;
		var block_length =$('.current_environment>img').length;
		if(num4 > block_length -1){num4 = 0;}
		$('.current_environment>img').removeClass('show_img');
		$('.current_environment>img:eq('+num4+')').addClass('show_img');
	})

	// 招贤纳士
	$('.company_personnel_btn>li').mouseover(function(){
		var this_index = $(this).index();
		$(this).addClass('company_personnel_btn_curent').siblings().removeClass('company_personnel_btn_curent');
		$('.company_personnel_contain>li:eq('+this_index+')').css('display','block').siblings().css('display','none');
	})

	


	//视频专区 
	$('.company_video_li_img').hover(function(){
		$(this).children('.company_video_img').children('img').addClass('scale103');
		$(this).children('.company_video_glass').addClass('show_glass');
		$(this).children('.company_video_blank').addClass('show_blank');
	},function(){
		$(this).children('.company_video_img').children('img').removeClass('scale103');
		$(this).children('.company_video_glass').removeClass('show_glass');
		$(this).children('.company_video_blank').removeClass('show_blank');
	})
	// 视频专区 放大效果
	$('.company_video_li_img').click(function(){
		$('.fangda_video_deatil').html($(this).parent().children('.artcontent').html());
		$('.company_video_ul').hide();
		$('.soft_loaddown_page').css('display', 'none');
		$('.fangda_video').show();
	})
	$('.video_goback').click(function(){
		$('.fangda_video_deatil').html($('.company_video_li_img').parent().children('.artcontent').html());
		$('.soft_loaddown_page').css('display', 'block');
		$('.company_video_ul').show();
		$('.fangda_video').hide();
	})

	//公司动态内页
	$('.active_page_contain').hover(function(){
		$(this).find('.active_page_btns>li').show();
		$(this).find('.active_pren_btn').stop().animate({'left':'30px'},1000);
		$(this).find('.active_next_btn').stop().animate({'right':'30px'},1000);
	},function(){
		$(this).find('.active_page_btns>li').hide();
		$(this).find('.active_pren_btn').stop().animate({'left':'0px'},1000);
		$(this).find('.active_next_btn').stop().animate({'right':'0px'},1000);
	})

	//产品介绍
	$('.products_detail').hover(function(){
		$(this).children('.products_mask').show();
		$(this).children('.products_word').stop().slideDown(500);
	},function(){
		$(this).children('.products_mask').hide();
		$(this).children('.products_word').stop().slideUp(500);
	})

	//产品合约
	$('.product_agreenment_btn>li').mouseover(function(){
		var index = $(this).index();
		$(this).addClass('current_btn').siblings().removeClass('current_btn');
		$('.product_agreenment_tables>li:eq('+index+')').addClass('show').siblings().removeClass('show');
	})

	//人工开户
	/* $('.account_self_section1_form button').focus(function(){
		$(this).css('outline','none');
	}) */



})
	function img_mouseover(index){
		var _src = "images/foot_logo"+index+index+".jpg";
		 $('.last_dt_img'+index+'').attr('src',_src);		

	}
	function img_mouseout(index){
		var _src = "images/foot_logo"+index+".jpg";
		$('.last_dt_img'+index+'').attr('src',_src);
	}

//banner效果
var num1 = 0;
function banner_side_btn(btn_name){
	var bannerl_li_length = $('.banner_ul>li').length;
	if(btn_name == 'pren'){num1--};
	if(btn_name == 'next'){num1++};
	if(num1 > bannerl_li_length -1 ){num1 = 0}
	if(num1 < 0){num1 = bannerl_li_length - 1}
	$('.banner_ul>li:eq('+num1+')').addClass('current_banner').siblings().removeClass('current_banner');
	$('.banner_circle_btn>span:eq('+num1+')').addClass('current_circle_btn').siblings().removeClass('current_circle_btn');
}
//招贤纳士 人才招聘
function next(){ 
	var arr = $('.personnel_jobs>div'); 
	for (i = 0; i < arr.length-1; i++) { 
	if ((arr[i].style.display == "block"||arr[i].style.display == "") && i <= arr.length) { 
		arr[i + 1].style.display = "block"; 
		arr[i].style.display = "none"; 
		break; 
		} 
	} 
}

//公司动态内页
var num2 = 0;
function banner_side_btn1(btn_name){
	var ele_length = $('.active_page_ul>li').length;
	if(btn_name == 'pren'){num2--};
	if(btn_name == 'next'){num2++};
	if(num2 > ele_length -1 ){num2 = 0}
	if(num2 < 0){num2 = ele_length - 1}
	$('.active_page_ul>li:eq('+num2+')').addClass('appear').siblings().removeClass('appear');
}

// banner crow位置
function resize(){
	var wid_width = document.body.clientWidth;
	if(wid_width == 1000 || wid_width < 1000 ){
		$('.banner_btn_pren').css('left',0);
		$('.banner_btn_next').css('right',0);
	}
	if(wid_width > 1000 ){
		$('.banner_btn_pren').css('left',100);
		$('.banner_btn_next').css('right',100);
	}
}
$(window).resize(function(){resize();})