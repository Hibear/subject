<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>灯箱</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/reset.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('map/style.css', 'h5')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('swiper/swiper.min.css', 'h5')?>" media="all" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <!-- Mobile Devices Support @begin -->
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&key=6NGBZ-GMWC4-AIXUD-DWDJN-NVK7F-VWBOH"></script>
    <script src="<?php echo get_css_js_url('gold/jquery.js', 'www')?>" type="text/javascript"></script>
    <script src="<?php echo get_css_js_url('swiper/swiper.min.js', 'h5')?>" type="text/javascript"></script>
    <script src="<?php echo get_css_js_url('swiper/swiper.jquery.min.js', 'h5')?>" type="text/javascript"></script>
    <script>

window.onload = function(){

    //直接加载地图   
    //初始化地图函数  自定义函数名init
    function init() {
        //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
        var x = '26.642089';
        var y = '106.651368';
         var map = new qq.maps.Map(document.getElementById("containers"), {
            center: new qq.maps.LatLng(x,y),      // 地图的中心地理坐标。
            zoom:15,                                                // 地图的中心地理坐标。
          	//启用缩放控件
            zoomControl: true,
            //设置缩放控件的位置和样式
            zoomControlOptions: {
                //设置缩放控件的位置为相对左方中间位置对齐.
                position: qq.maps.ControlPosition.LEFT_CENTER,
                //设置缩放控件样式为仅包含放大缩小两个按钮
                style: qq.maps.ZoomControlStyle.SMALL
            }
        });
         
         var info = new qq.maps.InfoWindow({
             map: map
         });
         
        //遍历所有灯箱
        <?php if(isset($lists)):?>
        <?php foreach ($lists as $k  => $v):?>
            <?php if($v['tx_coordinate']):?>
            var center = new qq.maps.LatLng(<?php echo $v['tx_coordinate']?>);
            var marker_<?php echo $k?> = new qq.maps.Marker({
                //设置Marker的位置坐标
                position: center,
                //设置显示Marker的地图
                map: map
            });
            
            //添加监听事件
            qq.maps.event.addListener(marker_<?php echo $k?>, 'click', function() {
                showdetail(<?php echo json_encode($v)?>);
            });
            
            var anchor = new qq.maps.Point(0, 39),
            size = new qq.maps.Size(25, 25),
            origin = new qq.maps.Point(0, 0),
            markerIcon = new qq.maps.MarkerImage(
                <?php if($v['is_lock']):?>
                "<?php echo $domain['statics']['url']?>/h5/images/map/yellow.png",
                <?php else:?>
                "<?php echo $domain['statics']['url']?>/h5/images/map/green.png",
                <?php endif;?>
                size, 
                origin,
                anchor
            );
        marker_<?php echo $k?>.setIcon(markerIcon);
        <?php endif;?>
    <?php endforeach;?>
    <?php endif;?>
    }
    //调用初始化函数地图 setClickable(clickable:Boolean)
    init();

    function showdetail(data){
        //初始化赋值
        //给idjin_ditu赋值
        $('#ditu').attr('center', data.tx_coordinate);
        //console.log(data);
        
        if(data.tx_jiejingid != ''){
        	$('#jiejing').text('进入街景');
            $('#jiejing').attr('data', data.tx_jiejingid);
            //配置为可点击
            $('#jiejing').attr('status', 1);
        }else{
            $('#jiejing').text('暂无街景');
            $('#jiejing').attr('status', 0);
        }
        //配置图集
        if(data.images != ''){
        	var html ='';
        	for(i=0;i<data.images.length;i++){
        		html += '<div class="swiper-slide">';
        			html += '<img class="full" src="<?php echo $domain['adv']['url']?>'+data.images[i]+'" />';
        		html += '</div>';
            }
            $('.swiper-wrapper').html(html);
            
            var mySwiper = new Swiper ('.swiper-container', {
        		  pagination: '.swiper-pagination',
        	      paginationClickable: true,
        	      spaceBetween: 30,
        	});
        }else{
        	$('.swiper-wrapper').html('');
        }
        
        $('.showdetail').addClass('show');
        $('.h-lt').addClass('act');
        $('.h-lt').attr('status', 1);
        $('.navbar').addClass('navact');
    }

    $('.h-lt').on('click', function(){
        var status = $(this).attr('status');
        if(status == 2){
        	$('.jiejing').removeClass('show');
        	$(this).attr('status', 1);
        	return false;
        }
        if(status == 3){
        	$('.ditu').removeClass('show');
        	$(this).attr('status', 1);
        	return false;
        }
        if(status == 1){
        	$(this).removeClass('act');
        }
        $('.jiejing').removeClass('show');
        $('.showdetail').removeClass('show');
        $('.navbar').removeClass('navact');
    });

    $('#jiejing').on('click', function(){
    	var status = $(this).attr('status');
    	if(status == 0){
    	    return false;
        }
    	$('.h-lt').attr('status', 2);
        var id = $(this).attr('data');
        $('.jiejing').addClass('show');
        init_jiejing(id);
    });

    //进入地图
    $('#ditu').on('click', function(){
    	$('.h-lt').attr('status', 3);
        var point =$(this).attr('center');
        $('.ditu').addClass('show');
        var point = point.split(",");
        var maps = new qq.maps.Map(document.getElementById("jin_ditu"), {
            center: new qq.maps.LatLng(point[0],point[1]),      // 地图的中心地理坐标。
            zoom:18,                                                // 地图的中心地理坐标。
          	//启用缩放控件
            zoomControl: true,
            //设置缩放控件的位置和样式
            zoomControlOptions: {
                //设置缩放控件的位置为相对左方中间位置对齐.
                position: qq.maps.ControlPosition.LEFT_CENTER,
                //设置缩放控件样式为仅包含放大缩小两个按钮
                style: qq.maps.ZoomControlStyle.SMALL
            }
        });
    })

    function init_jiejing(id) {
        // 创建街景
        pano = new qq.maps.Panorama(document.getElementById('pano_container'), {
            "pano": id,
            "pov":{
                heading:0,
                pitch:0
            }
        });
    }

}
</script>
</head>
<body>
<div class="h-tips">
            <span status="1" class="h-lt">&lt;</span>贵阳腾讯房产广告灯箱分布
