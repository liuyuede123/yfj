<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	 <meta name="renderer" content="webkit">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	 <base target="_self" href="<?php echo base_url(); ?>">
	<link rel="stylesheet" href="skin/code/index.css">
	<script type="text/javascript" src="skin/code/jquery-1.11.2.min.js"></script>
    <!--日期选择所依赖的css库-->
   <script type="text/javascript" src="skin/code/util.js"></script>

	<link rel="stylesheet" type="text/css" href="skin/code/style.css">
</head>
<body>
<div class="bd">
	<div class="bdUp">
		<div class="bdUpInputOK">
			<!--<img src="images/ok.png" alt="" class="okImg">-->
			<div class="bdUpInputOKWord">
				<p class="fontB lineb">请保持手机畅通,我们将安排投资顾问给您回电！</p>
				<span class="bdUpInputOKBtn">再测一次</span>
			</div>

		</div>
		<div class="bdUpInput">
			<div class="inputNumWord">
				<span>个股孰优孰劣？</span>
				<span class="fontB">随问随答！</span>
			</div>
			<div class="inputNum top_search relative" style="z-index:2;"><!-- top_search  -->
				<span class="inputword1">股票代码</span>
				<input type="text" name="name" id="theSearchInput" value="请输入股票代码" onFocus="if(this.value=='请输入股票代码'){this.value=''}" onBlur="if(this.value==''){this.value='请输入股票代码'}" class="inputword1">
				<span class="input_state" ></span>
				<div class="search_tips"><ul></ul></div> <!--  new add  -->
				<div style="clear:both;"></div>
			</div>
			<!-- <div class="inputNum relative" style="overflow: hidden;">
				<span class="inputword1">电话号码</span>
				<input type="text" name="phone" id="" value="请输入电话号码" onFocus="if(this.value=='请输入电话号码'){this.value=''}" onBlur="if(this.value==''){this.value='请输入电话号码'}" class="inputword1">
				<span class="input_state"></span>
			</div> -->
			<input type="hidden" name="title" value="股票代码">
		</div>
		<!-- new add start -->
		<div class="clearfix" id="panel">
			<div class="nav_sub" id="nav_sub"></div>
			<div class="sidebar" id="sidebar"></div>
			<div class="nav_tab" id="nav_tab"></div>
			<div class="gridster" id="data_panel"></div>
		</div>
		<!-- new add end-->
		<div class="bdUpRusult">
			<div class="bdUpRbg1">
				<div class="bdUpRbg2">
					<span>当前诊断股票:</span>
					<div class="outerBdUpRusultUl">
						<ul class="bdUpRusultUl">
							<li>
							
							</li>
						</ul>
					</div>
					
				</div>
			</div>
			<ul class="bdUpRusultNum">
				<li><span>已有</span><span class="colorR checked_peo">&nbsp;人&nbsp</span><span>诊断</span></li>
				<li><span>已诊断</span><span class="colorR checked_stock">&nbsp;只&nbsp</span><span>股票</span></li>
			</ul>
		</div>
		<div class="bdUpBtn" id="bdUpBtnid">
			<span class="bdUpBtn1"></span>
			<span class="bdUpBtn2"></span>
			<span class="bdUpBtn3"></span>
			<a href="javascript:;" class="bdUpBtn_a"></a>
		</div>
	</div>
	<div class="bdDown">
		<div class="bdDown1">
			<span class="bdDownIMG"></span>
		</div>
		<div class="bdDownIMGleft">
			<div class="bdDownIMGright">
				<p>白银投资，T+0操作，双向收益，收益机会翻倍！</p>
			</div>
		</div>
		<div class="bdDownA">
			<a href="javascript:;">返回直播室</a>
		</div>
		<div class="bdDownLast">入市有风险，投资需谨慎</div>
	</div>
	<span class="line line1"></span>
	<span class="line line2"></span>
</div>
 <!-- footer -->
<iframe id="analysisFrame" src="skin/code/analysis.html" style="display:none;"></iframe>
<!-- 右侧浮动栏 begin -->

<script type="text/javascript" src="skin/code/suggestServer.js"></script>

