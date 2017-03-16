<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>恭祝元宵</title>
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
		<link rel="stylesheet" href="/static/happynewyear/css/style.css" />
		<script type="text/javascript" src="/static/happynewyear/js/jquery.min.js" ></script>
		<?php 
			if($id == 1) {
				$imgurl = "/static/happynewyear/img/bg3.jpg";
			} else {
				$imgurl = "/static/happynewyear/img/bg4.jpg";
			}
		?>
		<style>
			body{ 
				background: url(<?php echo $imgurl;?>) no-repeat;
				background-size: 100% 100% !important; 
			}
			.getred {
				width: 100%;
				height: 150px;
				margin-top: 70%;
			}
		</style>
	</head>
	<body>
		<div class="getred"></div>
		<script type="text/javascript" src="/static/happynewyear/js/style.js" ></script>
		<script>
			var id = "<?php echo $id;?>";
			$(".getred").click(function(){
				$.ajax( {
					url:'/happynewyear/add_user',
					data: {
						id: id
					},
					type:'POST',
					dataType:'json',
					success:function(data) {
						alert(data.info);
					},
					error : function() {
						alert("网络异常");
					}
				});
			});
		 
		</script>
		<?php $this->load->view('common/share_common.php')?>
	</body>
</html>
