<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>2016腾讯房产年度盛典现场抽奖</title>
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
			
		<link href="<?php echo css_js_url('bootstrap.min.css', 'admin');?>" rel="stylesheet" />
		

		<style>  
            body{  
                background-position: center;  
                background-repeat: no-repeat;  
                background-attachment: fixed;  
            }  
            .demo{width:800px; margin:20px auto;height:500px;position: relative;padding: 3% 0;}  
            #roll{padding: 3% 0;}   
            .h1{font-size:4em;  color: #ffb400;margin-bottom: 10px;}  
            .col-sm-3{ font-size:3.8em; color: #fff;}  
            .col-sm-12{ font-size:4em; color: #fff; line-height: 2em;}  
            .huge{font-size:8em; margin-top: 60px;}  
              
            #save, #clear{color: #fff;font-size:1.5em; }  
            #stop{display:none;color: red;}   
            #result{margin-top:20px; line-height:24px; font-size:16px; text-align:center}   
            .label{color:#fff;}  
        </style>  
	</head>
	<body style="width:100%; height:100%; background: black">
		<?php $this->load->view('/Choujiang/header');?>
		<div class="container-fluid">  
	        <div class="demo">  
	            <h1 class="center h1">2016腾讯房产年度盛典现场抽奖</h1>  
	            <div id="roll">  
	            	<div class="form-group">  
	                    <h1 style="color:#fff">抽取奖项</h1>  
	                    <select class="form-control" name="form[level]" required>  
	                    	<option value="5">五等奖</option>
	                    	<option value="4">四等奖</option>
	                    	<option value="3">三等奖</option>
	                    	<option value="2">二等奖</option>
	                    	<option value="1">一等奖</option>
	                    </select>
	                </div>
	                <div class="form-group">  
	                    <h1 style="color:#fff">抽奖个数</h1>  
	                    <input type="text" class="form-control" name="form[num]" value="5" required>  
	                </div>  
	                <div class="form-group">  
	                    <h1 style="color:#fff">起始编号</h1>  
	                    <input type="text" class="form-control" name="form[min]" value="1" required>  
	                </div>  
	                <div class="form-group">  
	                    <h1 style="color:#fff">截止编号</h1>  
	                    <input type="text" class="form-control" name="form[max]" value="350" required>  
	                </div>  
	                <div class="form-group mt40">  
						<div class="col-sm-6" style="padding-left: 0">
							<a href="javascript:;" type="button" class="btn btn-warning btn-lg btn-block" id="save"> 确认保存进入抽奖页面</a>  
						</div>
						<div class="col-sm-6" style="padding-right: 0">
							<a href="javascript:;" type="button" class="btn btn-danger btn-lg btn-block" id="clear"> 清空所有中奖数据</a>
						</div>
	                </div>  
	            </div>  
	        </div> 
	    </div>
		<script type="text/javascript" src="/static/naoxinchun/js/jquery.min.js" ></script>
		<script type="text/javascript">
			$(function() {  
				var prize_level = JSON.parse('<?php echo $prize_level;?>');
				var prize_name = JSON.parse('<?php echo $prize_name;?>');

                $('#save').on('click', function() {  
                    var level = $('select[name="form[level]"]').val();  
                    var num = $('input[name="form[num]"]').val();  
                    var min = $('input[name="form[min]"]').val();  
                    var max = $('input[name="form[max]"]').val(); 

                    if (num > prize_level[level]) {
                    	alert(prize_name[level] + "最大抽奖个数不能超过" + prize_level[level]);
                    	return false;
                    }

                    location.href = "/Choujiang/prize?level="+level+"&num="+num+"&min="+min+"&max="+max;//jquery实现页面的跳转和参数传递  
                });   
				
				//清空已中奖
				$("#clear").click(function(){
					if(!confirm('清空后不可恢复，请谨慎操作！您确定清空所有中奖数据吗？')){
						return false;
					}
					window.location.href = "/choujiang/clearprize";
				});
            });   
		</script>
	</body>
</html>
