<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>中铁魔都签到首页</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('sign/index.css', 'www')?>">
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
<div class="home_background">

    <!--用户信息 div-->
    <div class="head">
        <div class="user_info">
            <img src="<?php if(isset($user_info['head_img'])){echo $user_info['head_img'];}?>" alt="">
            <p><?php if(isset($user_info['realname']) && !empty($user_info['realname'])){echo $user_info['realname'];}elseif(isset($user_info['nickname'])){echo $user_info['nickname'];}?>&nbsp;您好！</p>
        </div>
    </div>


    <!--div 抽奖-->
    <div class="sign_in_back">
        <div class="sign_in">
            <button onclick="jump(this)" url="/sign/log_list">马上签到</button>
            <button onclick="jump(this)" url="/sign/goods">积分商城</button>
            <button onclick="jump(this)" url="/sign/my_goods">我的礼品</button>
        </div>
    </div>
    </div>
  
<script type="text/javascript">

    function jump(obj){
        var url = $(obj).attr('url');
    	window.location.href = url;
    }
</script>
    

</body>
</html>