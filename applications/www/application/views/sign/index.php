<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>签到首页</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('index.css', 'www')?>">
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

<!--签到首页 div-->
<div id="home_background">

    <!--用户信息 div-->
    <div class="head">
        <div class="user_info">
            <img src="<?php echo $userImage ?> alt="">
            <div class="text_back">
            <p class="name"><?php echo $username ?>&nbsp;您好！</p>
            </div>
        </div>
    </div>


    <!--div 抽奖-->
    <div class="sign_in_back">
        <div class="sign_in">
            <ul>
                <li id="signs">马上签到</li>
                <li id="choujiang">我的奖品</li>
                <li id="list">商城列表</li>

            </ul>
        </div>
    </div>
    </div>
  
<script type="text/javascript">

	$('#signs').click(function(){
// 		window.open('/sign/log_list');
		window.location.href = '/sign/log_list';
	})
	
	$('#list').click(function(){
// 		window.open('/sign/lists');
		window.location.href = '/sign/lists';
	})
	
	

</script>
    

</body>
</html>