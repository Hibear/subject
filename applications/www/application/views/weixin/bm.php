<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <meta name="poweredby" content="gztwkj.cn" />
    <title>{$userinfo.idnums}号选手 {$userinfo.name}</title>
    <link rel="stylesheet" href="../Public/css/style.css" />
    <link rel="stylesheet" href="../Public/plugins/layui/css/layui.css">

    <script>
        window.onload=function(){
            $(".load").hide();
        }
    </script>
    <style>
        .pic{height:40px; margin-bottom:10px; text-align:center; line-height:40px; width:50%; display:block; background:pink; float:left}
        #subb-p{ padding-top:10px;}
        #btnp img{ max-width:60px;}
    </style>

    <script>
        var vid="{$vid}";
        var token="{$token}";
    </script>
</head>
<body>

<pre id="console"></pre>
<div class="bm_top">
    <a href="javacript:;" onclick="window.history.go(-1)">返回</a>
</div>
<form action="{:U('Index/bm')}" method="post" id="form">
    <div class="bm-con">
        <div class="bm-intro">
            <p style=" padding: 0px;">还没有报名参加活动，快报名吧！</p>
            <p style="color: #ff774c;padding: 0px;">上传图片不能大于2M,如有疑问请联系我们 Tel:18985909512</p>

            报名成功后，请过几个小时或者一天后再到报名页面查看审核进度。
        </div>
        <p>
            <input type="text" style="height:50px" name="name" placeholder="<?php echo $newinfo['tsname'];?>" id="name">
            <input type="hidden" value="" name="infopic" id="infopic">
            <input type="hidden" value="<?php echo $vid;?>" name="vid" id="vid">
            <input type="hidden" value="<?php echo $token;?>" name="token" id="token">
            <input type="hidden" value="<?php echo $wecha_id;?>" name="wecha_id" id="wecha_id">
            <input type="hidden" value="<?php echo $openid;?>" name="openid" id="openid">
        </p>
        <p>
            <input type="text" style="height:50px" name="tel" placeholder="<?php echo $newinfo['tstel'];?>" id="tel">
        </p>
        <p>
            <textarea placeholder="<?php echo $newinfo['tpinfo'];?>" name="info"></textarea>
        </p>

        <p id="btnp" >
            <input type="file" name="file" lay-ext="jpg|png|gif|jpeg" class="layui-upload-file">

        </p>

        <p id="subb-p"><input type="button" value="报名" id="subb"></p>
</form>
</div>
<div class="copy"><a href="http://gztwkj.cn" style="color:#9c9c9c">堂外科技提供技术支持</a></div>
<script src="/Public/plugins/layui/layui.js"></script>

<script>

    layui.use(['upload','layer','jquery'], function(){
        var layer = layui.layer;
        var $ = layui.jquery;
        var index;
        layui.upload({
            url: "{:U('Index/upload')}"

            ,success: function(data){
                layer.closeAll();
                if(data.error == -1){
                    layer.msg(data.msg, {icon: 2});
                }else{
                    $("#btnp").append('<img src="'+data.imgurl+'">');

                }
            }
            ,before: function(input){
                index = layer.load(2);

            }
        });

        $("#subb").click(function(){
            var len = $("#btnp").find("img").size();
            var name = $.trim($("#name").val());
            var tel = $.trim($("#tel").val());
            if(name==""){
                layer.msg('名称或编号不能为空', {icon: 2,time: 1000});
                e.preventDefault();
                submit_islock=false;
                return false;
            }
            if(tel==""){
                layer.msg('电话号码不能为空', {icon: 2,time: 1000});
                e.preventDefault();
                submit_islock=false;
                return false;
            }
            if(tel != ""){
                if(!(/^\d{11}$/.test(tel))){
                    layer.msg('手机格式不正确', {icon: 2,time: 1000});
                    submit_islock=false;
                    return false;
                }
            }
            if(len==0){
                layer.msg('你还没有上传照片', {icon: 2,time: 1000});
                submit_islock=false;
                e.preventDefault();
            }
            //把所有的图片的拼接成一个字符串
            var strFile = "";
            for(var i=0; i<len;i++){
                var src = $("#btnp").find("img").eq(i).attr("src");
                strFile+=src+"|";
            }
            $("#infopic").val(strFile);
            $("#form").submit();
        });

    });
</script>

</body>

</html>