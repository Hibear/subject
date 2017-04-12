<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
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

<img src="<?php echo $cover_img ?>" alt="">
<p><?php echo $desc ?></p>
<p><?php echo $title ?></p>
<p><?php echo $score ?></p>

<input id="Receive" value='领取' type="button">

<script type="text/javascript">
    $('#Receive').click(function(){
    	$.ajax({
            type:"post",
            url:"/sign/get",
            dataType:'json',
            success:function (data) {
                if(data.code == 1){
                	layer.msg(data.msg);
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


