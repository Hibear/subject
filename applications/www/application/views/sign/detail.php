
<!DOCTYPE html>
<html>
<head>
    <title>礼品详情</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('sign/style.css', 'www')?>">
    <script type="text/javascript" src="<?php echo get_css_js_url('sign/common.js', 'www')?>"></script>
    <script type="text/javascript" src="<?php echo get_css_js_url('jquery-min.js', 'www')?>"></script>
    <script type="text/javascript" src="<?php echo get_css_js_url('sign/TouchSlide.1.1.js', 'www')?>"></script>
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
    <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/dialog.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    <script type="text/javascript" src="<?php echo get_css_js_url('gold/dialog_min.js', 'www')?>"></script>
    <script type="text/javascript" src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
       
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;
        });
    </script>
    
</head>
<body>
<div id="slideBox" class="slideBox">
    <div class="bd">
        <ul>
            <li>
                <a class="pic" href="#"><img src="<?php echo get_img_url($info['cover_img'])?>" /></a>
            </li>

        </ul>
    </div>

    <div class="hd">
        <ul></ul>
    </div>
</div>

<div class="clear"></div>


<div class="xj">
    <p>商品名:<?php echo $info['title'] ?> </p>
    <p>兑换积分:<?php echo $info['score'] ?> </p>
    <p>库存量:<span id="last_num"><?php echo $info['num'] ?></span></span></p>
    
</div>



<div id="wrap">
    <div id="tit">
        <span class="select">产品详情</span>
                        商品介绍: <?php echo $info['desc'] ?>
    </div>
    <div style="height: 70px;"></div>
    <div class="clear"></div>
</div>

<div class="foot">
    <div >
        <a id="Receive" num="<?php echo $info['num'] ?>" href="#" style="font-size: 1.5em">兑换</a>
    </div>
</div>

<script type="text/javascript">
    $('#Receive').click(function(){
        var num = parseInt($(this).attr('num'));
        if(num == 0){
        	layer.msg('库存不足！');
        	return;
        }
    	var d = dialog({
    		content: '确定要兑换吗?',
    		okValue: '确定',
    		ok: function () {
    			d.close().remove();
    			$.ajax({
   	             type:"post",
   	             url:"/sign/exchange",
   	             dataType:'json',
   	             data:{id:<?php echo $info['id'] ?>},
   	             success:function (data) {
   	                 if(data.code == 1){
   	                 	 layer.msg(data.msg);
      	                 var num = parseInt($("#last_num").text()) -1;
        	             $("#last_num").text(num);
   	                 }else{
   	                 	layer.msg(data.msg);
   	                 }
   	             },
   	             error:function(){
   	             	layer.msg('网络错误！');
   	             }
   	         })
    		},
    		cancelValue: '取消',
    		cancel: function () {}
    	});
    	d.showModal();
     })
    
</script>

</body>
</html>