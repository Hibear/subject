<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>认证系统</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('sign/index.css', 'www')?>">
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

<!--签到首页 div-->
<div class="home_background">
    <div class="from">
        <div class="field">
            <span>真实姓名：</span><input type="text" id="realname"/>
        </div>
        <div class="field">
            <span>联系电话：</span><input id="tel" type="tel" />
        </div>
        <div class="sign_in">
            <button style="width: 5rem;height: 2rem; outline: none;" onclick="add()">提交</button>
        </div>
        <span style="font-size: 0.8rem;color: #fff;">注：您必须提交认证信息才能参与活动</span>
    </div>
</div>

    
  
<script type="text/javascript">

    function add(){
        var realname = $('#realname').val();
        if(realname == ''){
        	layer.msg('真实姓名不能为空！');return;
        }
        var tel = $('#tel').val();
        if(tel == ''){
        	layer.msg('手机号不能为空！');return;
        }

        $.post('/renzheng/index', {'realname':realname, 'tel':tel}, function(data){
            if(data){
                if(data.code == 1){
                	layer.msg(data.msg);
                	<?php if($back_url):?>
                	window.location.href="<?php echo $back_url;?>";
                	<?php endif;?>
                	return;
                }
                layer.msg(data.msg);
            }else{
            	layer.msg('网络异常');
            }
        })
        
    }
</script>
    

</body>
</html>