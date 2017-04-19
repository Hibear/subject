<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $user_info['nickname']?>的奖品</title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="<?php echo get_css_js_url('guaguaka/default.css', 'h5')?>">
    <link rel="stylesheet" href="<?php echo get_css_js_url('guaguaka/lucky-card.css', 'h5')?>">
    <script src="<?php echo get_css_js_url('guaguaka/lucky-card.min.js', 'h5')?>"></script>
    <script src="<?php echo get_css_js_url('guaguaka/jquery-1.9.1.js', 'h5')?>"></script>
</head>

<body>
    <div id="bg2"><img id="bg2_img" width="295" height="195" data-cfstyle="position:absolute;" style="position:absolute;" src="<?php echo $domain['statics']['url']?>/h5/images/guaguaka/guaguaka_word.png"></div>
    <div class="headimg">
        <img src="<?php echo $user_info['head_img']?>" />
    </div>
    <div class="tips">
        <p>我的奖品：</p>
        <?php if(isset($my_prize)):?>
        <?php foreach ($my_prize as $k => $v):?>
            <?php echo $v['create_time']?>抽中<?php echo $v['prize_name']?>获得<?php echo $v['prize']?><br>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    
    <div class="active">
        <a href="/guaguaka/index?active_id=<?php echo $info['id']?>">返回首页</a>
    </div>
</body>

</html>