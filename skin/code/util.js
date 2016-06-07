var getData = {};	//存储回调函数
var CRON = {};	//定义定时器
var data = {};	//存储获取的数据
var cate = [],
	_cate = [],
	cateName = [],
	navId = [];
var gridster;	//gridster拖拽排序对象变量
var usertype;	//定义用户状态
var blockcount = 0;
var userTabs = [];
var userTab = 0;
//var userInfo = sinaSSOController.getSinaCookie();
var unfold = 1;	//侧边栏打开折叠状态
var dataPanelWidth;	//右侧数据显示宽度
var gridMarginX = 10;	//首页模块的左右边距
var gridMarginY = 15;	//首页模块的上下边距
var gridUnitX = 370;	//首页模块的初始单位宽度
var gridUnitY = 30;	//首页模块的初始单位高度
var windowWidth = $(window).width()-20;
var _grids = parseInt(windowWidth/(gridUnitX+gridMarginX*2));	//页面宽度允许的模块数量
gridUnitX = windowWidth/_grids-gridMarginX*2;	//调整后模块宽度
function hideSidebar(){}
function openSidebar(){}
function onResize(){}
//新浪行业板块id
var plateId="";
//url中hash的判断
//请求数据接口
function dataLoader(url) {
	var r = Math.random().toString().replace("0.","");
	var div = document.getElementById("get_data_div");
	if(!div){
		div = document.createElement('div');
		div.id = "get_data_div";
		document.body.insertBefore(div, document.body.childNodes[0]);
	}
	script = document.createElement('script');
	script.id = "getDataScript"+r;
	script.setAttribute('src', url);
	script.setAttribute('class', "get_data_script");
	script.setAttribute('charset', 'gbk');
	div.appendChild(script);
	var broswerSupport = 1;
	if((navigator.appName == "Microsoft Internet Explorer")&&((navigator.userAgent.indexOf("MSIE 6.0")>0)||(navigator.userAgent.indexOf("MSIE 7.0")>0)||(navigator.userAgent.indexOf("MSIE 8.0")>0))){
		broswerSupport = 0;
	}else if(navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") < 1){
		broswerSupport = 0;
	}else{
		broswerSupport = 1;
		//$("#getDataScript"+r).remove();
	}
}

$(document).ready(function(){
	//用户输入时绑定事件
    (new SuggestServer()).bind({
        "input": "theSearchInput",
        "value": "@3@", //传到input框中的结果，2股票代码
        "type": "11,12,13,14,15,21,22,23,24,25,26,31,32,33,41,42,81,82",
        "width": 260,
        "target":"_self",
        "link": "javascript:;"
        /* "link": "http://biz.finance.sina.com.cn/suggest/lookup_n.php?q=@code@" */
    });
	
	//get zhenduan people
	/* function get_stock_peo(){
		var checked_peo = 0,checked_stock = 0;//诊断人数checked_peo 和 已诊断股票checked_stock
		var start_num = 100;
		var hourflag = 0;//小时的偏移量
		var allminutes = 0;//总的分钟数
		var myDate = new Date();
		var curhour = myDate.getHours();//获取当前小时数(0-23)
		var curminutes = myDate.getMinutes();//获取当前分钟数(0-59)
		if(curhour >= 9 || curhour < 2){
			//如果在这个时间段就获取 诊断人数checked_peo 和 已诊断股票checked_stock
			//获取从9点开始的分钟数
			//获取小时的偏移量
			if(curhour == 0 || curhour == 1){
				curhour += 24;
			}
			hourflag = curhour - 9;//小时的偏移量,在0-16之间
			allminutes = hourflag*60 + curminutes;//总的分钟数
			checked_peo = parseInt(allminutes*20 + Math.random()*100);
			checked_stock = parseInt(allminutes*40 + Math.random()*100);
		}
		$(".checked_peo").html("&nbsp"+checked_peo+"人&nbsp");
		$(".checked_stock").html("&nbsp"+checked_stock+"只&nbsp");
		//console.log(checked_peo);
		//console.log(checked_stock);
		var start=setTimeout(get_stock_peo,1000*60);
	} */
	//get zhenduan people
	function get_stock_peo(){
		$.post(
			"code/get_stock_peo",
			{flag:1},
			function(res){
				res = $.parseJSON(res);
				//console.log(res.checked_peo);
				//console.log(res.checked_stock);
				$(".checked_peo").html("&nbsp"+res.checked_peo+"人&nbsp");
				$(".checked_stock").html("&nbsp"+res.checked_stock+"只&nbsp");
			}
		);
		
		//console.log(checked_peo);
		//console.log(checked_stock);
		var start=setTimeout(get_stock_peo,1000*60);
	}
	get_stock_peo();
	//var start=setTimeout(get_stock_peo,1000);
	
});

