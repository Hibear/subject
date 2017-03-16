<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">
<title>逃离寒冬，相约未来</title>
<style>
#totast{ display:none;}
.ping-img{
	width:94%;
	position: absolute;
	left: 3%;
	height:96%;
	z-index:99999;
	display:none;
     top:2%;   
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
.content img{ width:100%; }
.ping-img p{ -webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-size:1.5rem;}
.content{ overflow:scroll; height:100%; width:100%;display:none;border-radius: 10px;}

.content::-webkit-scrollbar {width: 0px;height: 0px;}
</style>

<link rel="stylesheet" href="<?php echo css_js_url_v2('index.css', 'run');?>" />
<script type="text/javascript" src="<?php echo css_js_url_v2('jquery.js', 'run');?>"></script>
<script>
	window.onload=function(){
		$(".loading").fadeOut("slow");
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
		<p class="close"><img src="/static/run/img/close.png"></p>  
		<div class="ping-img">
			<p class="content" id="hdgz"><img src="/static/run/img/hdgzbg2.jpg"></p>
			<p class="content" id="ljfz"><img src="/static/run/img/ljfz.jpg"></p>

        </div>
		
	    
	    <?php
		 if($nums<5){
		?>
		<div class="bg page2"></div>
		 <?php }else if($nums>=5&&$nums<10){?>
		 		<div class="bg2 page2"></div>
		<?php }else{ ?>
		<div class="bg3 page2"></div>
		<?php } ?>

		<!--分享-->
		<div class="share"></div>
		<div class="ping"></div>
		<!--
        	描述：第一页
        -->
		<div class="index-bg page1"></div>
		<div class="jkcf page1"></div>
		<div class="hdgz page1"></div>
		<div class="ljfz page1"></div>
		<div class="first-people page1"></div>

		<div id="main" class="page2"></div>
		<div id="center" class="page2">
			<div class="people-div">
				<div class="people-left"></div>
				<div class="people"></div>
				<div class="people-right"></div>
			</div>
		</div> 
		<div id="footer" class="page2"></div>
		<div class="yqhy page2"></div>

		<?php if($nums<10){ ?>
		<div class="totast">
			<div class="totast-left"></div>
			<div class="totast-center" id="totast">
				<div class="biao"></div>
				<div class="first-txt">当前逃离进度</div>
				<div class="progress">
					<div class="pbg" style="margin-right:0px;">
                        <div style="width: <?php echo $percent;?>%; background-color:#75a9dd" class="pbr"><?php echo $percent;?>%</div>
                    </div>
				</div>
				<div class="li">离成功还差<?php echo $peoples;?>位亲友支持</div>
				<div class="li">赶快邀请亲友来助威！</div>
			</div>
			<div class="totast-right"></div>
		</div>
		<?php } ?>
	
  		<?php if($nums>=10){ ?>
			<div class="totast" style="height: 160px;">
				<div class="totast-left"></div>
				<div class="totast-center" id="totast">
					<div class="biao"></div>
					<div class="first-txt">当前逃离进度</div>
					<div class="progress">
						<div class="pbg" style="margin-right:0px;">
							<div style="width: 100%; background-color:#75a9dd" class="pbr">100%</div>
						</div>
					</div>
					<div class="li" style="color: #d77b69;">恭喜你已经完成逃离寒冬挑战</div>
					<div class="li" style="color: #d77b69;">点击立即领奖提交资料方可领奖哦！</div>
					<div class="li" id="ljlq" style="padding-top: 5px;">
						<a href="/run/success"><img src="/static/run/img/button/ljlq.png"></a>
					</div>
				</div>
				<div class="totast-right"></div>
		   </div>
		<?php } ?>
		
	</div>
	<script>
		$(function(){
			$(".jkcf").click(function(){
				$(".page1").fadeOut("slow");
				$(".page2").fadeIn("slow");
				
				 $.ajax( {
                    url:'/run/add_user',
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
					},
                    error : function() {
                    }
                });
				
				
				setInterval(function(){
					$("#totast").fadeToggle("slow");
				},3000);
			});
			
			$(".yqhy").click(function(){
				$(".ping,.share").fadeIn("slow");
			});
			
			$(".ping").click(function(){
				$(".ping,.share").fadeOut("slow");
			});
			
			$(".close").click(function(){
				$(".ping,.ping-img,.close").fadeOut("slow");
			});
			
			$(".hdgz").click(function(){
				$("#ljfz").hide();
				$(".ping,.ping-img,#hdgz,.close").fadeIn("slow");
				
				
			});
			
			$(".ljfz").click(function(){
				$("#hdgz").hide();
				$(".ping,.ping-img,#ljfz,.close").fadeIn("slow");
				
			});
			
			
			
		});
	</script>
	<?php $this->load->view('common/share_common.php')?>
	<audio src="/static/run/img/3.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>

</body>
</html>











