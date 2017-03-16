$(function(){
	//实现首页头部进入动画
	 $(".home-head").animate({top:'0px'},1000);
	// $(".btn-start").addClass("hover");
	
	 
	 //挠一挠动画
	 var percent = 0;
	 var time = 17000;
	 var i = 0; 
	 var isStart = 0;
	 var intval;
	 $("#btn").click(function(){
	 	if(isStart == 0){
			isStart = 1;
		}
		
		
	 	var pro = parseInt($(".progress").css("padding-top"));
	 	var height =  parseInt($(".progress").css("height"));
	 
	 	var gameHeight =  parseInt($(".pro-color").css("height"));
	 	
	 	var  perTxt=  parseInt($("#per").html());
	 	
	 	//判断是否已经到100%
	 	if((gameHeight/(height+pro)).toFixed(2) <=0.96 ){
	 		pro -= 6;
	 		height += 6; 
	 		$(".progress").css({
	 			"padding-top":pro+"px",
	 			"height":height+"px"
	 		});
	 		
	 		if(perTxt <= 100){
	 			//$("#per").html(percent+"%");
	 			percent = parseInt(gameHeight/(height+pro)*100);
	 			$("#per").html(percent+"%");
	 		}
	 		
	 		
	 	}else
	 	{
			var n = height+pro ;
			$(".progress").css({
	 			"padding-top":0+"px",
	 			"height":n+"px"
	 		});
	 		$("#per").html(100+"%");
	 	}
	 
	 	//羽毛动画
	 	$(".feather").toggleClass("feather-dh");
	 	//小娃娃动画
	 	if(perTxt<=26){ //如果25%一下来回切换图片
	 		
	 		var dataImg = $(".img").attr("data");
	 		if(dataImg == "1"){
	 			$(".img").attr({
	 				'src':'/static/naonao/img/1-1.png',
	 				'data':'1-1'
	 			});
	 		}
	 		else{
	 			$(".img").attr({
	 				'src':'/static/naonao/img/1.png',
	 				'data':'1'
	 			});
	 		}
		}
	 	
	 	if(perTxt>26 && perTxt<=52){ //如果25%一下来回切换图片
	 		var dataImg = $(".img").attr("data");
	 		if(dataImg == "2"){
	 			$(".img").attr({
	 				'src':'/static/naonao/img/2-2.png',
	 				'data':'2-2'
	 			});
	 		}
	 		else{
	 			$(".img").attr({
	 				'src':'/static/naonao/img/2.png',
	 				'data':'2'
	 			});
	 		}
		}
	 	
	 	
	 	if(perTxt>52 && perTxt<=75){ //如果25%一下来回切换图片
	 		var dataImg = $(".img").attr("data");
	 		if(dataImg == "3"){
	 			$(".img").attr({
	 				'src':'/static/naonao/img/3-3.png',
	 				'data':'3-3'
	 			});
	 		}
	 		else{
	 			$(".img").attr({
	 				'src':'/static/naonao/img/3.png',
	 				'data':'3'
	 			});
	 		}
		}
	 	
	 	if(perTxt>75){ //如果25%一下来回切换图片
	 		var dataImg = $(".img").attr("data");
	 		if(dataImg == "4"){
	 			$(".img").attr({
	 				'src':'/static/naonao/img/4-4.png',
	 				'data':'4-4'
	 			});
	 		}
	 		else{
	 			$(".img").attr({
	 				'src':'/static/naonao/img/4.png',
	 				'data':'4'
	 			});
	 		}
		}
	 	
	 	//当用户挠到100%后弹出红包页面
	 	if(perTxt>=100){
			if(parseInt(i) <= time){
				var sucpercent = (Math.random()*(100-80)+80).toFixed(2);
				$("#cj").html(sucpercent+"%");
				clearInterval(intval);
				$(".con,.success").show();
			}
			else{
				clearInterval(intval);
				$(".con,.fail").show();
			}
			$(".trcj").html(i/1000);
			$("#lqtime").html(time/1000);
	 	}
		
		if(isStart == 1){
			intval = setInterval(setUpdateTime, 100);
			isStart = 2;
		}
		
	 });
	 
	 
	 function setUpdateTime(){
		$("#time").html(i/1000+"秒");
		i+=100;
		
	  }
	//拿红包
	 $("#choujiang").click(function(){
		 $(".con").attr("title",1);
		 $(".con,.lqhb").show();
		 $(".success").hide();
	 });
	 //再玩一次
	 $("#replay,#repfail").click(function(){
		window.location.href=window.location.href;
	 });
	 
	 
	 $(".con").click(function(){
		var title = $(".con").attr("title");
		if(title == "1"){
			window.location.reload();
		}
	 });	 
})
