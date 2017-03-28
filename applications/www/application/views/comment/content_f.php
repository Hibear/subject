<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/comment/css/content.css">
    <script type="text/javascript" src="/comment/pingfen/demo/js/jquery.min.js"></script>
    <script type="text/javascript" src="/comment/pingfen/lib/jquery.raty.min.js"></script>
<!--    <script type="text/javascript" src="/comment/js/content.js"></script>-->
    <link rel="stylesheet" href="/comment/pingfen/demo/css/common.css">
    <title><?php echo $company['company_name'] ?></title>



</head>
<body>
<!--<img src="/comment/image/back.png" alt="">-->
<div id="head_back">

    <div id="allnums">
        <p id="score_text"><?php echo $total['score']?>.0</p>
        <div id="scoreall_star">
            <div id="zonghe_score">综合评分:</div>
            <div id="zonghe_star" >
                <div id="function-demo_all" class="target-demo"></div>
                <script>
                    $(function () {
                        $.fn.raty.defaults.path = '/comment/pingfenb/img';
                        $("#function-demo_all").raty({
                            number: 5,
                            targetType: 'hint',
                            path: '/comment/pingfen/demo/img',
                            cancelOff: 'cancel-off-big.png',
                            cancelOn: 'cancel-on-big.png',
                            size: 44,
                            starHalf: 'star-half-big.png',
                            starOff: 'star-off-big.png',
                            starOn: 'star-on-big.png',
                            cancel: false,
                            targetKeep: true,
                            readOnly: true,
                            score: <?php echo $total['score']?>,
                        });
                    });

                </script>
            </div>
        </div>
    </div>
    <hr>

    <div id="pingfen">
        <div class="num_text">环境:<?php echo $total['hj_score']?></div>
        <div class="num_text">服务:<?php echo $total['fw_score']?></div>
        <div class="num_text">口味:<?php echo $total['kw_score']?></div>
    </div>

</div>



<!--content background-->
<div id="com_background">
    <?php foreach ($user_info as $v): ?>
        <div id="userInfo_back">
            <!--用户信息-->
            <div id="user_info" class="infos">

                <div id="head_pic"><img src="<?php echo $v['head_img'] ?>" alt=""></div>
                <div id="user_nick"><p id="head_nick"><?php echo $v['nickname'] ?></p></div>
                <div id="create_time"><p id="head_time"><?php echo date("Y-m-d",strtotime($v['create_time']))  ?></p></div>

            </div>

            <!--用户 评论星级-->
            <div id="user_star" class="infos">

                <div id="rank_background" class="demo">
                    <div id=<?php echo "function-demo_".$v['id']?> class="target-demo"></div>
                    <script>
                        $(function() {
                            $.fn.raty.defaults.path = '/comment/pingfen/lib/img';
                            $("<?php echo '#function-demo_'.$v['id']?>").raty({
                                number: 5,
                                targetType: 'hint',
                                path: '/comment/pingfen/demo/img',
                                cancelOff: 'cancel-off-big.png',
                                cancelOn: 'cancel-on-big.png',
                                size: 24,
                                starHalf: 'star-half-big.png',
                                starOff: 'star-off-big.png',
                                starOn: 'star-on-big.png',
                                cancel: false,
                                targetKeep: true,
                                readOnly: true,
                                score: <?php echo $v['score']?>,
                            });
                        });

                    </script>
                </div>
            </div>

            <!--用户评论 文字信息-->
            <div id="user_text" class="infos">
                <p id="text"><?php echo $v['comment'] ?></p>
            </div>

            <!--用户 上传图片展示-->
            <div id="user_pic" class="infos">
                <?php if($v['images']):?>
                <?php foreach (explode(',', $v['images']) as $key => $val):?>
                <img src="<?php echo get_img_url($val)?>" alt="" id="img_1">
                <?php endforeach; ?>
                <?php endif;?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<input id="com" type="button" onclick="wolaidianp()" value="我来点评">
<script type="text/javascript">
    function wolaidianp() {
        window.location.href = "/comment/comit?id=<?php echo $company['id'] ?>";
    }
</script>

</body>
</html>