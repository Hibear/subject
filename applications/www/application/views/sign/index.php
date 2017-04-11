<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>趣味签到首页</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('index.css', 'www')?>">
</head>
<body>

<!--签到首页 大div-->
<div id="home_background">

    <!--div 用户信息-->
    <div class="head">
        <div class="user_info">
            <img src="<?php echo $domain['statics']['url'];?>/www/images/001pic.jpg" alt="">
            <div class="text_back">
            <p class="name">阿波罗先生&nbsp;您好!</p>
            </div>
        </div>
    </div>


    <!--div 签到 抽奖-->
    <div class="sign_in_back">
        <div class="sign_in">
            <ul>
                <li>马上签到</li>
                <li>积分抽奖</li>
                <li>社区发帖</li>
                <li>积分兑换</li>
            </ul>
        </div>
    </div>
    </div>


</body>
</html>