</div>
<div class="tip">
    <img src="<?php echo $domain['statics']['url']?>/h5/images/map/yellow.png">表示有档期
    <img src="<?php echo $domain['statics']['url']?>/h5/images/map/green.png">表示无档期
</div>
<!--   定义地图显示容器   -->
<div id="containers"></div>
<!--   定义地图显示容器end   -->

<div class="showdetail">
    <!-- 幻灯片开始 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
        
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- 幻灯片结束 -->
    <div style="padding:10px 0;display:block">
        <table class="btable tabdw" style="display: table;">
            <tbody>
                <tr><td class="s1">媒体位置</td><td class="s2">东山宾馆东门</td></tr>
                <tr><td class="d1">区域属性</td><td class="d2">海滨路 </td></tr>
                <tr><td class="s1">媒体形式</td><td class="s2">灯箱</td></tr>
                <tr><td class="d1">媒体规格</td><td class="d2">erqwerf</td></tr>
                <tr><td class="s1">交通流量</td><td class="s2">8万辆/天 10万人次/天</td></tr>
                <tr><td class="d1">亮灯时间</td><td class="d2">18:00-22:00</td></tr>
                <tr><td class="s1">刊例价</td><td class="s2">qpweortq]pe4</td></tr>
                <tr><td class="d1">媒体档期</td><td class="d2">无档期</td></tr>
            </tbody>
        </table>
	</div>
    <div class="navbar">
      <a class=" jsaction" id="ditu" center="">进入地图</a>
      <a class=" jsaction" status="" id="jiejing">进入街景</a>
    </div>
</div>
<div class="jiejing">
    <div style="width:100%;height:auto;min-height:550px" id="pano_container"></div>
</div>
<div class="ditu">
    <div id="jin_ditu" style="width:100%;height:auto;min-height:550px"></div>
</div>
<div class="f-tips">请点击坐标查看详情</div>
</body>
</html>