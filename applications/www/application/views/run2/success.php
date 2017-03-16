<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">
<title>提交用户信息</title>
<link rel="stylesheet" href="/static/run2/css/style.css" />
<style>
.toast{ display:none;font-size:0.5rem}
#main{ display:none}
.bg{ background: url(/static/run2/img/tijiaobg.jpg);}
.submit{ width: 30%; left: 35%;  position: absolute;  bottom: 10%;}
.submit img{ width: 100%;}
#su{ font-size: 0.4rem; width: 70%; left: 15%; top: 35%; position: absolute; z-index: 9999;}
#su input{ height: 40px; width: 100%; margin-top: 10px; line-height: 40px; padding-left: 10px; box-sizing: border-box; border-radius: 4px;}
</style>
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
   
    <div class="toast"></div>
    <div id="wrap">
    	
		<div id="main" >
			<div id="su">
    			<p><input type="text" id="name" placeholder="姓名:"></p>
    			<p><input type="text" id="tel" placeholder="电话:"></p>
    			<input type="hidden" value="<?php echo $token;?>" id="token">

    		</div>
			<div class="bg"></div>
			<div class="submit"><img src="/static/run2/img/submit.png" /></div>
		</div>
	</div>
<?php $this->load->view('common/share_common.php')?>
<script>
	$(function(){
	  $(".submit").click(function(){
                var tel = $("#tel").val();
                var name = $("#name").val();
                var token = $.trim($("#token").val());
				var isMobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/; 
				if(name == ""){
					$(".toast").fadeIn("slow").html("姓名不能为空");
					  setTimeout(function(){
						  $(".toast").fadeOut("slow");
					  },1000);
					return false;
				}
				//如果为1开头则验证手机号码  
                if (!isMobile.exec(tel) && tel.length != 11) {  
                   $(".toast").fadeIn("slow").html("请输入正确电话号码");
					  setTimeout(function(){
						  $(".toast").fadeOut("slow");
					  },1000);		
                    $("#tel").focus();  
                    return false;  
                }  
				
                $.ajax( {
                    url:'/run2/update_users',
                    data: {
                        'name': name,
                        'tel':tel,
                        'token':token
                    },
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
                      $(".toast").fadeIn("slow").html(data.info);
					  setTimeout(function(){
						  $(".toast").fadeOut("slow");
					  },1000);
                    },
                    error : function() {
						alert("网络异常");
                    }
                });
            });
	 
	});
</script>
</body>
</html>











