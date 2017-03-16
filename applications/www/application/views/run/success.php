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
<script type="text/javascript" src="<?php echo css_js_url_v2('jquery.js', 'run');?>"></script>
<style>
	#wrap{ 
		background: url(/static/run/img/bg/02BG.jpg) no-repeat;
		background-size: cover;
		background-size: 100% 100%;
		}
	.header{ width: 100%; -webkit-box-flex: 2;box-flex: 2;}
	.txt-input{
		-webkit-box-flex: 1; 
		box-flex: 1;
       	width: 100%;
       	font-family: "微软雅黑";
       	font-size: 0.875rem;	
	}
	
	.txt-input input{ width: 60%; height: 40px; margin-bottom: 10px;box-shadow: 1px 1px 10px #888888 ;
	-webkit-box-shadow: 1px 1px 10px #888888 ; border-radius: 4px; padding-left: 6px;}
	.tijiao{width: 5.625rem; height: 2.875rem; }
	.tj-bg{ width: 100%; z-index: -1; display: none; height: 100%; position: absolute; left: 0; top: 0; background: url(/static/run/img/bg/0.3bg.jpg) no-repeat; background-size: 100% 100%;}		
    .hide{display: block;}
</style>
<script>
	window.onload=function(){
		$(".loading").fadeOut("slow");}
</script>

</head>

<body>
	
	<div class="loading">
	<div id="caseGrise">
	<div id="loadprogress">
	<div id="charge"></div>
	</div>
	<div id="load">
	<p>页面加载中···</p>
	</div>
	</div>
	</div>

	
	<div id="wrap">
		<div class="dialog">亲，来晚了供暖优惠券已送完了</div>
		<div class="tj-bg hide" ></div>
		<div class="header hide"></div>
		<div class="txt-input hide">
			<p><input type="text" placeholder="姓名" id="name" value=""></p>
			<p><input type="text" placeholder="电话" id="tel" value=""></p>
			<p><img src="/static/run/img/button/tijiao.png" class="tijiao" /></p><br /><br />
			<p>此信息为领奖的唯一凭证，请认真填写</p><br /><br />
			<p>领奖时间：11月16日—11月30日</p>
			<p>领奖地址：贵阳市云岩区未来方舟销售中心领取</p>
		</div>



  		
	</div>
	<script>
		$(function(){
			
			$(".tijiao").click(function(){
				var name = $("#name").val();
				var tel = $("#tel").val();
				var isMobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/;  
				if(name ==""){
					dialog("姓名不能为空");	
					$("#name").focus();
					return false;
				}
				
				if(tel ==""){
					dialog("电话不能为空");	
					$("#tel").focus();
					return false;
				}
				
				
				//如果为1开头则验证手机号码  
                if (!isMobile.exec(tel) && tel.length != 11) {  
                    dialog("请填写正确的联系方式");	 
                    $("#tel").focus();  
                    return false;  
                }  
            
				
				 $.ajax( {
                    url:'/run/update_users',
                    data: {
                        'name': name,
                        'tel': tel
                    },
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
					 dialog(data.info);
                    },
                    error : function() {
                    }
                });
			});
			
			function dialog(info){
				$(".dialog").fadeIn("slow").html(info);
				 setTimeout(function(){
				  $(".dialog").fadeOut("slow");
			    },2000);
			}
		});
	</script>
	<?php $this->load->view('common/share_common.php')?>
<audio src="/static/run2/img/1.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>
</body>
</html>











