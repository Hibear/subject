<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>积分商城</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('shopping.css', 'www')?>">
</head>
<body>



    <div id="head_background">

        <div id="pic_back"></div>
        <div class="jifen_back">
            <div class="head_jifen">我的积分:</div>
            <p><?php echo $userscore['score'] ?></p>
        </div>
    </div>

<!--background div-->
<div id="background">
     
    <!--shopping body-->
    <div class="shop_body">
    <?php foreach ($list as $k=>$v):?>
        <div class="lipin">
            <a href="/sign/detail?id=<?php echo $v['id']?>">
                <img src="/WeixinPublic/images/caideng.jpg" alt="">
            </a>
                <p>名称:<?php echo $v['title']?></p>
                <p style="color:orangered">积分:<?php echo $v['score']?></p>
                <p>
                    <?php
                    if($userscore['score'] > $v['score'])
                    {?>
                        <?php echo '可兑换'; ?>
                    <?php
                    }
                    else
                    {?>
                        <?php echo '不能兑换';
                    }?>
                </p>
        </div>
    <?php endforeach; ?>
        
    </div>
</div>


</body>
</html>