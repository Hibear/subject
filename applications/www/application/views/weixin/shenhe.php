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
    <title>用户信息</title>
    <link rel="stylesheet" href="/Public/css/style.css" />

    <style>
        .bm-intro{ text-align: center; color: #414141; padding-bottom: 20px;}
        .bm-intro h2{ color: #f24302; padding-top: 8px;}
        .bm-intro h5{padding-top: 8px;}
        .bm-intro p{ padding-top: 4px;}

        .bm-intro p:last-child{ padding: 6px 30%;  height: 40px; }
        .bm-intro p:last-child a{background: #e80000; display: block; height: 40px; line-height: 40px; color: #F9F9F9; font-size: 16px; border-radius: 8px;}
        .copy{ position: absolute; bottom: 0; position: fixed;}
        font{ font-size:15px;}
        .page-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 55;
            top: 0;
            left: 0;
            bottom: 0;
            opacity:0.5;
            background:#000;
        }
        .video-cont {
            position: fixed;
            z-index: 60;
            width: 90%;
            height: 160px;
            top: 30%;
            left: 5%;
            background: #fff;
            padding-top:20px;

        }
        .video-cont p{ text-align:center; padding-top:10px;}
        input[type=text], input[type=password],input[type=button] {
            border-color: #bbb;
            height: 38px;
            font-size: 14px;
            border-radius: 2px;
            outline: 0;
            border: #ccc 1px solid;
            padding: 0 10px;
            width: 250px;
            -webkit-transition: box-shadow .5s;
            margin-bottom: 15px;
        }

        input[type=text]:focus {
            border: 1px solid #56b4ef;
            box-shadow: inset 0 1px 3px rgba(0,0,0,.05),0 0 8px rgba(82,168,236,.6);
            -webkit-transition: box-shadow .5s;
        }
        input::-webkit-input-placeholder {
            color: #999;
            -webkit-transition: color .5s;
        }

        input:focus::-webkit-input-placeholder,  input:hover::-webkit-input-placeholder {
            color: #c2c2c2;
            -webkit-transition: color .5s;
        }
    </style>

    
</head>
<body>


<div class="bm_top">
    <a href="javascript:history.go(-1);">返回上一页</a>
</div>
<div class="bm-con">
    <div class="bm-intro">
        <if condition="$info['itemtype'] eq 2 ">
            <h2>恭喜您，报名已审核通过！</h2>
            <else />
            <h2>信息审核中，请耐心等待...</h2>
        </if>
        <if condition="$info['itemtype'] eq 2 ">
            <h5>你的报名编号是<font color="#f24302">0{$info.id}</font></h5>
        </if>
        <!--<p >请点击下面的按钮进入你的投票页面,</p>-->
        <p style="padding-top: 0px;">在用户页面分享给你的朋友，他们就可以给你投票。</p>
        <if condition="$info['itemtype'] eq 2 ">
            <p >目前排名第<font color="#f24302"><b>{$rank}</b></font>名 共得<font color="#f24302"><b>{$info.nums}</b></font>票</p>
            <if condition="$rank neq 1 ">
                <p>与第一名还差<font color="#f24302"><b>{$csvote}</b></font>票</p>
            </if>
        </if>
        <if condition="$info['itemtype'] eq 2 ">
            <p>
                <a href='{:U('Index/user',array('token'=>$token,'id'=>$id,'vid'=>$vid))}'>
                进入我的投票页
                </a>
            </p>
            <else />
            <p>
                <a href='#'>
                    审核中...
                </a>
            </p>
        </if>
    </div>
</div>

<div class="copy"><a href="http://gztwkj.cn" style="color:#9c9c9c">堂外科技提供技术支持</a></div>
</body>

</html>