<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>签到记录</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('progress.css', 'www')?>">
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
    <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;

        });
    </script>

</head>
<body>

<!--progress background-->
    <div id="progress">
        <div class="pro_head">

            <div class="head_time">2016年08月23日</div>
            <div class="qiandao">
                <p>已签到&verbar;连续3天</p>
            </div>
            <input type="button" id="btn" value="签到 ">
        </div>

        <div class="pro_body">
            <p class="record">签到记录</p>
            <ul class="record_ul">
                <li class="ul_li">
                    <p class="li_time">2017-04-10</p>
                    <!--<p class="li_score">+3</p>-->
                </li>
            </ul>
        </div>

    </div>

    <script type="text/javascript">
    $('#btn').click(function(){
    	$.ajax({
            type:"post",
            url:"/sign/log",
            dataType:'json',
            data:{},
            success:function (data) {
                if(data.code == 1){
                	layer.msg(data.msg);
//                 	setTimeout(function () {
//                 		//跳转到签到列表
//                 		window.open('/sign/log_list');
//                 	}, 2000)
                }else{
                	layer.msg(data.msg);
                }
            },
            error:function(){
            	layer.msg('未知错误！');
            }
        })
     })
    
	</script>
    
    
    
    
</body>
</html>