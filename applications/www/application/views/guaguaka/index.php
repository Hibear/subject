<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $info['title']?></title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="<?php echo get_css_js_url('guaguaka/default.css', 'h5')?>">
    <link rel="stylesheet" href="<?php echo get_css_js_url('guaguaka/lucky-card.css', 'h5')?>">
    <script src="<?php echo get_css_js_url('guaguaka/lucky-card.min.js', 'h5')?>"></script>
    <script src="<?php echo get_css_js_url('guaguaka/jquery-1.9.1.js', 'h5')?>"></script>
</head>

<body>
    <div id="bg2"><img id="bg2_img" width="295" height="195" data-cfstyle="position:absolute;" style="position:absolute;" src="<?php echo $domain['statics']['url']?>/h5/images/guaguaka/guaguaka_word.png"></div>
    <div id="scratch">
        <div id="card"><?php echo $_prize['msg']?></div>
    </div>
    
    <div class="active">
        <a id="more" class="hide" href="/guaguaka/index?active_id=<?php echo $info['id']?>">再来一次</a>
        <a href="/guaguaka/myprize?active_id=<?php echo $info['id']?>">我的奖品</a>
    </div>
    
    <div class="tips">
        <p>活动详情：</p>
        <?php echo $info['desc']?>
    </div>
    
    <div class="tips">
        <p>奖项：</p>
        <?php if(isset($prize)):?>
        <?php foreach ($prize as $k => $v):?>
            <?php if($v['is_lottery'] == 1):?>
            <?php echo $v['prize_name']?>:<?php echo $v['prize']?><br>
            <?php endif;?>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    <script>
    LuckyCard.case({
        ratio: 0.3
    }, function() {
        this.clearCover();
        <?php if($num < $info['count']):?>
            <?php if($info['is_one']):?>
                <?php if($prize_log == 0):?>
                    $('#more').removeClass('hide');
                <?php endif;?>
            <?php elseif($prize_log < $info['count']):?>
                $('#more').removeClass('hide');
            <?php endif;?>
        <?php endif;?>
    });
    </script>
</body>

</html>