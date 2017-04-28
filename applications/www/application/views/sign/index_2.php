<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <title>签到首页</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('index_2.css', 'www')?>">
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
     <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;

        });
    </script>
</head>
<body>

<!-- background -->
<div id="background">
	
	<!-- 昵称 -->
	<div class="nickname"><?php echo $username ?></div>
	
	<!-- 头像 -->
	<div class="pic"><img src="/WeixinPublic/images/caideng.jpg" alt=""></div>

	<!-- 马上签到/WeixinPublic/images/write1.png -->
	<div class="sign">
		<div>
			<img src="/WeixinPublic/images/qiandao4.png" alt="">
		</div>
		<p>马上签到</p>
	</div>
	
	<!-- 我的礼品 -->
	<div class="my_prize">
		<div>
		<img src="/WeixinPublic/images/qiandao4.png" alt="">
		</div>
		<p>我的礼品</p>
	</div>
	
	<!-- 商城列表 -->
	<div class="shopping">
		<div>
				<img src="/WeixinPublic/images/qiandao4.png" alt="">
		</div>
		<p>积分商城</p>
	</div>

	

</div>
<script type="text/javascript">

	$('.sign').click(function(){
// 		window.open('/sign/log_list');
		window.location.href = '/sign/log_list';
	})
	
	$('.shopping').click(function(){
// 		window.open('/sign/lists');
		window.location.href = '/sign/goods';
	})
	
		$('.my_prize').click(function(){
// 		window.open('/sign/lists');
		window.location.href = '/sign/lists';
	})
	
	

</script>

</body>
</html>