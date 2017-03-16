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
		
		.baoming {
			margin-top: 40px;
		}
		
		.baoming ul {
			list-style: none;
			width: 100%;
			height: 100%;
		}
		
		.baoming li {
			height: 44px;
			width: 100%;
			color: #9a774f;
			font-size: 1.2rem;
			font-family: 微软雅黑;
			text-align: center;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			margin-bottom: 8px;
		}
		
		.baoming .input-group label {
			padding: 2% 0;
			position: absolute;
			color: #595757;
		}
		
		.baoming .input-group input {
			margin-left: 5em;
			padding: 3% 5%;
			box-sizing: border-box;
			background: #efeff0;
			border: 0;
			border-radius: 5px;
			color: #595757;
			width: 75%;
		}
		
		.baoming button {
			margin-left: 15%;
			background: #8ec31f;
			color: #fff;
			text-align: center;
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
				<div class="drag-box get-success" style="display: none"> 
					<p style="font-size:18px; font-weight:bolder">领取戏票成功！</p>
					<p style="margin: 14px; line-height: 30px; text-align: left">
						恭喜您闯关成功，这是您获得的方舟戏台88元戏票，可享受免费看戏、茗茶一杯，看戏前请提前电话预约，预约热线：0851-85206607
					</p>
					<p>
						<img src="<?php echo $domain['www_static']['url'];?>/puzzle/images/xipiao1.png" style="width:100%;"/>
						<img src="<?php echo $domain['www_static']['url'];?>/puzzle/images/xipiao2.png" style="width:100%;"/>
					</p>
				</div>
				<div class="drag-box get-ticket"> 
					<p style="font-size:28px; font-weight:bolder">领取门票</p>
					<p style="margin: 14px; line-height: 30px;">
						请如实填写您的姓名和手机号码
					</p>
					<div class="baoming">
						<ul>
							<li>
								<div class="input-group">
									<label for="khname">姓名</label>
									<input type="text" id="user_name" name="user_name" placeholder="请输入您的姓名">
								</div>
							</li>
							<li>
								<div class="input-group">
									<label for="khname">电话</label>
									<input type="text" id="phone_number" name="phone_number" placeholder="请输入您的手机号码">
								</div>
							</li>
							<li><button id="btn">提交</button></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="<?php echo $domain['www_static']['url'];?>/puzzle/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo $domain['www_static']['url'];?>/puzzle/js/dialog.js"></script>
<script>
	$("#btn").click(function(){
        var user_name = $("input[name='user_name']").val();
        var phone_number = $("input[name='phone_number']").val();
		
        if(user_name == ''){
            artDialog("中文姓名不能为空！");
            $('input[name="user_name"]').focus();
            return false;
        }

        if(phone_number == ''){
            artDialog("手机号不能为空");
            $('input[name="phone_number"]').focus();
            return false;
        }

        var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
        if(!isMobile.test(phone_number)){
            artDialog("手机号码格式不正确！");
            $('input[name="tel"]').focus();
            return false;
        }  

        $.post("/puzzle/save_userinfo",{user_name:user_name,phone_number:phone_number},function(result){
			if(result.flag){
				$(".get-ticket").hide();
				$(".get-success").show();
			} else {
				artDialog(result.msg);
			}
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