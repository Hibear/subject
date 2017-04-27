<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/reset.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('map/style.css', 'h5')?>" media="all" />
    <title>灯箱</title>
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
<script>

window.onload = function(){

    //直接加载地图   

    var html = "<p>1ioqweur</p>";
    //初始化地图函数  自定义函数名init
    function init() {
        //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
         var map = new qq.maps.Map(document.getElementById("container"), {
            center: new qq.maps.LatLng(40,117.16),      // 地图的中心地理坐标。
            zoom:11,                                                // 地图的中心地理坐标。
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
        <?php foreach ($lists as $k  => $v):?>
            var center = new qq.maps.LatLng(<?php echo $v['x']?>, <?php echo $v['y']?>);
            var marker_<?php echo $k?> = new qq.maps.Marker({
                //设置Marker的位置坐标
                position: center,
                //设置显示Marker的地图
                map: map
            });
            
            //添加监听事件
            qq.maps.event.addListener(marker_<?php echo $k?>, 'click', function() {
                showdetail(<?php echo $v['id']?>);
            });
            
            var anchor = new qq.maps.Point(0, 39),
            size = new qq.maps.Size(25, 25),
            origin = new qq.maps.Point(0, 0),
            markerIcon = new qq.maps.MarkerImage(
                <?php if($v['is_use']):?>
                "<?php echo $domain['statics']['url']?>/h5/images/map/yellow.png",
                <?php else:?>
                "<?php echo $domain['statics']['url']?>/h5/images/map/green.png",
                <?php endif;?>
                size, 
                origin,
                anchor
            );
        marker_<?php echo $k?>.setIcon(markerIcon);

    <?php endforeach;?>
    }
    //调用初始化函数地图 setClickable(clickable:Boolean)
    init();

    function showdetail(id){
        alert(id);
    }

}
</script>
</head>
<body>
<div class="h-tips">
            贵阳腾讯房产广告灯箱分布
</div>
<div class="tip">
    <img src="<?php echo $domain['statics']['url']?>/h5/images/map/yellow.png">表示有档期
    <img src="<?php echo $domain['statics']['url']?>/h5/images/map/green.png">表示无档期
</div>
<!--   定义地图显示容器   -->
<div id="container"></div>

<div class="f-tips">请点击坐标查看详情</div>
</body>
</html>