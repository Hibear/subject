<!DOCTYPE html>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="yes" name="apple-touch-fullscreen">
	<meta content="telephone=no" name="format-detection">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport">
	<title>拼图领取门票</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $domain['www_static']['url'];?>/puzzle/css/index1.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $domain['www_static']['url'];?>/puzzle/css/ui-dialog.css">
	<style type="text/css">
		.mask{
			position:absolute;
			z-index:99;
			background-color:black;
			top:0px;
			left:0px;
			width:100%;
			height:100%;
			opacity:.8;
			display:none;
		}
		#gameresult{
			position:absolute;
			z-index:100;
			top:30%;
			left:0%;
			width:100%;
			height:100%;
			display:none;
		}
		.resultcontainer{
			width:80%;
			margin:auto;
			color:white;
			text-align:center;
			padding:20px;
		}
		.resultinfo{
			margin-bottom:40px;
			font-size:20px;
		}
		.resultinfo em{
			color:red;
		}
		.btngroup{
			height:60px;
		}
		.btn1{
			padding:8px 15px;
			background-color:#1a1c29;
			border-radius:5px;
		}
		.hide{
			display:none;
		}
		.kapics{
			text-align:center;
		}
		
		.btn-into {
			background: #8ec31f;
			color: #fff;
			border: 0;
			border-radius: 10px;
			padding: 3%;
			width: 60%;
			font-size: 16px;
		}
	</style>
</head>
<body>
	<!--页面集合-->
	<div id="pageWrapper">
		<div class="drag-content">
			<div class="play-container">
				<?php if($is_win == 1):?>
				<div class="drag-box"> 
					<p style="font-size:18px; font-weight:bolder">领取戏票成功！</p>
					<p style="margin: 14px; line-height: 30px; text-align: left">
						恭喜您闯关成功，这是您获得的方舟戏台88元戏票，可享受免费看戏、茗茶一杯，看戏前请提前电话预约座位，预约热线：0851-85206607 
					</p>
					<p>
						<img src="<?php echo $domain['www_static']['url'];?>/puzzle/images/xipiao1.png" style="width:100%;"/>
						<img src="<?php echo $domain['www_static']['url'];?>/puzzle/images/xipiao2.png" style="width:100%;"/>
					</p>
				</div>
				<?php else:?>
				<div class="drag-box"> 
					<p style="font-size:18px; font-weight:bolder">游戏规则</p>
					<p style="margin: 14px; line-height: 30px; text-align: left;">
						本次拼图游戏共有三次机会，系统设有十张图片，每次进入游戏系统会从十张图片中随机抽取三张进行拼图，拼图之前您可预览整张图效果，点击开始按钮后开始倒计时拼图，在限定时间内成功拼出一张后方可进入下一张，凡拼错者又从本关开始第二次机会，若三次机会均用完还尚未成功者，则需等二天恢复机会才可重新进行游戏，成功拼出三张者即可获得门票。
					</p>
					<p>
						<button class="btn-into">进入游戏</button>
					</p>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $domain['www_static']['url'];?>/puzzle/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $domain['www_static']['url'];?>/puzzle/js/dialog.js"></script>
	
	<script>
		$(".btn-into").click(function(){
			$(this).attr('disabled',true);
			$.post('/puzzle/validate_user',{}, function(result){
				if(result.flag) {
					window.location.href = "/puzzle/game";
				} else {
					artDialog(result.msg);
				}
				$(this).removeAttr('disabled');
			});
		});

		function artDialog(info){
			var d = dialog({
				title: '信息提示',
				content: info,
				okValue: '确定',
				ok: function () {}
			});
			d.width(250);
			d.height(20);
			d.showModal();
		}
	</script>
</body>
</html>