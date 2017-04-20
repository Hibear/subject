<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="<?php echo get_css_js_url('wenjuan/reset.css', 'h5')?>" />
	<link rel="stylesheet" href="<?php echo get_css_js_url('wenjuan/toup.css', 'h5')?>" />
	<link rel="stylesheet" href="<?php echo get_css_js_url('wenjuan/swiper.min.css', 'h5')?>">
	<script src="<?php echo get_css_js_url('wenjuan/jquery-1.11.3.js', 'h5')?>"></script>
	<script src="<?php echo get_css_js_url('wenjuan/fontSize.js', 'h5')?>"></script>
	<title>调查问卷</title>
</head>
<body>	
	<section class="toup" id="t2">
	    <from>
		<div class="swipers">
		<!-- 上下 -->
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<div class="scores">
						<h3>您的性别是？</h3>
						<div class="f"><span>1</span>请勾选您的性别</div>
						<div class="choose">
							<div class="input"><input status="1" type="radio" name="sex" value="1" /><label for="6"> 男士</label></div>
							<div class="input"><input status="1" type="radio" name="sex" value="0" /><label for="7"> 女士</label></div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>您的年龄:？</h3>
						<div class="f"><span>2</span>请选择年龄</div>
						<div class="choose">
							<div class="input"><input status="1" type="radio" name="age" value="小于10岁" /><label for="11">小于10岁 </label></div>
							<div class="input"><input status="1" type="radio" name="age" value="10-20岁" /><label for="11">10-20岁 </label></div>
							<div class="input"><input status="1" type="radio" name="age" value="20-30岁" /><label for="11">20-30岁 </label></div>
							<div class="input"><input status="1" type="radio" name="age" value="30-40岁" /><label for="11">30-40岁 </label></div>
							<div class="input"><input status="1" type="radio" name="age" value="小于10岁" /><label for="11">40-50岁 </label></div>
						    <div class="input"><input status="1" type="radio" name="age" value="小于10岁" /><label for="11">50岁以上 </label></div>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>哪类兴趣爱好分享活动您会感兴趣参加？（可多选）？</h3>
						<div class="f"><span>3</span>请选择</div>
						<div class="choose" style="font-size:15px">
							<label><input  type="checkbox" name="hobby_class[]" value="体育类">体育类</label>
							<label><input  type="checkbox" name="hobby_class[]" value="生活类">生活类</label>
							<label><input  type="checkbox" name="hobby_class[]" value="文艺类">文艺类</label>
							<label><input  type="checkbox" name="hobby_class[]" value="讲座类">讲座类</label>
							其他：<input type="text" name="hobby_class[]"> 
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>如果有下列活动，哪些是您希望参加的？（可多选）</h3>
						<div class="f"><span>4-1</span>体育类</div>
						<div class="choose" style="font-size:15px">
						    <label><input  type="checkbox" name="hobby[ty][]" value="足球">足球</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="篮球">篮球</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="羽毛球">羽毛球</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="滑轮">滑轮</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="钓鱼">钓鱼</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="游泳">游泳</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="旅游">旅游</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="跑步">跑步</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="登山">登山</label>
							<label><input  type="checkbox" name="hobby[ty][]" value="自行车">自行车</label>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>如果有下列活动，哪些是您希望参加的？（可多选）</h3>
						<div class="f"><span>4-2</span>生活类</div>
						<div class="choose" style="font-size:15px">
						    <label><input  type="checkbox" name="hobby[sh][]" value="十字绣/手工">十字绣/手工 </label>
							<label><input  type="checkbox" name="hobby[sh][]" value="美食/烹饪">美食/烹饪 </label>
							<label><input  type="checkbox" name="hobby[sh][]" value="养生知识">养生知识</label>
							<label><input  type="checkbox" name="hobby[sh][]" value="读书">读书</label>
							<label><input  type="checkbox" name="hobby[sh][]" value="花艺盆景">花艺盆景</label>
							<label><input  type="checkbox" name="hobby[sh][]" value="棋牌">棋牌</label>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>如果有下列活动，哪些是您希望参加的？（可多选）</h3>
						<div class="f"><span>4-3</span>文艺类</div>
						<div class="choose" style="font-size:15px">
						    <label><input  type="checkbox" name="hobby[wy][]" value="舞蹈">舞蹈</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="影视/音乐">影视/音乐</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="卡拉ok">卡拉ok</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="乐器演奏">乐器演奏</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="摄影">摄影</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="绘画">绘画</label>
							<label><input  type="checkbox" name="hobby[wy][]" value="书法">书法</label>
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>如果有下列活动，哪些是您希望参加的？（可多选）</h3>
						<div class="f"><span>4-4</span>讲座类</div>
						<div class="choose" style="font-size:15px">
						    <label><input  type="checkbox" name="hobby[jz][]" value="养生">养生</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="教育">教育</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="理财">理财</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="风水">风水</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="法律">法律</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="家庭急救">家庭急救</label>
							<label><input  type="checkbox" name="hobby[jz][]" value="孕育">孕育</label>
							其他：<input type="text" name="hobby[jz][]"> 
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="scores">
						<h3>对于未来方舟项目举办的业主活动内容，您的意见建议？</h3>
						<div class="f"><span>5</span>请填您的宝贵意见</div>
						<div class="choose">
							<textarea style="width:100%;height:3rem" name="yj"></textarea>
							<input type="text" placeholder="您的组团" style="width:100%;" name="zt"/>
						</div>
					</div>
				</div>
			</div>
			<div class="preNexts">
				<div class="swiper-button-prev"><div class="pre"></div>上一题</div>
				<div class="swiper-button-next"><div class="next"></div>下一题</div>
			</div>
		</div>
		<!-- 上下end -->
		</div>
		<from>
	</section>
	<section class="toup" id="t3">
		<!-- <div class="logo">
			<img src="images/logo.png"/>
		</div> -->
		<div class="swipers" style="text-align: center;">
			<div class="con con1">
				<div class="smile">
					<p>非常感谢您的配合!</p>
				</div>
			</div>
			<button id="add" href="javascript:;" class="tijiao" style="padding: 0.1rem;">提交调查</button>
		</div>
	</section>
	
	<script src="<?php echo get_css_js_url('wenjuan/swiper.min.js', 'h5')?>"></script>
	<script>
	
		var mySwiper  = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: true,
		onReachEnd: function(swiper){
			$("#t2").hide();
			$("#t3").show();
		}
    });

		
		$(function(){
			$("#t2").show();
			$("#t3").hide();
	    })   

	$(".swiper-container label,.swiper-container input").click(function(){
		var status = $(this).attr('status');
		//
		if(status == 1){
			var this_active = $(this).parents(".swiper-slide").index();
			setTimeout(function(){
				mySwiper.slideTo(this_active+1,1000)
			},500);
	    }else{
	        return;
		}
 });
	$('.swiper-button-next').click(function(){
		if(mySwiper .isEnd){
			$("#t2").hide();
			$("#t3").show();
		}
	})
	
	$('#add').on('click', function(){
	    var data = $("form").serialize();
	    $.post('/wenjuan/add', 'post': data, function(data){
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