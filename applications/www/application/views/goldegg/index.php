<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href"<?php echo get_css_js_url('gold/reset.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/main.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/dialog.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    
    <title><?php echo $info['title'] ?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <!-- Mobile Devices Support @begin -->
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <!-- Mobile Devices Support @end -->

    <!--
已下为二次改动增加分享统计功能
user:liushunyu

-->
</head>
<body onselectstart="return true;" ondragstart="return false;">
<script src="<?php echo get_css_js_url('gold/jquery.js', 'www')?>" type="text/javascript"></script>
<script src="<?php echo get_css_js_url('gold/alert.js', 'www')?>" type="text/javascript"></script>
<script type="js/zepto.js"></script>
<script type="text/javascript" src="<?php echo get_css_js_url('gold/dialog_min.js', 'www')?>"></script>
<script type="text/javascript" src="<?php echo get_css_js_url('gold/player_min.js', 'www')?>"></script>
<script type="text/javascript" src="<?php echo get_css_js_url('gold/main.js', 'www')?>"></script>
<script type="text/javascript" src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        playbox.init("playbox");
        //

        var shape = document.getElementById("shape");
        var hitObj = {
            handleEvent: function(evt){
                if("SPAN" == evt.target.tagName){
                   var audio = new Audio();
                   audio.src = "<?php echo $domain['statics']['url']?>/common/smashegg.mp3";
                   audio.play();
                    setTimeout(function(){
                        evt.target.classList.toggle("on");
                        $.ajax({
                            url: "/goldegg/zadan",
                            type: "POST",
                            dataType: "json",
                            async:true,
                            data:{active_id:<?php echo $info['id']?>},
                            success: function(res){
                                if(1 == res.code){
                                    evt.target.classList.toggle("luck");
                                }
                                setTimeout(function(){
                                    if(1 == res.success){
                                        var urls = ["<?php echo $domain['statics']['url']?>/www/images/gold/coin.png"];
                                        //今日抽取次数+1
                                        var num = parseInt($('#usenums').text())+1;
                                        $('#usenums').text(num);
                                        alert(res.msg);
                                    }else if(-1 == res.code){
                                        //今日抽取次数+1
                                        var num = parseInt($('#usenums').text())+1;
                                        $('#usenums').text(num);
                                        alert(res.msg);
                                        return;
                                    }else{
                                    	alert(res.msg);
                                        return;
                                    }
                                }, 2000);
                            }
                        });

                    }, 100);
                    $("#hit").addClass("on").css({left: evt.pageX+"px", top:evt.pageY +"px"});
                }
                shape.removeEventListener("click", hitObj, false);
            }
        };
        shape.addEventListener("click", hitObj, false);
    }, false);

    function alert(info){
    	var d = dialog({
    		content: info
    	});
    	d.showModal();
    	setTimeout(function () {
    		d.close().remove();
    		window.location.href ="/goldegg/index?active_id=<?php echo $info['id']?>";
    	}, 2000);
    }
        
</script>
<div class="body pb_10" >
    <div style="position:absolute;left:10px;top:10px;z-index:350;">
        <a href="javascript:;" id="playbox" class="btn_music" onclick="playbox.init(this).play();" ontouchstart="event.stopPropagation();"></a><audio id="audio" loop src="<?php echo $domain['statics']['url']?>/common/default.mp3" style="pointer-events:none;display:none;width:0!important;height:0!important;"></audio>
    </div>
    <section class="stage">
        <img src="<?php echo $domain['statics']['url']?>/www/images/gold/stage.jpg" />
        <div id="shape" class="cube on">
            <div class="plane one"><span><figure>&nbsp;</figure></span></div>
            <div class="plane two"><span><figure>&nbsp;</figure></span></div>
            <div class="plane three"><span><figure>&nbsp;</figure></span></div>
        </div>
        <div id="hit" class="hit"><img src="<?php echo $domain['statics']['url']?>/www/images/gold/1.png" /></div>
    </section>
    <section>
        <div class="instro_wall">

            <article>
                <h6>参与次数</h6>
                <div style="line-height:200%">
                    <p><?php if($info['is_one'] == 0){echo '每天只能抽'.$info['count'].'次';}else{echo '每个人只能中一次奖';}?> - 今天已抽取 <span class="red" id="usenums"><?php echo $num?></span> 次</p>
                </div>
            </article>
            <article>
                <h6>活动说明</h6>
                <div style="line-height:200%">
                    <p><?php echo $info['desc']?></p>
                </div>
            </article>
            <article class="a3">
                <h6>活动奖项</h6>
                <div style="line-height:200%">
                    <?php if(isset($prize)):?>
                    <?php foreach ($prize as $k => $v):?>
                    <p><?php echo $v['prize_name']?>: <?php echo $v['prize'] ?></p>
                    <?php endforeach;?>
                    <?php endif;?>

                </div>
            </article>
            <article class="a3">
                <h6>我的奖品</h6>
                <div style="line-height:200%">
                    <?php if(isset($my_prize)):?>
                    <?php foreach ($my_prize as $k => $v):?>
                    <p><?php echo $v['create_time']?>抽中<?php echo $v['prize_name']?>获得<?php echo $v['prize']?> [<?php if($v['status'] == 1){echo '已领取';}else{echo '未领取';}?>]</p>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
            </article>


        </div>
    </section>

</div>

<div mark="stat_code" style="width:0px; height:0px; display:none;">
</div>

</body>
</html>