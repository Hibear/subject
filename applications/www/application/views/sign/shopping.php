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

<!--background div-->
<div id="background">
    <!--shopping head-->
    <div class="shop_head">
        <!--head image-->
        <img  class="head_image" src="image/head_pic.jpg">
        <!--head jifen-->
        <div class="head_jifen">
            <p>我的积分&nbsp;132</p>;
        </div>
    </div>

    <!--shopping body-->
    <div class="shop_body">
    
        <ul class="shop_body_ul">
        <?php foreach ($list as $k=>$v):?>
        
            <li class="body_ul_li">
                <a href="/sign/detail?id=<?php echo $v['id']?>"><img class="li_img" src="<?php echo get_img_url($v['cover_img']) ?>" alt=""></a>
                <p class="ul_li_name"><?php echo $v['title']?></p>
                <p class="ul_li_jifen"><?php echo $v['score']?></p>
            </li>
        
        <?php endforeach; ?>
        </ul>
        
        
    </div>
</div>


</body>
</html>