<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>ǩ����¼</title>
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

            <div class="head_time"><?php echo date('Y-m-d') ?></div>
            <div class="qiandao">
                <p>��ǩ��&verbar;����3��</p>
            </div>
            <input type="button" id="btn">

        </div>

        <div class="pro_body">
            <p class="record">ǩ����¼</p>
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
            success:function (data) {
                if(data.code == 1){
                	layer.msg(data.msg);
                }else{
                	layer.msg(data.msg);
                }
            },
            error:function(){
            	layer.msg('δ֪����');
            }
        })
     })
    
	</script>
</body>
</html>