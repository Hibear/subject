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
    <title>方舟戏台投票</title>
    <link rel="stylesheet" href="/WeixinPublic/css/style.css" />
    <script type="text/javascript" src="/WeixinPublic/js/jquery-1.9.1.js" ></script>
    

    <script>
        window.onload=function(){
            $(".load").hide();
        }
    </script>

    <style>
    li{ list-style:none;}
    input[type="button"], input[type="submit"], input[type="reset"] {
    -webkit-appearance: none;
    }
    .list{ width: 90%; padding: 0% 5%; background: #000; padding-bottom: 3%;}
    .list ul {
    list-style: outside none none;
    margin: 0px;
    padding: 0px;
    width: 100%;
    }
    .list ul li{
    background-color: #fff;
    cursor: pointer;
    padding: 4px;
    float: left;
    box-sizing: border-box;
    width: 50%;
    border:none;

    }
    .border-item{
    border:1px solid #d2d2d2;
    width:100%;
    border-radius: 8px;
    box-shadow: 0px 2px 6px rgba(0,0,0,.5);
    box-sizing: border-box;
    padding:5px;
    position:relative;
    padding-bottom:25px;
    }
    .head-2 ul li{font-size:16px;}
    .list ul li p{
    font-size:14px;
    padding:3px 0px; color:#666; font-family:微软雅黑; background:#E7E7E7;
    text-overflow:ellipsis;
    overflow:hidden;
    -webkit-text-overflow:ellipsis;
    white-space:nowrap;
    }

    #subcode:active{ background:yellow;}
    .con{ width: 100%; display: none; background: #404a53;  z-index: 100; position: fixed !important; opacity: 0.7;}
    body{ background:#fff;}
    .head-2 ul li{background: none; color:#c49021; padding-bottom:5px; }
    .sousuo,.list{ background:#fff}
    #text{ border-radius: 6px 0 0px 6px; padding-left: 10px; width: 100%;
    background:transparent; border:1px solid #b3b3b3;
    color:#a01f24; border-right:0px; height: 32px;
    }
    #sub{border-radius: 0px 6px 6px 0px;  background: #c6100d; padding-left: 15px; padding-right: 6px; width: 100%; color:rgba(255,255,255,0.9); font-family: "微软雅黑"; font-size: 15px;border:1px solid #b4b4b4;  border-left:0px;    height: 34px;}
    input[placeholder], [placeholder], *[placeholder] {
    color: #a01f24 !important;
    }
    .list ul li p{
    background:#ffffff;font-size:16px;
    font-family:微软雅黑;
    }
    .list ul li{ margin-bottom:15px;}
    i{ font-style:normal}
    .list ul li p i{
    display:block;
    text-align:left;
    float:left;
    text-overflow: ellipsis;
    overflow: hidden;
    -webkit-text-overflow: ellipsis;
    white-space: nowrap;
    font-size:14px;
    }
    .list ul li .bh i:first-child{
    width:38%;
    padding-left:2%;
    }
    .list ul li .bh i:last-child{
    width:58%;
    padding-tight:2%;
    }
    .ttp {
    font-size: 13px;
    position: absolute;
    right: -6px;
    bottom: 20px;
    width: 50%;
    }
    .tp{ background:#ca1013; color:#fff; width:80%; padding:3px 0px; box-shadow:0px 2.5px 3px rgba(0,0,0,.6)}
    .btm ul{ display:box;display:-webkit-box;}
    .btm ul li {
    background:#961f25;
    padding: 11px 0px;
    font-family:微软雅黑;
    font-weight:blod;
    color:rgba(255,255,255,0.9);
    font-size:16px;
    border-right:1px solid rgba(255,255,255,0.9);
    -webkit-box-flex: 1; box-flex: 1;
    }


    .btm ul li:last-child{border-right:0px;}
    .btm ul li a{color:rgba(255,255,255,0.9);}
    .rank-edit-title{ width:100%; height:30px; line-height:30px; text-align:center; color:#ca1013; font-size:18px; margin-top:15px;}
    .rank-list{ width:100%; margin-top:15px;}
    .rank-list li{ width:100%; padding:5px 0%; padding-right:8px;box-sizing: border-box;text-overflow: ellipsis;
    border-top:1px solid #ca1013; height:100px;}
    .rank-number{padding-right:10px; line-height:100px; box-sizing: border-box; height:100%;color:#ca1013;font-size:18px;text-align:right;width:15%; float:left;}
    .rank-img{
    width:27%; float:left;
    border-radius: 6px;
    height: 100%;
    overflow:hidden;
    background-size: cover !important;
    }

    .rank-info{position:relative; width:58%; float:left;}
    .rank-info p{width:100%;color:#ca1013;padding-left:10px; font-size:14px;padding-top:3px;padding-bottom:3px; overflow: hidden;text-overflow: ellipsis;white-space: nowrap; }
    .rank-info p:first-child{ padding-top:8px;}
    .page1,.page2,.page3{ display:none;}
    .bb{ height:50px;}
    .hdgz{ width:100%; margin-bottom:10px; margin-top:6px; text-align:center;}
    .hdgz img{ width:100%;}
    .paiming{z-index: 999999;margin-top: 25%;}

    .paiming p:first-child{ height:40px; width:100%; border-bottom:1px solid #b2b1b1; line-height:40px;}
    .pm-title i{ width:50%; height:100%;display:block; float:left; padding-left:10px; -webkit-box-sizing: border-box;-moz-box-sizing: border-box;
    box-sizing: border-box;}
    .pm-title i:last-child{text-align:right; padding-right:10px; color:#cecece}
    .pm-img img{ width:100%; }

    .paiming p{ -webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-size:16px;}
    .paiming p:last-child{ padding:10px;}
    .list ul li p:first-child {
    padding-bottom: 75%;
    }
    .lqhb{
    position: fixed;
    width: 90%;
    font-size: 14px;
    padding-left: 5%;
    padding-right: 5%;
    background: rgba(0,0,0,.6);
    z-index: 10001;
    height:65%;
    padding-top:35%;
    display: none;
    }
    .lqhb input{width:90%; height:40px; border:0px; font-size:20px; padding-left:5%;padding-right:5%;}
    .lqhb .first{ width:100% ; box-sizing: border-box; float:left}
    .lqhb .second{ width:100% ;text-align:left; float:left;padding-top:8px;}
    .codetp{
    background: #ebad2a;
    color: #000;
    text-align: center;
    margin-left: 5%;
    margin-top: 4px;
    margin-right: 4px;
    width: 40%;
    padding: 6px 0px;
    border-radius: 8px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    float: left;
    display: block;
    }
    .close{
    position: absolute;
    width: 20px;
    height: 20px;
    color: #fff;
    right: 0%;
    top: -29px;
    font-size: 20px;
    }

    .list ul li p i.dps{ width:95%; color:#c20b0d;}
        #head-2 {
            background: #a01f24;

        }
        .head-2 ul li {
            color: #fff;


        }
        .sousuo2 {
            width: 100%;
            height: 34px;
        }
        #head-2 ul li{
            color:rgba(255,255,255,0.9);
            float: left;
            width: 33.33%;
            list-style: none;
            text-align: center;
            padding: 5px 0px;
        }

        .rank-info{
            position: relative;
            width: 58%;
            float: left;


        }
        .rank-info div{ position:absolute; left:0px; bottom:0px;}
        .rank-info p{color:#ca1013;padding-left:10px; font-size:14px;}


    </style>


</head>

<body>
<div class="load">
    <p><img src="/WeixinPublic/images/loading.gif" /></p>
    <p id="txt">加载中....</p>
</div>

<div id="con2"></div>
<div class="con" ></div>
<div class="con2" ></div>


<div class="head">
   <img src="/uploads/images/fangzhou/fangzhouheadPic.jpg"/>
</div>
<?php //foreach ($res as $v):   ?>
<div class="head-3" id="head-2">
    <ul>
        <li>
            访问量
            <p><?php echo $total_visits ?></p>
        </li>
        <li>
            投票总数
            <p><?php echo $total_vote_num['total'] ?></p>
        </li>
        <li>
            参与选手
            <p><?php echo $performer_num ?></p>
        </li>
    </ul>
    <div style="clear: both"></div>
</div>
<?php // endforeach;  ?>


<!--排行版-->

<div class="rank-edit-title page2">排行榜</div>
<div class="rank-list page2">
    <li style="text-align:center;">
        <div style="width:100%;">
            <img src="/WeixinPublic/images/loading.gif" />
            <p id="txt">加载中....</p>
        </div>
    </li>
</div>

<!--活动规则-->
<div class="hdgz page3">
    <img src="/uploads/images/fangzhou/fangzhourule.jpg">
</div>


<!-- 搜索 -->
<div class="sousuo" style="margin:5px 0px; padding-bottom:0px">
    <div class="sousuo2">
        <ul >
            <li style="width: 80%;"><input type="text"  placeholder="请输入编号或选手姓名" id="text"></li>
            <li style="width: 20%;"><input type="button" value="搜索" id="sub" class="butn" title="sousuo"></li>
        </ul>
    </div>
</div>



<div class="list">
    
    <ul id="user-list">
            <?php  foreach ($info as $v):   ?>
            <a href="<?php  echo '/index.php/Weixin/detail?id='.$v['id'] ?>">

                <li class="post">
                    <div class="border-item">
                        <p style="background: url(<?php echo "/uploads/images/".$v['cover_img']?>);"></p>
                        <p class="bh"><i>编号:<?php echo $v['id']?></i><i>姓名:<?php echo $v['fullname']?></i></p>
                        <p><i style="width:100%;">名称:<?php echo $v['title']?></i></p>
                        <p style="color:#ebad2a;padding-bottom:10px;"><i class="dps">得票数:<?php echo $v['vote_num']?></i></p>
                        <div class="ttp">
                            <div class="tp" align="center" alt="{$vo.id}">投票</div>
                        </div>
                    </div>
                </li>
            </a>
            <?php  endforeach;  ?>
    </ul>
    
    <div style="clear: both;"></div>

</div>



<!--描述:底部start-->
<div class="bb"></div>
<div class="btm">
    <ul>
        <li id="home">
            <p>首页</p>
        </li>
        <li id="pm" data-id="1">
            <p>排行榜</p>
        </li>
        <li id="gzjl" data-id="2">
            <p>规则奖励</p>
        </li>
    </ul>
</div>
<input type="hidden" value= <?php echo $p ?> id="p">

<script src="/WeixinPublic/plugins/layui/layui.js"></script>
<script>
    var vid="{$info.id}";
//    var is_code="{$info.is_code}";
    var token="{$token}";
//    var isopensms = "{$info.isopensms}";
    var layer = '';
    layui.use(['layer'], function(){
        layer = layui.layer
    });
</script>
<script type="text/javascript">
    //一下行加载完
    window.stop = true;
    var loadIndex = 0;
    $(function() {
        $(window).scroll(function () {
            if ($(document).height() - $(this).scrollTop() - $(this).height() < 50) {

                if(window.stop == true){
                    window.stop=false;
                    loadIndex = layer.load(1);
                    p= parseInt($("#p").val());



                    if(p == -1){
                        loadIndex = layer.load(1);
                        window.stop=false;
                        layer.close(loadIndex);
                    }
                    else{
                        ajaxData(p);
                    }
                }
            }

        });
        //异步请求数据
    });


    function ajaxData(p){
        $.ajax( {
//
            url:'/index.php/Weixin/get_more',
            data:{p:p},
            type:'POST',
            dataType:'json',
            beforeSend:function(){
                loadIndex = layer.load(1);
            },
            success:function(data) {

                window.stop=true;
                var html ="";
                layer.close(loadIndex);
                if(data.status == 0){


                    $.each(data.list,function(index,info){
                        var id = parseInt(info['id']);
                        var url = '/index.php/Weixin/detail?id='+id;
                        html += '<a href="'+url+'">';
                        html+='<li class="post detail">';
                        html+='<div class="border-item">';
                        html+='<p class="detail"  style="background: url(/uploads/images/'+info['cover_img']+');"></p>';
                        html+='<p class="bh"><i>编号:'+info['id']+'</i><i>姓名:'+info['fullname']+'</i></p>';
                        html+='<p><i style="width:100%;">名称:'+info['title']+'</i></p>';
                        html+='<p style="color:#ebad2a;padding-bottom:10px;"><i class="dps">得票数:'+info['vote_num']+'</i></p>';
                        html+='<div class="ttp"><div class="tp" align="center" alt="'+info['id']+'">投票</div>';
                        html+='</div></li>';
                        html+='</a>';

                    });


                    $("#p").val(data.p);

                    $("#user-list").append(html);

                }
                else if(data.status == -1){
                    $("#p").val(-1);
                }

            },
            error : function() {
                layer.close(loadIndex);
            }
        });
    }

</script>
<script src="/WeixinPublic/js/main3.js"></script>
<?php $this->load->view('common/share_common.php')?>
</body>

</html>