<div id="nimei" style="display:none;"></div>
<iframe id="myfarme" src="#" style="display:none;"></iframe>
<script>
	$(function(){
		// 数据滚动定时器
		var bdUpRusultLiFirst = $('.bdUpRusultUl>li').first();
		$(bdUpRusultLiFirst).clone().appendTo($('.bdUpRusultUl'));
		
		var timer = null;
		timer = setInterval(runUp,300)
		
		var num = 0;
		var bdUpRusultLiLength = $('.bdUpRusultUl>li').length;
		var bdUpRusultLiHeight = $('.bdUpRusultUl>li').height();
		var runLength = (bdUpRusultLiLength-1) * bdUpRusultLiHeight ;
		function runUp(){
			num += 2;
			if(num > runLength){ num = 0};
			$('.bdUpRusultUl').css('top',-num);
		}
		$('.bdUpRusultUl').hover(function(){
				clearInterval(timer);
			},function(){
				clearInterval(timer);
				timer = setInterval(runUp,300);
		});

		// 返回直播室关闭窗口按钮
		$('.bdDownA>a').click(function(){
			//location.reload();
			//这里是核心
			var parent_domain = get_parent_domain();/////////
document.getElementById('myfarme').src="http://"+parent_domain+"/iframe.html?nishi=shabi"; 
			//parent.document.getElementById('dialog').style.display='none';
			//parent.document.getElementById('mask').style.display='none';
		})

		$('.bdUpInputOKBtn').click(function(){
			$('.bdUpInputOK').hide();
			//console.log(_isSubmit);///////////
			if(_isSubmit != "showphone"){
				$('input[name=phone]').val("请输入电话号码");
			}
			$('input[name=name]').val("请输入股票代码");
			$('.inputNum').show();
			$('.inputNumWord').show();
		})
		
		// 输入闪烁转台3.22
		var timerDong = null;
		timerDong = setInterval(input_dong,800);
		$('.inputNum>input').focus(function(){
			$(this).siblings('.input_state').hide();
		})
		$('.inputNum>input').blur(function(){
			var input_val = $(this).val();
			if(input_val == '请输入股票代码' || input_val == '请输入电话号码'){
				$(this).siblings('.input_state').show();
			}

		})
	// 输入闪烁转台3.22
		var timerDong = null;
		timerDong = setInterval(input_dong,800);
		$('.inputNum>input').focus(function(){
			$(this).siblings('.input_state').hide();
		})
		$('.inputNum>input').blur(function(){
			var input_val = $(this).val();
			if(input_val == '请输入股票代码' || input_val == '请输入电话号码'){
				$(this).siblings('.input_state').show();
			}
		})
	})
	// 输入闪烁转台3.22
	function input_dong(){
		$('.input_state').animate({'opacity':'0'},400).animate({'opacity':'1'},400);
	}
	
	// 输入闪烁转台3.22
	function input_dong(){
		$('.input_state').animate({'opacity':'0'},400).animate({'opacity':'1'},400);
	}
	
	function get_parent_domain(){
		var url = "";
        try {
            url = window.top.document.referrer
        } catch(M) {
            if (window.parent) {
                try {
                    url = window.parent.document.referrer
                } catch(L) {
                    url = ""
                }
            }
        }
        if (url === "") {
            url = document.referrer
        }
        var regex = /.*\:\/\/([^\/]*).*/;
        var match = url.match(regex);
        if(typeof match != "undefined" && null != match) host = match[1];
        return host;
	}
	
	function GetRequest() {
	   var url = location.search; //获取url中"?"符后的字串
	   var theRequest = new Object();
	   if (url.indexOf("?") != -1) {
	      var str = url.substr(1);
	      strs = str.split("&");
	      for(var i = 0; i < strs.length; i ++) {
	         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
	      }
	   }
	   return theRequest;
	}
	
	/*function checkMobile(phone){ 
    var sMobile = phone; 
    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(sMobile))){ 
        alert("请输入有效的手机号"); 
        return false; 
    } 
} */
	
</script>
</body>
</html>


