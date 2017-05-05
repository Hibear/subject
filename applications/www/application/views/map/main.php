<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>媒体点位演示</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/reset.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('map/main.css', 'h5')?>" media="all" />
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
</head>
<body>
    <div class="containers">
        <div class="title"><span>媒体点位演示系统</span></div>
        <div class="media-lists">
            <?php foreach (C('media.media_type') as $k => $v):?>
                <div class="btn-lists">
                    <button onclick="jump(<?php echo $k?>)"><?php echo $v?></button>
                </div>
                
            <?php endforeach;?>
        </div>
    </div>
    <script type="text/javascript">
        function jump(id){
        	self.location.href="<?php echo $domain['h5']['url']?>/map?typeid="+id
        }
    </script>
</body>
</html>