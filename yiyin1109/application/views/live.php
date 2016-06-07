<style>
body{overflow-x: hidden;}
ul{list-style: none; margin: 0; padding: 0;}
#common .panel-default, #private .panel-default{border-top: none;}
#live, #private_live{height: 430px; overflow-y: auto; border: 1px solid #ccc;}
.msg-title, .msg-body{padding: 5px;}
.live-category-1{background-color: #449d44;}
.live-category-2{background-color: #f0ad4e;}
.live-category-3{background-color: #c9302c;}

.online{position: fixed; right: -170px; width: 200px; height: 90%; top: 51px; border: 1px solid #ccc; z-index: 99999; }
.control{width: 30px; background-color: #e7e7e7; height: 100%; line-height: 100%; cursor: pointer; text-align: center;}
.control .text{width: 20px; font-size: 20px; font-weight: bold; margin: 0 auto; line-height: 32px; color: #428bca;}
.member_list{width: 168px; background-color: #fff; height: 100%; overflow-y: auto;}
.member_list li{line-height: 32px; text-align: center; background-color: #f8f8f8; border-bottom: 1px solid #e7e7e7;}
.member_list li:hover{background-color: #eee;}
.member_list li a{display: block;}

#private_live{padding: 10px;}
#private_live li{width: 80%;}
#private_live .title{color: #777;}
#private_live .text{background-color: #e8e8e8; padding: 5px;}
#private_live .pull-right p.text{float: right;}
#private_live .pull-left p.text{float: left; background-color: #acd9f8;}
#private_live .pull-right{text-align: right;}
#private_live li{margin-bottom: 10px;}
</style>
<div class="row">
	<div class="col-lg-12">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#common" class="common" role="tab" data-toggle="tab">公共发信区</a></li>
			<li role="presentation"><a href="#private" class="private" role="tab" data-toggle="tab">私聊区</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="common">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="live">
							<div class="list"></div>
						</div>
						<form class="form-horizontal common_form" role="form">
							<script id="container" name="content" type="text/plain"></script>
							<div class="form-group">
								<div class="col-sm-12">
									<button type="button" class="btn btn-primary" onclick="send_msg()">发送</button>
									<?php foreach($live_category as $v): ?>
									<label class="checkbox-inline">
										<input type="checkbox" name="lid[]" value="<?php echo $v['id']; ?>"> <?php echo $v['name']; ?>
									</label>
									<?php endforeach; ?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="private">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="private_live">
							<ul class="list clearfix"></ul>
						</div>
						<form class="form-horizontal private_form" role="form">
							<textarea name="content" id="private_content" rows="5" style="width:100%;"></textarea>
							<div class="form-group">
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-primary" type="button" onclick="send_private_msg()">发送给</button>
										</span>
										<span class="input-group-addon form-control target_nick"></span>
									</div>
									<input type="hidden" name="mid" class="send_to">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="online clearfix">
	<div class="control pull-left" onclick="switch_member_list()"><div class="text">在线列表&lt;&lt;</div></div>
	<div class="member_list pull-left">
		<ul></ul>
	</div>
</div>

<!-- 配置文件 -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/ueditor.all.js"></script>
<!-- 语言包文件(建议手动加载语言包，避免在ie下，因为加载语言失败导致编辑器加载失败) -->
<script type="text/javascript" src="<?php echo $site_url; ?>plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
var editor = UE.getEditor('container', {
	imageUrl : admin.url+"live/upload_img",
	imagePath : "<?php echo $site_url; ?>",
	savePath : ['live_data/images'],
	compressSide : 1,
	maxImageSideLength : 1440,
	elementPathEnabled : false,
	wordCount : false,
	toolbars : [['fullscreen', 'source', '|', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'fontborder', 'forecolor', 'backcolor', 'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|' ,  'link', 'unlink', '|' ,  'insertimage', 'emotion']],
	'initialFrameHeight' : 100
});

$(function (){
	get_all_msg();
})

function get_all_msg(){
	var time = arguments[0] ? arguments[0] : 0;

	$.ajax({
		type : 'POST',
		cache : false,
		timeout : 20000,
		url : admin.url+'live/get_all_msg',
		data : {time : time},
		success : function (result){
			result = $.parseJSON(result);
			if(result.live_data.length > 0 || result.live_del_data.length > 0){
				deal_common_msg(result.live_data, result.live_del_data);
			}
			if(result.member_data.length > 0){
				deal_memeber_data(result.member_data);
			}
			if(result.private_data.length > 0){
				deal_private_data(result.private_data);
			}
			get_all_msg(result.time);
		},
		error : function (XMLHttpRequest, textStatus){
			if(textStatus == 'timeout') get_all_msg(time);
		}
	})
}

function deal_common_msg(data, del_data){
	var dom = $('#live');
	var list_dom = dom.find('.list');
	var h = '';
	$.each(data, function (i, msg){
		h += '<div class="panel panel-info" id="'+msg.id+'"><div class="panel-heading msg-title">'+msg.name+' '+msg.time+' ';
		$.each(msg.live, function (j, live){
			h += '<span class="label label-success live-category-'+live['lid']+'">'+live['name']+'</span> ';
		})
		h += '<div class="pull-right"><button class="btn btn-danger" onclick="del('+msg.id+')">删除</button> <button class="btn btn-success top" onclick="';
		if(msg.is_top == 1){
			h += 'cancel_top('+msg.id+')">取消置顶';
		}else{
			h += 'set_top('+msg.id+')">置顶';
		}
		h += '</button></div></div><div class="panel-body msg-body">'+msg.content+'</div></div>';
	})
	list_dom.append(h);
	dom.scrollTop( list_dom.outerHeight(true) );

	$.each(del_data, function (i, del_id){
		$('#'+del_id).remove();
	})
}

function deal_memeber_data(data){
	var dom = $('.member_list ul');
	$.each(data, function (i, v){
		var cur_dom = dom.find('#member_'+v.mid);
		if(v.in_room == 1 && cur_dom.length == 0){
			dom.append('<li id="member_'+v.mid+'"><a href="javascript:" onclick="reply_private_msg('+v.mid+',\''+v.nick+'\')">'+v.nick+'</a></li>');
		}else if(v.in_room == 0){
			cur_dom.remove();
		}
	})
}

function deal_private_data(data){
	if($('#private').hasClass('active') != true){
		$('.private').html('您有新的消息');
	}

	var dom = $('#private_live');
	var list_dom = dom.find('.list');
	var h = '';
	$.each(data, function (i, msg){
		if(msg.is_admin == 0){
			h += '<li class="pull-left"><p class="title">'+msg.nick+' '+msg.time+' <button class="btn btn-primary btn-xs" onclick="reply_private_msg('+msg.mid+',\''+msg.nick+'\')">回复</button></p><p class="text">'+msg.content+'</p></li>';
		}else{
			h += '<li class="pull-right"><p class="title">向'+msg.nick+'回复 '+msg.time+'</p><p class="text">'+msg.content+'</p></li>';
		}
	})
	list_dom.append(h);
	dom.scrollTop( list_dom.outerHeight(true) );
}

$('.private').on('shown.bs.tab', function (){
	$('.private').html('私聊区');
	var dom = $('#private_live');
	var list_dom = dom.find('.list');
	dom.scrollTop( list_dom.outerHeight(true) );
})

function send_msg(){
	if( $('input[name^=lid]:checked').length == 0){
		alert('请选择直播室');
	}else if(editor.getContent() == ''){
		alert('请输入要发送的内容');
	}else{		
		$.post(admin.url+'live/send_msg',
		$('.common_form').serialize(),
		function (){
			editor.execCommand('cleardoc');
		})
	}
}

function set_top(id){
	$.post(admin.url+'live/set_top',
	{id: id},
	function (){
		$('#'+id+' .top').attr('onclick', "cancel_top('"+id+"')").html('取消置顶');
	})
}

function cancel_top(id){
	$.post(admin.url+'live/cancel_top',
	{id: id},
	function (){
		$('#'+id+' .top').attr('onclick', "set_top('"+id+"')").html('置顶');
	})
}

function del(id){
	if(confirm('确认删除该信息')){
		$.post(admin.url+'live/del_msg',
		{id: id},
		function (){
			$('#'+id).remove();
		})
	}
}

function switch_member_list(){
	var right = $('.online').css('right');
	if(right == '-170px'){
		$('.online').animate({right:0});
		$('.control .text').html("在线列表 &gt;&gt;");
	}else{
		$('.online').animate({right:-170});
		$('.control .text').html("在线列表 &lt;&lt;");
	}
}

function reply_private_msg(mid, nick){
	$('.private').tab('show');
	$('#private_content').focus();
	$('.send_to').val(mid);
	$('.target_nick').html(nick);

}

function send_private_msg(){
	var content = $('#private_content').val();
	var send_to = $('.send_to').val();
	if(content == ''){
		alert('请输入你要发送的内容');
		return;
	}
	if(send_to == ''){
		alert('请选择你要发送的人');
		return;
	}
	$.post(admin.url+'live/send_private_msg',
	$('.private_form').serialize(),
	function (){
		$('#private_content').val('');
	})
}

</script>