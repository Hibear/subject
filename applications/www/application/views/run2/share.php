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
.toast{ display:none;}
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
.content-img::-webkit-scrollbar {width: 0px;height: 0px;}#toast{ font-size:14px;}
.hide{ display:none;}

.yun2{
top: 5rem;
}
</style>
<link rel="stylesheet" href="/static/run2/css/style.css" />
<script type="text/javascript" src="/static/run2/js/jquery.js" ></script>
<script>
	window.onload=function(){
		$(".loading").fadeOut("slow");
		$("#main").fadeIn("slow");
		setInterval(function(){
			$(".qipao").fadeToggle("slow");
		},1000);
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
			<div class="toast" id="toast"></div>
			<p class="close"><img src="/static/run/img/close.png"></p>  
				<div class="ping-img">
					<div class="content-img"><img src="/static/run2/img/wyyqbg.jpg"></div>

				</div>			 
			 <div class="yun"><img src="/static/run2/img/yun.png"></div>
			 <div class="yun2"><img src="/static/run2/img/yun.png"></div>
			
			<!--第三页游戏主页-->
			<div class="bg third"></div>
			
			<div class="radio wushi-<?php echo $pos;?>"><img src="/static/run2/img/fox.gif" /></div>
			<div class="qipao qipao-<?php echo $pos;?>"><img src="/static/run2/img/qipao2.png" /></div>
			
			
			<div class="zct">
				<img src="/static/run2/img/zct.png">
			</div>
			<div class="wyyq">
				<img src="/static/run2/img/wyyq.png">
			</div>
			
			<?php
				if($nums<20){
			?>
			<div class="tips">
				<div>当前游园进度</div>
				<div id="txt">离成功还差<?php echo 20-$nums;?>位好友支持</div>
				<div>赶快邀请好友来助威</div>
			</div>
			<?php } ?>
			
			<div class='success <?php if($nums<20){ echo "hide";} ?>'>
				<div class="success-main">
					<p>您的好友已经游园成功啦!</p>
					<p>感谢您的支持!</p>
				</div>
			</div>
			
		</div>
</div>
<input type="hidden" value="<?php echo $user_id;?>" id="user_id">
<script>
		$(function(){
			$(".zct").click(function(){
				 $.ajax( {
                    url:'/run2/run_zct',
                    data: {
                        'user_id': $("#user_id").val()
                    },
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
						if(data.code == 2){
							var nums = 0;
							var className =  "wushi-"+data.pos;
							var className2 =  "qipao-"+data.pos;
							if(data.pos<20){
								nums = 20-data.pos;
								$("#txt").html('离成功还差'+nums+'位好友支持');
							}else{
								$(".tips").hide();
								$(".success").fadeIn("slow");
							}
							
							$(".radio").addClass(className);
							$(".qipao").addClass(className2);
						}
                      $(".toast").fadeIn("slow").html(data.info);
					  setTimeout(function(){
						  $(".toast").fadeOut("slow");
					  },1500)
                    },
                    error : function() {
                    }
                });
				
				
			});
			
			$(".wyyq").click(function(){
				$(".ping-img,.close").fadeIn("slow");
			});
			$(".close").click(function(){
				$(".ping-img,.close").fadeOut("slow");
			});
			
		});
	</script>
	<?php $this->load->view('common/share_common.php')?>
	<audio src="/static/run2/img/1.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>

</body>
</html>











