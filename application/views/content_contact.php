 <div class="company_link_us"  >
				<!-- 联系我们 -->
				<div class="company_link_us_map"  id="map1area">
				</div>
				<div class="company_link_us_detail">
					<p class="company_link_us_detail_title">壹银添丰商品经营有限公司</p>
					<p class="company_link_us_detail_contain link_place">地址：上海市宝山区共和新路5000号绿地集团6栋801-816</p>
					<p class="company_link_us_detail_contain link_zip">邮编：200000</p>
					<p class="company_link_us_detail_contain link_email">邮箱（客服）：2850631838@qq.com</p>
					<p class="company_link_us_detail_contain link_tel">电话：021-51928681</p>
				</div>
				

			</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Xw8PqGVmsKVZNHNsVbrsEfvt"></script>
<script type="text/javascript">
    $(function(){
        var map = new BMap.Map('map1area');
        var icon = new BMap.Icon('../ok.gif', new BMap.Size(20, 32), {//是引用图标的名字以及大小，注意大小要一样
            anchor: new BMap.Size(10, 30)//这句表示图片相对于所加的点的位置
        });
        map.enableScrollWheelZoom();
        var mapinputarea;
        var point = new Array(); //存放标注点经纬信息的数组
        var marker = new Array(); //存放标注点对象的数组
        var info = new Array(); //存放提示信息窗口对象的数组
        var lng =  '121.451313';
        var lat =  '31.328474';
        if(lng>0 && lat>0){
            map.centerAndZoom(new BMap.Point(lng, lat), 22);
            marker = new BMap.Marker(new BMap.Point(lng, lat));
            //marker.enableDragging();
            map.addOverlay(marker);
        }
        console.log(mapinputarea);

    })
</script>
