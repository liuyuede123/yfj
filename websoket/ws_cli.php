<!DOCTYPE html>
<html dir="ltr" lang="zh" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>websocket聊天室</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript" src='js/jquery-1.11.2.min.js'></script>
</head>
<body>
<div class="container">
	<p>在线人数<span id="userNum"></span></p>
	<textarea id="message" rows="10"></textarea>
	<div class="send">
		<p><textarea id="input" placeholder="请输入要发送的内容"></textarea></p>
		<p><button type="button" class="btn btn-primary" id="sub">发送</button></p>
	</div>
</div>
<script type="text/javascript">
(function(){
	var $ = function(id){return document.getElementById(id) || null;}
	var wsServer = 'ws://172.16.2.11/websoket/ws_ser.php'; 
	var ws = new WebSocket(wsServer);
	var isConnect = false;
	ws.onopen = function (evt) { onOpen(evt) }; 
	ws.onclose = function (evt) { onClose(evt) }; 
	ws.onmessage = function (evt) { onMessage(evt) }; 
	ws.onerror = function (evt) { onError(evt) }; 
	function onOpen(evt) { 
		console.log("连接服务器成功");
		isConnect = true;
	} 
	function onClose(evt) { 
		//console.log("Disconnected"); 
	} 
	function onMessage(evt) {
		var data = JSON.parse(evt.data);
		switch (data.type) {
			case 'text':
				addMsg(data.msg);
				break;
			case 'num' :
				updataUserNum(data.msg);
				break;
		}
		
		console.log('Retrieved data from server: ' + evt.data);
	}
	function onError(evt) { 
		//console.log('Error occured: ' + evt.data); 
	}
	function sendMsg() {
		if(isConnect){
			ws.send($('input').value);
			$('input').value = '';
		}
	}
	function addMsg(msg) {
		msg = JSON.parse(msg);
		var text = '用户' + msg.user + '说:\n' + msg.text + '\n';
		$('message').value += text;
		$('message').scrollTop = $('message').scrollHeight;
	}
	function updataUserNum(msg) {
		$('userNum').innerText = msg;
	}
	$('sub').addEventListener('click',sendMsg,false);
})();
</script>
</body>
</html>