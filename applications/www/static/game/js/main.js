// 背景音乐配置
var bgm_music = new Bgm({
	bgm:"/static/game/images/bgm.mp3",
	close:"/static/game/images/music_close.png",
	open:"/static/game/images/music_open.png",
	className:"bgmClass"
})
// 弹出层通用js
$('.close').on("touchstart",function(){
	$(this).parents('.pop').hide();
})
manifest = [
	{src: "chongkai.png", class: "chongkai"},
	{src: "rule.png", class: "rule"},
	{src: "phtitle.png", class: "phtitle"},
	{src: "starttu.png", class: "starttu"},
	{src: "ruletu.png", class: "ruletu"},
	{src: "phtu.png", class: "phtu"},
	{src: "bomtu.png", class: "bomtu"},
	{src: "phdi.png", class: "phdi"},
	{src: "logo.png", class: "logo"},
	{src: "cuo.png"},
	{src: "dengji.jpg"},
	{src: "dui.png"},
	{src: "heng1.png"},
	{src: "heng2.png"},
	{src: "heng3.png"},
	{src: "heng4.png"},
	{src: "heng5.png"},
	{src: "music_open.png"},
	{src: "music_close.png"},
	{src: "Qbg.png"},
	{src: "shu1.png"},
	{src: "shu2.png"},
	{src: "shu3.png"},
	{src: "shu4.png"},
	{src: "shu5.png"},
	{src: "sure.png"},
]
load(manifest,function(){
	$("#loading").hide()
})









Aresult = ["2","0","1","7","年","七","许","未","来"];
resa = ["2","0","1","7","年","七","许","未","来"];

Bresult = ["3.0","精","工","时","代","即","将","启","幕"];
resb = ["3.0","精","工","时","代","即","将","启","幕"];

Eresult = ["方","舟","修","人","文","以","润","繁","华"];
rese = ["方","舟","修","人","文","以","润","繁","华"];

Dresult = ["让","生","活","还","原","本","来","面","貌"];
resd = ["让","生","活","还","原","本","来","面","貌"];

Fresult = ["城","市","从","未","如","此","立","体","。"];
resf = ["城","市","从","未","如","此","立","体","。"];

Cresult = ["每","一","次","跨","越","都","是","新","生"];
resc = ["每","一","次","跨","越","都","是","新","生"];

// 时间状态
var gotime = true;
// 点击顺序
var order = 0;
// 答题数目
var times = 0;

