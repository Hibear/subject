<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>2049</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0' />
    <meta name="author" content="Tyw" />
    <meta name="QQ" content="409971398" />
    <meta name="version" content="0.0.5" />
    <meta name="date" content="2016.5.23" />
    <link rel="stylesheet" href="/static/game/css/reset.css" />
    <link rel="stylesheet" href="/static/game/css/tyw.css" />
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="/static/game/js/ajax.js"></script>
    <script src="/static/game/js/tyw.js"></script>

</head>
<body>
    <div id="loading" data="<?php echo $_csrf?>">
        <img src="/static/game/images/mofang.png" class="mofang">
        <p class="jindu t_center">0%</p>
    </div>
    <p class="heng dn">
    </p>
    <p class="shu dn">
    </p>
    <div class="page page1">
        <div class="box" <?php if($status){echo 'style="display:none;"';}?>>
            <p>
            </p>
            <p class="ruleBtn ft028">
                <img src="" class="ruletu g_center"></p>
            <p>
            </p>
            <p>
            </p>
            <p class="start ft032">
                <img src="" class="starttu g_center">
            </p>
            <p>
            </p>
            <p>
            </p>
            <p class="phBtn ft028">
                <img src="" class="phtu g_center">
            </p>
            <p>
            </p>
        </div>
        <img src="" class="logo t_center">
        <?php if($status):?>
        <img style="margin-top: 50%;" src="/static/game/images/fangzhouQRcode.jpg" class="t_center">
        <a class="cehua" style="margin-bottom: 10%">【关注微信公众号,回复“2049”才能参与哦】</a>
        <?php endif;?>
        <a class="cehua" href="">广告  全程策划:矩阵互动</a>
    </div>
    <p class="time lcdd">
        2049</p>
    <p class="stime lcdd dn">
        00</p>
    <div class="page dn page2">
        <!--第几题-->
        <p class="dijiti t_center">
            第1关</p>
        <div class="box que fzlt ft046">
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
            <p>
            </p>
        </div>
        <p class="res fzlt res">
            <span></span><span></span><span></span><span></span><span></span><span></span><span>
            </span><span></span><span></span>
        </p>
    </div>
    <!--错误弹出层-->
    <div class="cuowu pop">
        <div class="wrong g_center">
            <img src="" class="chongkai t_center">
            <p class="cha cuowuch">
            </p>
            <p class="sure t_center">
            </p>
        </div>
    </div>
    <!--成功弹出层-->
    <div class="zhengque pop">
        <div class="wrong g_center">
            <p class="cha close">
            </p>
            <p class="chengji">
                您的本次成绩为<span id="score"></span><br />
            <p class="queren t_center">
            </p>
        </div>
    </div>
    <!--规则弹出层-->
    <div class="rulepop dn">
        <p class="cha guan">
        </p>
        <img src="" alt="" class="rule g_center">
    </div>
    <!--排行弹出层-->
    <div class="paihpop dn">
        <img src="" alt="" class="phtitle t_center">
        <div class="paihang t_center" id="joinlist">
            
        </div>
        <p id="has_rank" style="display: none;" class="jeiguo">
            [当前总共<?php echo $game_num?>位玩家，您的成绩目前排在第<span id="myrank"></span>位。]</p>
        <p id="no_rank" style="display: none;" class="jeiguo">
            [当前总共<?php echo $game_num?>位玩家，您的成绩目前排在前十以外。]</p>
        <p class="cha chaph">
        </p>
        <img src="" class="phdi t_center">
    </div>
    <!--登记-->
    <div status="0" class="djBg pop">
        <div class="dengjiBg t_center">
            <p class="cha djguan">
            </p>
            <input type="text" placeholder="请填写2-6位姓名" class="realname txtipt" id="name"
                maxlength="6">
            <input type="tel" placeholder="请填写11位手机号码" class="tel txtipt" id="tel" 
                maxlength="11">
            <p class="" id="wtel">
            </p>
            <p class="tijiao t_center">
            </p>
        </div>
    </div>
    <script src="/static/game/js/main.js"></script>
    <?php $this->load->view('common/share_common.php')?>
</body>
</html>
