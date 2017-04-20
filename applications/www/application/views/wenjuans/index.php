<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1 maximum-scale=2, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-title" content="Add to Home">
		<meta name="format-detection" content="telephone=no">
		<meta http-equiv="x-rim-auto-match" content="none">
		<title>调查问卷</title>
		<!-- 网站的ico图标 -->
		<link rel="shortcut icon" href="<?php echo $domain['statics']['url']?>/h5/images/wenjuans/favicon.jpg" type="image/x-icon">
		<link href="<?php echo get_css_js_url('wenjuans/publi.css', 'h5')?>" rel="stylesheet" type="text/css">
		<link href="<?php echo get_css_js_url('wenjuans/question.css', 'h5')?>" rel="stylesheet" type="text/css">
		<script src="<?php echo get_css_js_url('wenjuans/jquery1.8.3.min.js', 'h5')?>"></script>
		<script type="text/javascript" src="<?php echo get_css_js_url('wenjuans/vue.min.js', 'h5')?>"></script>
		<!--[if lt IE 9]>
<script src="<?php echo get_css_js_url('wenjuans/html5.js', 'h5')?>"></script>
<script src="<?php echo get_css_js_url('wenjuans/respond.min.js', 'h5')?>"></script>
<![endif]-->
		<style type="text/css">
			h2 {
				font-size: 14px;
			}
		</style>
	</head>

	<body>
		<!-- ====================================loading -->
		<!--  section id="loading"></section-->
		<!-- ====================================页面开始 -->
		<!--登录-->
		<form>
		<section class="question">
			<header class="que_head">
				<img src="<?php echo $domain['statics']['url']?>/h5/images/wenjuans/1.jpg">
			</header>
			<ul>
			    
			    <li class="que_ra que_ac">
					<h2>1您所居住的组团是？</h2>
					<label class="que1_01">
						<span>组团：</span>
						<input type="text" name="zutuan" class="chex_01">
					</label>
				</li>
				<li class="que_ra que_ac">
					<h2>2您的性别是（单选）</h2>
					<label class="que1_01">
						<input type="radio" name="sex" value="1" class="que" />
						<span>男</span>
						<img src="<?php echo $domain['statics']['url']?>/h5/images/wenjuans/qye_icon3.png">
						<i class="icon_ra"></i>
					</label>
					<label class="que1_01">
						<input type="radio" name="sex" value="0" class="que" />
						<span>女</span>
						<img src="<?php echo $domain['statics']['url']?>/h5/images/wenjuans/qye_icon4.png">
						<i class="icon_ra"></i>
					</label>
				</li>
				<li class="que_ra que_ac">
					<h2>3您的年龄（单选）</h2>
					<label class="que2_01">
						<input type="radio" name="age" value="小于10岁" class="que" />
						<span>小于10岁&nbsp;</span>
						<i class="icon_ra"></i>
					</label>
					<label class="que2_01">
						<input type="radio" name="age" value="10岁—20岁" class="que" />
						<span>10岁—20岁</span>
						<i class="icon_ra"></i>
					</label>
					<br />
					<label class="que2_01">
						<input type="radio" name="age" value="20岁—30岁" class="que" />
						<span>20岁—30岁</span>
						<i class="icon_ra"></i>
					</label>
					<label class="que2_01">
						<input type="radio" name="age" value="30-40岁" class="que" />
						<span>30-40岁</span>
						<i class="icon_ra"></i>
					</label>
					<label class="que2_01">
						<input type="radio" name="age" value="40-50岁" class="que" />
						<span>40-50岁</span>
						<i class="icon_ra"></i>
					</label>
					<label class="que2_01">
						<input type="radio" name="age" value="50岁以上" class="que" />
						<span>50岁以上</span>
						<i class="icon_ra"></i>
					</label>
				</li>
				
				<li class="que_chex que_ac">
					<h2>4哪类兴趣爱好分享活动您会感兴趣参加？（可多选）？</h2>
					<input type="checkbox" name="hobby[class][]" value="体育类" class="qu_chex" id="q1" />
					<label class="que2_01" for="q1">

						<span>体育类</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[class][]" value="文艺类" class="qu_chex" id="q2" />
					<label class="que2_01" for="q2">

						<span>文艺类</span>
						<i class="icon_chex"></i>
					</label>
					<br />
					<input type="checkbox" name="hobby[class][]" value="讲座类" class="qu_chex" id="q3" />
					<label class="que2_01" for="q3">

						<span>讲座类</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[class][]" value="生活类" class="qu_chex" id="q4" />
					<label class="que2_01" for="q4">

						<span>生活类</span>
						<i class="icon_chex"></i>
					</label>
					
					<label class="que2_01" for="q6">
						<span>其他</span>
					</label>
					<input type="text" name="hobby[class][]" class="chex_01" />
				</li>
				
				<li class="que_chex que_ac">
					<h2>5-1如果有下列活动，哪些是您希望参加的？ 体育类（可多选）</h2>
					<input type="checkbox" name="hobby[ty][]" value="足球" class="qu_chex" id="q5" />
					<label class="que2_01" for="q5">

						<span>足球</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[ty][]" value="篮球" class="qu_chex" id="q6" />
					<label class="que2_01" for="q6">

						<span>篮球</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[ty][]" value="羽毛球" class="qu_chex" id="q7" />
					<label class="que2_01" for="q7">

						<span>羽毛球</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[ty][]" value="滑轮" class="qu_chex" id="q8" />
					<label class="que2_01" for="q8">

						<span>滑轮</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="钓鱼" class="qu_chex" id="q9" />
					<label class="que2_01" for="q9">

						<span>钓鱼</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="游泳" class="qu_chex" id="q10" />
					<label class="que2_01" for="q10">

						<span>游泳</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="旅游" class="qu_chex" id="q11" />
					<label class="que2_01" for="q11">

						<span>旅游</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="登山" class="qu_chex" id="q12" />
					<label class="que2_01" for="q12">

						<span>登山</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="游泳" class="qu_chex" id="q13" />
					<label class="que2_01" for="q13">

						<span>游泳</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="跑步" class="qu_chex" id="q14" />
					<label class="que2_01" for="q14">

						<span>跑步</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[ty][]" value="自行车" class="qu_chex" id="q15" />
					<label class="que2_01" for="q15">

						<span>自行车</span>
						<i class="icon_chex"></i>
					</label>
					
				</li>
				
				<li class="que_chex que_ac">
					<h2>5-2如果有下列活动，哪些是您希望参加的？ 生活类（可多选）</h2>
					<input type="checkbox" name="hobby[sh][]" value="十字绣/手工" class="qu_chex" id="q16" />
					<label class="que2_01" for="q16">

						<span>十字绣/手工</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[sh][]" value="美食/烹饪" class="qu_chex" id="q16" />
					<label class="que2_01" for="q2">

						<span>美食/烹饪</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[sh][]" value="养生知识" class="qu_chex" id="q17" />
					<label class="que2_01" for="q17">

						<span>养生知识</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[sh][]" value="读书" class="qu_chex" id="q18" />
					<label class="que2_01" for="q18">

						<span>读书</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[sh][]" value="花艺盆景" class="qu_chex" id="q19" />
					<label class="que2_01" for="q19">

						<span>花艺盆景</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[sh][]" value="棋牌" class="qu_chex" id="q20" />
					<label class="que2_01" for="q20">

						<span>棋牌</span>
						<i class="icon_chex"></i>
					</label>
					
				</li>
				
				<li class="que_chex que_ac">
					<h2>5-3如果有下列活动，哪些是您希望参加的？文艺类（可多选）</h2>
					<input type="checkbox" name="hobby[wy][]" value="舞蹈" class="qu_chex" id="q21" />
					<label class="que2_01" for="q21">

						<span>舞蹈</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[wy][]" value="影视/音乐" class="qu_chex" id="q22" />
					<label class="que2_01" for="q22">

						<span>影视/音乐</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[wy][]" value="卡拉ok" class="qu_chex" id="q23" />
					<label class="que2_01" for="q23">

						<span>卡拉ok</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[wy][]" value="乐器演奏" class="qu_chex" id="24" />
					<label class="que2_01" for="q24">

						<span>乐器演奏</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[wy][]" value="摄影" class="qu_chex" id="q25" />
					<label class="que2_01" for="q25">

						<span>摄影</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[wy][]" value="绘画" class="qu_chex" id="q26" />
					<label class="que2_01" for="q26">

						<span>绘画</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[wy][]" value="书法" class="qu_chex" id="q27" />
					<label class="que2_01" for="q27">

						<span>书法</span>
						<i class="icon_chex"></i>
					</label>
					
				</li>
				
				<li class="que_chex que_ac">
					<h2>5-4如果有下列活动，哪些是您希望参加的？讲座类（ 可多选）</h2>
					<input type="checkbox" name="hobby[jz][]" value="养生" class="qu_chex" id="q28" />
					<label class="que2_01" for="q28">

						<span>养生</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[jz][]" value="教育"  class="qu_chex" id="q29" />
					<label class="que2_01" for="q29">

						<span>教育</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[jz][]" value="理财" class="qu_chex" id="q30" />
					<label class="que2_01" for="q30">

						<span>理财</span>
						<i class="icon_chex"></i>
					</label>
					<input type="checkbox" name="hobby[jz][]" value="风水" class="qu_chex" id="q31" />
					<label class="que2_01" for="q31">

						<span>风水</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[jz][]" value="法律" class="qu_chex" id="q32" />
					<label class="que2_01" for="q32">

						<span>法律</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[jz][]" value="家庭急救" class="qu_chex" id="q33" />
					<label class="que2_01" for="q33">

						<span>家庭急救</span>
						<i class="icon_chex"></i>
					</label>
					
					<input type="checkbox" name="hobby[jz][]" value="孕育" class="qu_chex" id="q34" />
					<label class="que2_01" for="q34">

						<span>孕育</span>
						<i class="icon_chex"></i>
					</label>
					
					<label class="que2_01">
						<span>其他：</span>
						<input type="text" name="hobby[jz][]" class="chex_01">
					</label>
					
				</li>
			</ul>
			<p class="que_ps">6 .对于未来方舟项目举办的业主活动内容，您的意见建议？</p>
			<div class="phone" style="text-align: center;">
				<textarea name="yj" style="width:80%; height:5rem;" placeholder="请输入意见"/></textarea>
			</div>
			<a href="javascript:;" id="add" class="que_receive tc">完成</a>

		</section>
		</form>
		<!-- 网站要用到的一些类库 -->

		<script type="text/javascript">
			
			var checkPhone = function(a) {
				var patrn = /^((?:13|15|18|14|17)\d{9}|0(?:10|2\d|[3-9]\d{2})[1-9]\d{6,7})$/;
				if (!patrn.exec(a)) return false;
				return true;
			};

			// ========================================浮层控制
			$("#tip .pack a").on("click", function() {
				$("#tip").fadeOut()
				$("#tip .pack p").html("")
				return false;
			})

			function alerths(str) {
				$("#tip").fadeIn()
				$("#tip .pack p").html(str)
				return false;
			}
			/*判断单选框选中状态，并且父级添加active*/
			$(".question ul .que_ra label").click(function() {
				$(this).addClass("icon_raa").siblings().removeClass("icon_raa");
				$(this).parent().addClass("active");
			});
			/*判断复选框选中状态，并且父级添加删除active*/
			$(".question ul .que_chex label").click(function() {
				if ($(this).hasClass("icon_chexa")) {
					$(this).removeClass("icon_chexa");
				} else {
					$(this).addClass("icon_chexa");
				};
				if ($(this).parent().children().hasClass("icon_chexa")) {
					$(this).parent().addClass("active");
				} else {
					$(this).parent().removeClass("active");
				};
				/*return false;*/
			})
			/*弹出框*/
			$(".que_receive").on("click", function() {
				var str = $("#iphone").val()
				var active = $(".active").length;
				if (active == 11) {
					// 判断是否全部选完
				} else {
					var ss = $('.que_ac').map(function() {
						if (!$(this).hasClass("active")) {
							return $(this).index() + 1;
						}
					}).get().join();
					alerths("请填写第" + ss + "题 完成答卷");
					return;
				};
				if (str.length == 11 && checkPhone(str)) {
					// 判断是不是11位手机号，为真提交
				} else {
					alerths("请输入正确的手机号！");
					return;
				};
				return false;
			})
			
	$('#add').on('click', function(){
	    
	    $.post('/wenjuans/add', $('form').serialize(), function(data){
	    	if(data){
	    	    if(data.code == 1){
	    	        alert(data.msg);
			    }else{
			    	alert(data.msg);
				}
			}else{
				alert('未知错误');
			}
		})
	})
		</script>
	</body>

</html>