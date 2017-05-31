<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>积分商城</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('sign/shopping.css', 'www')?>">
</head>
<body>
<!--background div-->
<div id="background">
     
    <!--shopping body-->
    <div class="shop_body">
    <?php foreach ($list as $k=>$v):?>
        <div class="lipin">
            <a href="/sign/detail?id=<?php echo $v['id']?>">
                <img src="<?php echo get_img_url($v['cover_img'])?>" alt="">
            </a>
                <p>名称:<?php echo $v['title']?></p>
                <p style="text-align:center;">
                                                    积分:<?php echo $v['score']?>&nbsp;
                    <?php
                    if($userscore['score'] > $v['score'])
                    {?>
                        <?php echo '可兑换'; ?>
                    <?php
                    }
                    else
                    {?>
                        <?php echo '<span color="red">不能兑换</span>';
                    }?>      
                </p>
        </div>
    <?php endforeach; ?>
        
    </div>
</div>
<div class="backtoindex">
    <p>返回首页</p>
</div>
<script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
<script type="text/javascript">
    $('.backtoindex').on('click', function(){
        window.open('/sign/index', '_self');
    });
</script>
</body>
</html>