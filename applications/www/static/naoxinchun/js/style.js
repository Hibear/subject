$(function(){
	//实现首页头部进入动画
	 $(".home-head").animate({top:'0px'},1000);
	// $(".btn-start").addClass("hover");
	
	 
	 //挠一挠动画
	 var percent = 0;
	 var time = 40000;
	 var i = 0; 
	 var isStart = 0;
	 var intval;
	 $(".touchBtn").click(function(){
	 	if(isStart == 0){
			isStart = 1;
		}
		
		
	 	var pro = parseInt($(".progress").css("padding-right"));
	 	var width =  parseInt($(".progress").css("width"));
	 
	 	var gameWidth =  parseInt($(".pro-color").css("width"));
		// console.log(gameWidth);return false;
	 	
	 	var  perTxt=  parseInt($("#per").html());
	 	
		//判断是否已经到100%
	 	if((gameWidth/(width+pro)).toFixed(2) <= 0.96){
	 		pro -= 2;
	 		width += 2; 
	 		$(".progress").css({
	 			"padding-right":pro+"px",
	 			"width":width+"px"
	 		});
			
			if(perTxt <= 900){
				percent = parseInt(gameWidth/(width+pro)*100);
				perTxt = parseInt(percent*9);
				console.log(perTxt);
				$("#per").html(perTxt+"元");
	 		}
			
	 	} else {
			var n = width+pro ;
			$(".progress").css({
	 			"padding-right":0+"px",
	 			"width":n+"px"
	 		});
	 		$("#per").html(900+"元");
	 	}
	 	
	 	//当用户点击到900元后弹出红包页面
	 	if(perTxt >= 900){
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
