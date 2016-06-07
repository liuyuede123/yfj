function get_param(url, name){
	var params=url.substring(1).toLowerCase();
	var paramList=[];
	var param=null;
	var parami;
	if(params.length>0) {
		if(params.indexOf("&") >=0) {
			paramList=params.split( "&" ); 
		}else {
			paramList[0] = params;
		}
		for(var i=0,listLength = paramList.length;i<listLength;i++) {
			parami = paramList[i].indexOf(name+"=" );
			if(parami>=0) {
				param =paramList[i].substr(parami+(name+"=").length);
				break;
			}
		}
	}
	return param;
}

function getDomainQuery(url) {
	var d = [];
	var st = url.indexOf('//', 1);
	var _domain = url.substring(st + 1, url.length);
	var et = _domain.indexOf('/', 1);
	d.push(_domain.substring(1, et));
	d.push(_domain.substring(et + 1, url.length));
	return d;
}

function set_cookie(c_name,value)
{
	document.cookie=c_name+ "=" +escape(value)+";";
}

function get_cookie(c_name)
{
	if (document.cookie.length>0)
	{
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{
			c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return "";
}

$(function (){
	var dq = getDomainQuery(document.referrer);
	var channel = dq[0];
	if(channel.indexOf('gdyy99.com') < 0 && channel != ''){
		set_cookie('channel', channel); /*来源渠道*/
		set_cookie('source_url', document.referrer); /*来源网址*/

		/*搜索关键词*/
		var eg = [];
		eg.push(['baidu', 'wd']);
		eg.push(['google', 'q']);
		eg.push(['soso', 'w']);
		eg.push(['bing', 'q']);
		eg.push(['yahoo', 'q']);
		eg.push(['sogou', 'query']);
		eg.push(['so.com', 'q']);
		var keyword = '';
		var str = null;
		for(var el in eg){
			var s = eg[el];
			var DandQ=String(s).split(",");
			if (dq[0].indexOf(DandQ[0])>0){
				str = get_param(dq[1], DandQ[1]);
				if(str != null){
					keyword = decodeURIComponent(str);
				}
				break;
			}
		}
		set_cookie('keyword', keyword); /*搜索关键词*/

		var referrer_url = document.referrer;
		var referrer = document.createElement("a");
		referrer.href = referrer_url;
		set_cookie( 'referrer_host', referrer.host); /*来源根域名*/
		set_cookie('landing_page', location.href.replace(location.search, '') ); /* 着陆页*/
	}

	$('form[data-role=phone_form]').each(function (){
		var __this = $(this);
		__this.find('button[name=send_captcha]').click(function (){
			var dom = $(this);
			dom.attr("disabled", "true");
			var phone = __this.find('input[name=phone]').val();
			if(phone == '' || isNaN(phone)){
				alert('请输入您的手机号码');
				dom.removeAttr("disabled");
			}else{
				$.post('/captcha/send_captcha',
				{phone:phone},
				function (d){
					d = $.parseJSON(d);
					if(d.status){
						alert('验证码已发送，请用手机查收');
					}else{
						alert(d.msg);
						$('button[name=send_captcha]').removeAttr("disabled");
					}
				})
			}
		});

		__this.find('button[name=submit]').click(function (){
			
			$(this).attr("disabled", "true");
			var post_data = new Object();
			var name = __this.find('input[name=name]').val();
			post_data.name = name == undefined ? '' : name;
			post_data.phone = __this.find('input[name=phone]').val();
			post_data.captcha = __this.find('input[name=captcha]').val();
			var remark = __this.find('input[name=remark]').val();
			post_data.remark = remark == undefined ? '' : remark;
			post_data.landing_page = get_cookie('landing_page');
			post_data.referrer_host = get_cookie('referrer_host');
			post_data.source_url = get_cookie('source_url');
			post_data.channel = get_cookie('channel');
			post_data.keyword = get_cookie('keyword');
			post_data.last_page = location.href.replace(location.search, '');
			var title = __this.find('input[name=title]').val();
			post_data.title = title == undefined ? '' : title;

			if(post_data.phone == '' || post_data.captcha == ''){
				alert('请输入您的手机号码或验证码');
			}else{
				$.post('/phone/add_phone',
				post_data,
				function (d){
					d = $.parseJSON(d);
					if(d.status){
						alert("您的申请已提交，稍后将会有工作人员与您联系");
					}else{
						alert(d.msg);
						console.log($(this));
						$('button[name=submit]').removeAttr("disabled");
					}
				})
			}
		})
	})

})