// 重置魔方状态
function reset() {
	order = 0;
	$(".que p").unbind("touchstart");
	$(".que p").css({
		"color": "#000",
		"background-color": "#fff"
	});
	$(".res span").css({
		"color": "#000",
	})
}
// 随机排序数组
function randomArr(arr){
	for(var i = 0; i < arr.length ; i++){
		var a = Math.floor(Math.random()*(arr.length));
		var b = Math.floor(Math.random()*(arr.length));
		// 交换
		var c = arr[a];
		arr[a] = arr[b];
		arr[b] = c;
	}
	console.log(arr);
}
// 传字符串到每个问题的对应格子
function putString(arr) {//传入对应的目标和随机值的数组
	randomArr(arr);
	$(".que p").each(function (i) {
		// $(this).attr("src","images/"+arr[i]);
		$(this).text(arr[i]);
	})
}
// 显示标准顺序
function result(res) {//传入对应的目标和随机值的数组
	$(".res span").each(function (i) {
		$(this).text(res[i]);
	})
}
// 计时
function time(){
	stime();
	init = 0;
	timer = setInterval(function(){
		init ++;
		if(init < 10){
			$(".time").text("000"+init);
		}else if(9 < init && init < 100){
			$(".time").text("00"+init);
		}else if(99 < init && init < 1000){
			$(".time").text("0"+init);
		}else if(999 < init && init < 10000){
			$(".time").text(init);
		}else{
			clearInterval(timer);
			alert("你故意等着时间到的？别闹好么！")
		}
	}, 1000)
}
// 判断点击的顺序是否正确
function check(arr,res,ani,callback){
	reset()
	// 答题次数
	times++;
	$(".dijiti").text("——第"+ times + "/6关——")
	// 首先随机传入字符到页面
	putString(arr);
	// 显示结果
	result(res);
	// 给所有选项绑定点击事件
	$(".que p").on("touchstart",function(){
		
		$(this).unbind("touchstart");
		// 获取点击的值和答案的值
		var qtxt = $(this).text(), atxt = $(".res span").eq(order).text();
		// 开始计时
		if(gotime){
			time();
			gotime = false;
		}
		// 点击对错
		if(qtxt == atxt){
			$(this).css({
				"color": "#fff",
				"background-color": "#4eb853"
			});
			$(".res span").eq(order).css({
				"color": "#4eb853",
			})
		}else{//点错
			$(this).css({
				"background-color": "red"
			});
			$(".res span").eq(order).css({
				"color": "red",
			});
			$(".cuowu").show();
		}
		// 点击顺序
		order ++;
		if(order == arr.length){
			if(times >= 6){
				callback();
				return false;
			}else{
				palyAni(ani);
				reset();
			}
			callback();
		}
	})
	// 判断数组长度，为8解绑中间位置点击事件
	if(arr.length == 8){
		$(".que p").eq(4).unbind("touchstart");
		// 不满9格，替换中间值
		replace();
	}
	
}
// 横向动画隐藏页面
function hengAni(){
	$(".heng").fadeIn(0);
	setTimeout(function () {
		$(".heng").hide();
	}, 1500)
}
function shuAni(){
	$(".shu").fadeIn(0);
	setTimeout(function () {
		$(".shu").hide();
	}, 1500)
}
// 不满九位数，替换第五位到最后一位
function replace(){
	var txt = $(".que p").eq(4).text();
	$(".que p").eq(4).text("");
	$(".que p").eq(8).text(txt);
	$(".res span").eq(8).text("");
}
// 播动画，参数是动画类型
function palyAni(ani) {
	$(".page").fadeOut(0,function(){
		// 播动画
		ani();
		// 延时显示page2
		setTimeout(function () {
			$(".page2").show();
		}, 1500)
	});
}
// 开始游戏按钮
$(".start").on("touchstart",function () {
	$(".stime").show();
	$(".time").text("0000");
	palyAni(hengAni)
	check(Aresult,resa,hengAni,function () {
		check(Bresult,resb,hengAni,function () {
			check(Cresult,resc,hengAni,function () {
				check(Dresult,resd,shuAni,function () {
					check(Eresult,rese,shuAni,function () {
						check(Fresult,resf,shuAni,function () {
							clearInterval(stimer);
							clearInterval(timer);
							// 全部答对
                            recordScore(init+"."+sinit);
						});
					});
				});
			});
		});
	});

})
// 重新开始
function restart() {
	window.location.reload();
}
$(".sure").on("touchstart",function () {
	$(".cuowu").hide();
	restart();
});
// 规则弹出层开
$(".ruleBtn").on("touchstart",function () {
	$(".rulepop").show();
})
// 规则弹出层关闭
$(".guan").on("touchstart",function () {
	$(".rulepop").hide();
});
$(".djguan").on("touchstart",function () {
	$(".rulepop").hide();
})
// 排行弹出层关闭
$(".chaph").on("touchstart",function () {
	window.location.reload();
})
// 排行弹出层开
$(".phBtn").on("touchstart",function () {
	$(".paihpop").show();
	$('#joinlist').html('<img src="/static/game/images/mofang.png" class="mofang">');
	$.get('/game/getrank', function(data) {
		if(data){
			if(data.code == 1){
				var html = ''
				$.each(data.info, function(i, v) {
					html +='<ul style="width: 5.5rem">';
                	html +='<li style="100%;height: 0.5rem; text-align: center; font-size: 0.4rem;margin-top: 0.1rem;">';
                    html +='<div style="float: left; width: 1.83rem;">No.'+(i+1)+'</div>';
                    if(v.name && v.name != ''){
                    	html +='<div style="float: left; width: 1.83rem;">'+v.name+'</div>';
                    }else{
                    	html +='<div style="float: left; width: 1.83rem;">匿名用户</div>';
                    }
                    html +='<div style="float: left; width: 1.83rem;">'+v.game_time+'"</div>';
                	html +='</li>';
            		html +='</ul>';
            		$('#joinlist').html('');
            		$('#joinlist').html(html);
				});
				if(data.my_info != -1){
					$('#has_rank').show();
					var myrank = parseInt(data.my_info)+1;
					$('#myrank').text(myrank);
				}else{
					$('#no_rank').show();
				}
			}
		}else{
			alert('网络异常');
		}
	});
})
// 确认弹出层开
$(".queren").on("touchstart",function () {
	 $('.zhengque.pop').hide();
	 var status = $('.djBg.pop').attr('status');
	 if(status == 1){
	 	$('.djBg.pop').show();
	 }
	 
})
//提交用户信息
$('.tijiao.t_center').on('touchstart', function(){
	var username = $('#name').val();
	var tel = $('#tel').val();
	if(!username || username == ''){
		alert('请输入您的姓名');
		return false;
	}
	if(!tel || tel == ''){
		alert('请输入您的手机号');
		return false;
	}
	$.post('/game/update_user', {'name':username,'tel':tel}, function(data){
		if(data){
			if(data.code == 0){
				alert(data.msg);
				return false;
			}else{
				window.location.reload();
			}
		}else{
			alert('网络异常！');
		}
	})
});

//关闭登记
$('.cha.djguan').on("touchstart",function () {
	$('.djBg.pop').hide();
})

$(".phBtn").on("touchstart",function () {
})
// 错误弹出层关
$(".cuowuch").on("touchstart",function () {
	window.location.reload();
})
sinit = 0;
function stime(){
	stimer = setInterval(function(){
		sinit ++;
		if(sinit < 10){
			$(".stime").text("0"+sinit);
		}else if(sinit < 100){
			$(".stime").text(sinit);
		}else{
			sinit = 0;
		}
	}, 10)
}
