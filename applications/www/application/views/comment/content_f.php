<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/comment/css/content.css">
    <script type="text/javascript" src="/comment/pingfen/demo/js/jquery.min.js"></script>
    <script type="text/javascript" src="/comment/pingfen/lib/jquery.raty.min.js"></script>
    <link rel="stylesheet" href="/comment/pingfen/demo/css/common.css">
    <title><?php echo $company['company_name'] ?></title>
</head>
<style>
    .act{
	   position: fixed;
       top:0;
	   bottom: 0;
	   background-color: #333;
	   height: 100%;
	   width: 100%;
	   z-index: 9;
    }
    .img_s, #imgs{
	    cursor:pointer; 
    }
</style>
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
                            number:5,
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
                                number:5,
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
            <?php if($v['images'] && !empty($v['images'])):?>
            <div id="user_pic" class="infos">
                <?php foreach (explode(',', $v['images']) as $key => $val):?>
                <img src="<?php echo get_img_url($val)?>" alt="" status='0' class='img_s' id="img_s_<?php echo $key+1?>">
                <?php endforeach; ?>
                
            </div>
            <?php endif;?>
        </div>
    <?php endforeach; ?>
</div>

<input type="hidden" value="1" id="p">
<input type="hidden" value="<?php echo $id?>" id="id">
<script src="/WeixinPublic/plugins/layui/layui.js"></script>
<script>

    var layer = '';
    layui.use(['layer'], function () {
        layer = layui.layer
    });

</script>
<script type="text/javascript">
    //一下行加载完
    window.stop = true;
    var loadIndex = 0;
    $(function () {
        $(window).scroll(function () {
            if ($(document).height() - $(this).scrollTop() - $(this).height() < 50) {
                if (window.stop == true) {
                    window.stop = false;
                    loadIndex = layer.load(1);
                    var p = parseInt($("#p").val());
                    var id = $('#id').val();
                    if (p == -1) {
                        loadIndex = layer.load(1);
                        window.stop = false;
                        layer.close(loadIndex);
                    } else {
                        ajaxData(p, id);
                    }
                }
            }
        });
        //异步请求数据
    });

    function ajaxData(p, id) {

        $.ajax({
            url: '/comment/load_more',
            data: {p: p, id:id},
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                loadIndex = layer.load(1);
            },
            success: function (data) {
                window.stop = true;
                var html = "";
                layer.close(loadIndex);
                if (data.status == 0) {
                    $.each(data.list, function (index, info) {
                        html += '<div id="userInfo_back" >';
                        //用户信息
                        html += '<div id="user_info" class="infos">';
                        html += '<div id="head_pic">';
                        html += '<img src="'+info['head_img']+' ?>" alt="">';
                        html += '</div>';
                        html += '<div id="user_nick">';
                        html += "<p id= 'head_nick'>"+info['nickname']+"</p>";
                        html += ' </div>';
                        html += '<div id="create_time" >';
                        html += "<p id='head_time'>"+info['create_time']+"</p>";
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="user_star" class="infos">';
                        html += '<div id="rank_background" class="demo">';
                        html += "<div id='function-demo_"+info['id']+" 'class=target-demo ></div>";
                        for(i=1; i<= info['score']; i++){
                            html += '<img src="/comment/pingfen/demo/img/star-on-big.png" alt="1" title="gorgeous">';
                        }
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="user_text" class="infos">';
                        html += '<p id="text">'+info['comment']+'</p>';
                        html += '</div>';
                        var img = info['images'];
                        if(img != ''){
                        html += '<div id="user_pic" class="infos">';
                            var img_array = img.split(",");
                            for(img_num = 0; img_num < img_array.length; img_num++){
                                html += '<img style="width: 78px;  height: 78px;  border-radius: 3px; margin-right: 0.15rem;" src="http://imgs.wesogou.com/image/'+img_array[img_num]+'" alt="" status="0" class="img_s" id="img_s_'+info.id+img_num+'">';
                            }
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '</div>';
                    });
                    $("#p").val(data.p);
                    $("#com_background").append(html);
                }
                else if (data.status == -1) {
                    $("#p").val(-1);
                }
            },
            error: function () {
                layer.close(loadIndex);
            }
        });
    }


</script>


<div id="com"   >
    <input  type="button" onclick="wolaidianp()" value="我来点评" style="padding-left: 70px; font-size: 30px; border: none;width: 60%;height: 50px ;line-height: 50px ;background: white;flex: 7">
    <input  type="button"  onclick="wolaidianp()" src="" alt="" style="width: 48px;height: 48px ;background: url('/comment/image/write.png')no-repeat;flex: 1;border: none">
</div>

<div id="bg"></div>
<div id="big_pic" style="width: 100%;height: 100% ; display: none ; justify-content: center; text-align:center; z-index:999" >
    <img id="imgs" callback_id="" src="" style="width: 100%;display: none; position: fixed;top: 0px;left: 0px;z-index:999">
    <span>点击图片关闭</span>
</div>

<script type="text/javascript">

        $("body").on('click', '.img_s',  function () {
            
            _obj = $(this);
            var img = _obj.attr('src');
            var status = _obj.attr('status');
            var callback_id = _obj.attr('status');
            if(status == 0){
            	$('#bg').addClass('act');
                $("#com").hide();
                $("#big_pic").show();
                $("#imgs").show();
                $("#imgs").attr('src', img);
                $("#imgs").attr('callback_id', callback_id);
                //_obj.attr('status', 1);
            }
        });

        $('body').on('click', '#imgs', function(){
        	$('#bg').removeClass('act');
        	_obj = $(this);
        	var callback_id = _obj.attr('callback_id');
            $("#com").show();
            $("#big_pic").hide();
            $("#imgs").hide();
            $('#'+callback_id).attr('status', 0);
            
        })
</script>


<script type="text/javascript">
    function wolaidianp() {
        window.location.href = "/comment/comit?id=<?php echo $company['id'] ?>";
    }	    	    
</script>

</body>
</html>
