<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">
<title>畅游燕隼·自由呼吸</title>
<style>
#main{ display:none}
.tips>div{ font-size:12px}
.ping-img{
	width:94%;
	position: absolute;
	left: 3%;
	height:96%;
	z-index:99999;
    top:2%; 
	display:none;	
}
.close{ 
	text-align:right;
	 padding-right:0%; 
	 color:#fff; 
	 position:absolute;
	 top:1%; 
	 right:1%;
	 z-index:99999999;
	 display:none;
 }
.close img{ width:30px; height:30px;}
.content-img img{ width:100%; }
.ping-img div{ -webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}
.content-img{ overflow:scroll; height:100%; width:100%;border-radius: 10px;}
.content-img::-webkit-scrollbar {width: 0px;height: 0px;}
</style>
<link rel="stylesheet" href="/static/run2/css/style.css" />
<script type="text/javascript" src="/static/run2/js/jquery.js" ></script>
<script>
	window.onload=function(){
		$(".loading").fadeOut("slow");
		$("#main").fadeIn("slow");
		
	}
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
    <div id="wrap">
		<div id="main" >
		
		<p class="close"><img src="/static/run/img/close.png"></p>  
		<div class="ping-img">
			<div class="content-img"><img src="/static/run2/img/hdgz.jpg"></div>

        </div>


			<!--分享-->
		<div class="share"></div>
		<div class="ping"></div>
		<div class="yun"><img src="/static/run2/img/yun.png"></div>
		<div class="yun2"><img src="/static/run2/img/yun.png"></div>

		
			<!--
				描述：第一页
            -->
			<div class="indexbg first"></div>
			<div class="hdgz first"><img src="/static/run2/img/hdgz.png" /></div>
			<div class="start first"><img src="/static/run2/img/start.png" /></div>
			
			<!--
            	描述：第二页 活动规则
            -->
            <div class="hdgzbg"></div>
			
			<!--第三页游戏主页-->
			<div class="bg third"></div>
			<div class="yaoqiu third"><img src="/static/run2/img/yaoqing.png" /></div>
			
			<div class="radio wushi-<?php echo $pos;?>"><img src="/static/run2/img/fox.gif" /></div>
			<div class="qipao qipao-<?php echo $pos;?>"><img src="/static/run2/img/qipao.png" /></div>

			
			<?php
			 if($nums<20){
			?>
			<div class="tips">
				<div>当前游园进度</div>
				<div>离成功还差<?php echo 20-$nums;?>位好友支持</div>
				<div>赶快邀请好友来助威</div>
			</div>
			 <?php } ?>
			 
			<?php
			if($nums>=20){
			?>
			<div class="tips">
				<div>当前游园进度</div>
				<div>获得<?php echo $nums;?>位好友支持</div>
			</div>
			
			<div class="success">
				<div class="success-main">
					<p>恭喜你已经成功畅游燕隼</p>
					<p>点击立即领奖提交资料方可领奖哦！</p>
					<a href="/run2/success"><div class="lingqu"></div></a>
				</div>
			</div>
			<?php } ?>
		</div>
</div>
<?php $this->load->view('common/share_common.php')?>

<script>
	$(function(){
		$(".hdgz").click(function(){
			$(".ping-img,.close").fadeIn("slow");
		});
		$(".close").click(function(){
			$(".ping-img,.close").fadeOut("slow");
		});
		
		$(".start").click(function(){
			$(".first").fadeOut("slow");
			
			setInterval(function(){
				$(".qipao").fadeToggle("slow");
			},1000);
			$.ajax( {
				url:'/run2/add_user',
				type:'POST',
				dataType:'json',
				success:function(data) {
				},
				error : function() {
				}
            });
		});
		
		$(".yaoqiu").click(function(){
			$(".ping,.share").fadeIn("slow");
		});
		
		$(".ping").click(function(){
			$(".ping,.share").fadeOut("slow");
		});
		
		$(".close").click(function(){
			$(".ping,.ping-img,.close").fadeOut("slow");
		});
		
	});
</script>
<audio src="/static/run2/img/1.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>
</body>
</html>











