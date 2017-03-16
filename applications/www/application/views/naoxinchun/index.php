<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>金鸡报晓闹新春·送红包</title>
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
			<meta name="Description" content="">
			<!-- Mobile Devices Support @begin -->
			<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
			<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
			<meta content="no-cache" http-equiv="pragma">
			<meta content="0" http-equiv="expires">
			<meta content="telephone=no, address=no" name="format-detection">
			<meta name="apple-mobile-web-app-capable" content="yes"> <!-- apple devices fullscreen -->
			<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
			<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		html,body{
			height:100%;
			width:100%;
		}
		.nofinal{
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: url(/static/naonao/img/final.jpg) no-repeat;
			background-size: 100% 100% !important;
			display: none;
			z-index: 99999;
		}
		.home,.first{
			display: none;
		}
		</style>	
		<link rel="stylesheet" href="/static/naoxinchun/css/style.css" />
		
		<script type="text/javascript" src="/static/naoxinchun/js/jquery.min.js" ></script>
		<script>
		window.onload=function(){
			$(".loading").fadeOut("slow");
			$(".home").fadeIn("slow");
		}
		</script>
		
		<script type="text/javascript" src="/static/naoxinchun/js/fastclick.js" ></script>
		<script>
		
		window.addEventListener('load', function() {
		  FastClick.attach(document.body);
		}, false);
		
		$(function(){
			$(".game").hide();
			$(".btn-start").click(function(){
				$(".home").hide();
				$(".game").show();
				//$("body").css("background","#4d4b4b");
			});
			$(".hdgz").click(function(){
				$(".tips,.ping").fadeIn("slow");
			});
			$(".ping").click(function(){
				$(".tips,.ping").fadeOut("slow");
			});
		})
		</script>
		
	</head>
	<body>
	
		<div class="loading">
			<div id="caseGrise">
		  <div id="loadprogress">
			<div id="charge"></div>
		  </div>
		  <div id="load">
			<p>游戏加载中···</p>
		  </div>
		</div>
		</div>
		<!--首页-->
			<div class="tips first">
				<p style="text-align: center;font-size: 16px;">游戏说明</p>
				<p>1、玩家在40秒时间内点击红包量到达900元；</p>
				<p>2、根据提示提交用户信息；</p>
				<p>3、即可领取中央国际红包；</p>
				<p>活动时间：2017.1.13—2017.1.23；</p>
				<p>每天14:00—19:00。</p>
			</div>
			<div class="zhineng home"><img src="/static/naoxinchun/img/word.png" /></div>
			
			<div class="btn-start home"><img src="/static/naoxinchun/img/start-btn.png"></div>
			<div class="hdgz home">游戏说明</div>
		<!--首页end-->
	
	
		<div class="con" title=""></div>
		
		
		<div class="success ">
			<div class="success-head"></div>
			<div class="chengji">您的成绩为：<i id="chengji" class="trcj">0</i>秒</div>
			<div class="chengji">成功击败全国：<i id="cj">80%</i>的玩家</div>
			<div class="choujiang"><p id="choujiang">赶紧去领取红包</p></div>
			<div class="choujiang"><p id="replay">再玩一次</p></div>
		</div>
		<div class="fail">
			<div class="fail-head"></div>
			<div class="chengji">您的成绩为：<i id="chengji" class="trcj"></i>秒</div>
			<div class="chengji">成绩必须低于<i style=" font-style:normal" id="lqtime"></i>秒才能领取红包</div>
			<div class="choujiang"><p id="repfail">再玩一次</p></div>
		</div>
		
		<div class="lqhb" style="dispaly:block">
			<div><input type="text" id="name" placeholder="请输入姓名"></div>
			<div style="margin-top: 10px;">
				<input type="text" id="tel" placeholder="请输入电话">
			</div>
			<div style="margin-top: 10px;">
				<input type="text" id="code" placeholder="请输入验证码">
			</div>
			<div style="margin-top: 10px; text-align:left;padding-left:5%;"><img src="/naoxinchun/code" onclick="this.src = '/naoxinchun/code?t=' + Math.random()" style="cursor:pointer;" title="点击刷新" /></div>
			<div><p id="dq" style="margin-bottom:20px">点击领取</p></div>
		</div>
		<div class="nofinal" style="dispaly:none;"></div>
		<div class="ping">
		</div>
		<div id="time" class="game">0秒</div>
		<div class="game-head game">
        	<ul>
            	<li></li>
                <li  data=""></li>
               <li></li>
            </ul>
        </div>
        <div class="game-tu game">
        	<div class="game-tu-1">
            	<!--<img  class="img" src="/static/naoxinchun/img/1.png" data="1"/>-->
            	<!--<div class="feather"><img src="/static/naoxinchun/img/feather.png" /></div>-->
            	<div class="progress">
            		<div class="pro-color"></div>
            	</div>
            	<div id="per" class="pp">0元</div>
            </div>
           
        </div>
		
		<input type="hidden" value="<?php echo $token;?>" id="token">
        <div class="go-btn game"><button class="touchBtn">开始抢</button></div>
	 <script type="text/javascript" src="/static/naoxinchun/js/style.js" ></script>
	 <script>
	 $("#dq").click(function(){
                var tel = $.trim($("#tel").val());
                var name = $.trim($("#name").val());
                var code = $.trim($("#code").val());
                var token = $.trim($("#token").val());
				var isMobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/; 
				if(name == ""){
					alert("姓名不能为空");
					return false;
				}
				if (!isMobile.exec(tel)) {  
                    alert("请输入正确电话号码");  
                    return false;  
                }  
				if(code == ""){
					alert("验证码不能为空");
					return false;
				}
                $.ajax( {
                    url:'/naoxinchun/add_user',
                    data: {
                        'name': name,
                        'tel':tel,
                        'code':code,
                        'token':token
                    },
                    type:'POST',
                    dataType:'json',
					beforeSend:function(){
						$("#dq").html("领取中···");
					},
                    success:function(data) {
						$("#dq").html("点击领取");
						if(data.code == 100){
							$(".nofinal").fadeIn("slow");
							$(".success").hide();

						}
                        alert(data.info);
                    },
                    error : function() {
						alert("网络异常");
                    }
                });
            });
	 
	 </script>
	 <?php $this->load->view('common/share_common.php')?>
	</body>
</html>
