<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>报名窗口</title>
<style>
html{width:100%;
     height:100%}
body,input,button{font:normal 14px "Microsoft Yahei";margin:0;padding:0}

.odform{padding:5%; padding-top:45%;}
.input-group{margin-bottom:9%;position:relative}
.input-group label{padding:2% 0;position:absolute;color:#d3b366}
.input-group input{margin-left:5em;padding:3% 5%;box-sizing:border-box;background:#efeff0;border:0;border-radius:5px;color:#595757;width:75%}
.odform button{background:#d3b366;color:#fff;text-align:center;border:0;border-radius:10px;padding:3%;width:100%;font-size:16px}
.odform .cal{background-image:url(images/daetixian-cal.png);background-repeat:no-repeat;background-position:95% center;background-size:auto 50%}
.odform .xl{background-image:url(images/daetixian-xl.png);background-repeat:no-repeat;background-position:95% center;background-size:auto 20%}
.con{ 
	position: fixed;
    width: 100%;
    height: 100%;
    z-index: 55;
    top: 0;
    left: 0;
    bottom: 0;
    background: #000; 
	z-index:-1;
 }
 .tips {
		position: fixed;
		z-index: 50000;
		width: 12.6em;
		height: 3.6em;
		top: 224px;
		left: 43%;
		margin-left: -3.8em;
		background: rgba(40,40,40,.75);
		text-align: center;
		border-radius: 5px;
		color: #fff;
		line-height: 3.6em;
		font-size: 12px;
   }
i{ font-style:normal;} 
 .con img{ width:100%; height:100%;vertical-align:middle;}
body{background: url(/static/fireworks/img/bmbg.jpg) no-repeat; background-size:100% 100% !important;   width:100%; 
    height:100%;}
</style>
</head>

<body>
<div class="odform">
	<div class="input-group">
			<label for="khname">客户姓名</label>
			<input type="text" id="name" placeholder="请输入您的姓名">
	</div>
	<div class="input-group">
		<label for="khname">手机号码</label>
		<input type="text" id="tel" placeholder="请输入您的手机号码">
	</div>
		
		<button id="btn">马上报名</button>
</div>
 <script type="text/javascript" src="<?php echo css_js_url_v2('jquery.min.js', 'fireworks');?>" ></script>
 
 <?php $this->load->view('common/share_weixin.php')?>
 <script>
   $(function(){
	   $("#btn").click(function(){
        var name = $("#name").val();
        var tel = $("#tel").val();
       if(name == ''){
            tisp("姓名不能为空！");
            $('input[name="name"]').focus();
            return false;
        }

        if(tel == ''){
			tisp("电话不能为空！");
            $('input[name="tel"]').focus();
            return false;
        }

        var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
        if(!isMobile.test(tel)){
			 tisp("电话号码格式不正确！");
			 $('input[name="tel"]').focus();
            return false;
        }
     
       $.post("/fireworks/baoming",{name:name,tel:tel},function(txt){
			if(txt > 0){
              tisp("提交成功");
              $("#info").hide();
			}else{
				 tisp("提交失败,请重新提交");
			}
        });

    });
	function tisp(info){
		$("#toast").show();
		 $(".toast-info").html(info);
		  setTimeout(function () {
			 $('#toast').hide();
		}, 5000);
	}    
   });
 
 </script>
</body>
</html>
