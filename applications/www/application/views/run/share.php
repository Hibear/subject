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
<link rel="stylesheet" href="<?php echo css_js_url_v2('index.css', 'run');?>" />
<style>
	.page2,.wyyqbg{ display: none;}
	.zct,.wyyq{z-index:9999999;display: none;}
	 .zct{
		background: url("/static/run/img/button/zct.png") no-repeat;
	 }
	  .wyyq{
		background: url("/static/run/img/button/wyyq.png") no-repeat;
		top: 80%;
		background-size: 100% 100%;
	 }
  
  .wyyqbg img{ width:60%; margin-top:52%}
</style>
<script type="text/javascript" src="<?php echo css_js_url_v2('jquery.js', 'run');?>"></script>
<script>
	window.onload=function(){
		$(".loading").fadeOut("slow");
		$(".logo,.wyyq,.zct,.page2").show();
		setInterval(function(){
				$("#totast").fadeToggle("slow");
		},3000);
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
	<div class="zct " id="zct"></div>
	<div class="wyyq"></div>
		
	<div id="wrap">
		<div class="dialog"></div>
	    <div class="wyyqbg">
			<img src="/static/run/img/wyyqm.png" />
		</div>
		
		 <?php
		 if($nums<5){
		?>
		<div class="bg page2"></div>
		 <?php }else if($nums>=5&&$nums<10){ ?>
		 		<div class="bg2 page2"></div>
		<?php }else{ ?>
		<div class="bg3 page2"></div>
		<?php } ?>
		
		
		
		
		<div class="logo"></div>
		<div class="logo2"></div>
		<div class="faguang"></div>
		<div class="taoli"></div>
		<!--分享-->
		<div class="share"></div>
		<div class="ping"></div>
		<!--
        	描述：第一页
        -->
		

		<div id="main" class="page2"></div>
		<div id="center" class="page2">
			<div class="people-div">
				<div class="people-left"></div>
				<div class="people"></div>
				<div class="people-right"></div>
			</div>
		</div> 
		<div id="footer" class="page2"></div>


		<div class="totast" style="top: 33%;">
			<div class="totast-left"></div>
			<div class="totast-center" id="totast">
				<div class="biao"></div>
				<div class="first-txt">当前逃离进度</div>
				<div class="progress">
					<div class="pbg" style="margin-right:0px;">
                        <div style="width: <?php echo $percent;?>%; background-color:#75a9dd" class="pbr"><?php echo $percent;?>%</div>
                    </div>
				</div>
				<?php if($nums<10){ ?>
				<div class="li">离成功还差<?php echo $peoples;?>位亲友支持</div>
				<div class="li">赶快邀请亲友来助威！</div>
				<?php }else{ ?>
					<div class="li">已经获取<?php echo $nums;?>位亲友支持</div>
					<div class="li">好友已经逃离成功！</div>
				<?php } ?>
			</div>
			<div class="totast-right"></div>
		</div>
  		
	</div>
	<input type="hidden" value="<?php echo $user_id;?>" id="user_id">
	<script>
		$(function(){
			$("#zct").click(function(){
				 $.ajax( {
                    url:'/run/run_zct',
                    data: {
                        'user_id': $("#user_id").val()
                    },
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
					
                      $(".dialog").fadeIn("slow").html(data.info);
					  setTimeout(function(){
						  $(".dialog").fadeOut("slow");
					  },1000)
                    },
                    error : function() {
                    }
                });
				
				
			});
			
			$(".wyyq").click(function(){
				 $(".wyyqbg").fadeIn("slow");
				  $(".wyyq,.zct").fadeOut("slow");
				 
			});
			
		});
	</script>
	<?php $this->load->view('common/share_common.php')?>
	<audio src="/static/run/img/3.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>

</body>
</html>











