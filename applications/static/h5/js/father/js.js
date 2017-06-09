/*
 * 全站公共脚本,基于jquery-2.1.1脚本库，库中已嵌入tap,transition
 */
$(function() {
//指定阻止滑动触摸等
	var prevent = ["loading"];
	for ( var i=0;i<prevent.length;i++ ){
		if ( document.getElementById(prevent[i]) ){
			document.getElementById(prevent[i]).addEventListener("touchstart",function(event){
				event.preventDefault();
			})
		}
	}
	$(document).on("tap","a[href]",function(){
		window.location.href = $(this).attr("href");
	})
//识别系统及客户端
	function is_weixn(){
	    var ua = navigator.userAgent.toLowerCase();  
	    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
	        return true;  
	    }
	    else {
	        return false;  
	    }  
	}  
	function isIos(){  
       var userAgentInfo = navigator.userAgent;  
       var Agents = new Array("iPhone");  
       var flag = false;  
       for (var v = 0; v < Agents.length; v++) {  
           if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = true; break; }  
       }  
       return flag;  
	}
	var fullHeight = document.documentElement.clientHeight;
	var fullWidth = $("body").width();
//滑动事件
    var mySwiper = $("#mySwiper");
    var length = mySwiper.find(">.swiper-slide").length;
    mySwiper.find(">.swiper-slide").width(fullWidth).height(fullHeight);
    mySwiper.width(fullWidth).height(fullHeight*length);
	mySwiper[0].style.webkitTransform = "translate3d(0,0,0)";
	mySwiper[0].style.transform = "translate3d(0,0,0)";
    var mousedown = false;
    var y1,y2;
    var distance = 0;
    var up = true;
    var down = true;
    var page = 0;
    $(window).on("resize",function(){
		fullHeight = document.documentElement.clientHeight;
		fullWidth = $("body").width();
	    mySwiper.find(">.swiper-slide").width(fullWidth).height(fullHeight);
	    mySwiper.width(fullWidth).height(fullHeight*length);
		var slide = mySwiper[0];
    	slide.style.webkitTransitionDuration = "0s";
    	slide.style.transitionDuration = "0s";
		slide.style.webkitTransform = "translate3d(0,"+page*-fullHeight+"px,0)";
		slide.style.transform = "translate3d(0,"+page*-fullHeight+"px,0)";
    })
    $("body").on("touchstart mousedown",function(e){
    	if ( !up || !down ){
	    	mousedown = true;
	        switch(e.type){
	            case "mousedown":
	                y1 = e.pageY;
	            	break;
	            case "touchstart":
	                y1 = e.originalEvent.targetTouches[0].pageY;
	            	break;
	    	}
    	}
    })
    $("body").on("touchmove mousemove",function(e){
    	if ( mousedown && ( !up || !down ) ){
    		e.preventDefault();
	        switch(e.type){
	            case "mousemove":
	                y2 = e.pageY;
	            	break;
	            case "touchmove":
	                y2 = e.originalEvent.targetTouches[0].pageY;
	            	break;
	    	}
			distance = Math.abs(y2-y1);
			if ( distance > 80 ){
				if ( y2 < y1 ){
					if ( page != length - 1 && !down ){
						up = true;
						down = true;
    					mousedown = false;
    					document.getElementById("page-tip").style.display = "none";
    					var slide = mySwiper[0];
    					slide.style.webkitTransform = "translate3d(0,"+(page+1)*-fullHeight+"px,0)";
			        	slide.style.webkitTransitionDuration = "500ms";
    					slide.style.transform = "translate3d(0,"+(page+1)*-fullHeight+"px,0)";
			        	slide.style.transitionDuration = "500ms";
			        	setTimeout(function(){
			        		slide.style.webkitTransitionDuration = "0";
			        		slide.style.transitionDuration = "0";
							mySwiper.find(">.swiper-slide").eq(page).removeClass("on");
							page ++;
				    		pageSlide();
			        	},500)
					}
				}
				else{
					if ( page != 0 && !up ){
						up = true;
						down = true;
    					mousedown = false;
    					document.getElementById("page-tip").style.display = "none";
    					var slide = mySwiper[0];
    					slide.style.webkitTransform = "translate3d(0,"+(page-1)*-fullHeight+"px,0)";
			        	slide.style.webkitTransitionDuration = "500ms";
    					slide.style.transform = "translate3d(0,"+(page-1)*-fullHeight+"px,0)";
			        	slide.style.transitionDuration = "500ms";
			        	setTimeout(function(){
			        		slide.style.webkitTransitionDuration = "0";
			        		slide.style.transitionDuration = "0";
							mySwiper.find(">.swiper-slide").eq(page).removeClass("on");
							page --;
				    		pageSlide();
			        	},500)
					}
				}
			}
    	}
    })
    $("body").on("touchend mouseup",function(event){
    	mousedown = false;
    })
    
    //页面加载成功
	var load1 = false;
	var load2 = false;
	window.onload = function(){
		var loadingPercent = $("#percent");
		$("#loading").css({"visibility":"visible",opacity:0}).addClass("on").transition({opacity:1,complete:function(){
			setTimeout(function(){
				load1 = true;
				enter();
				$('#logo').show();
			},3000)
			var img = $("body").find("img[loadsrc]");//图片数组
			var length = img.length;//图片数量
			var downImg = 0;//已下载数量
			var percent = 0;//百分比
			for ( var i=0;i<length;i++ )
			{
				var imgs = new Image();
				var imgDiv = img.eq(i);
				var imgsrc = imgDiv.attr("loadsrc");
				imgs.src = imgsrc;
				if(imgs.complete)
				{
			    	imgDiv.attr("src",imgsrc).removeAttr("loadsrc");//有缓存
			    	imgDown();
				}
				else
				{
				    imgDiv.attr("src",imgsrc).load(function(){
				    	$(this).removeAttr("loadsrc");//无缓存
				    	imgDown();
				    })
				}
			}
			function imgDown()
			{
				downImg ++;
				percent = parseInt(100*downImg/length);
				//loadingPercent.html(percent+"%");
				if ( percent == 100 )
				{
					load2 = true;
					enter();
				}
			}
		}},800);
		getMusic();
		//微信下音乐加载的hack
//		if ( is_weixn() ){
//			document.addEventListener("WeixinJSBridgeReady",function(){
//				getMusic();
//				console.log('微信端')
//		    },false);
//		}
//		else{
//			getMusic();
//		}

	}
	function enter(){
		if ( load1 && load2 ){
			$("#mySwiper").css({"display":"block","opacity":0});
			setTimeout(function(){
				$("#mySwiper").transition({opacity:1,complete:function(){
					$("#loading").hide();
					pageSlide();
				}},600);
			},500)
		}
	}
	function pageSlide(){
		switch ( page ){
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
				playMusic();
				up = false;
				down = false;
				break;
			case 7:
				stopMusic();
				mySwiper.find(">.swiper-slide").eq(page).addClass("on");
				up = false;
				break;
		}
	}
	window.music = [];
	var musicSrc = ["http://static.wesogou.com/h5/images/father/1.mp3","http://static.wesogou.com/h5/images/father/2.mp3","http://static.wesogou.com/h5/images/father/3.mp3","http://static.wesogou.com/h5/images/father/4.mp3","http://static.wesogou.com/h5/images/father/5.mp3","http://static.wesogou.com/h5/images/father/6.mp3","http://static.wesogou.com/h5/images/father/7.mp3","http://static.wesogou.com/h5/images/father/8.mp3"];
	var bgm;
	window.getMusic = function(){
		bgm = new Audio();
		bgm.src = "http://static.wesogou.com/h5/images/father/bgm.mp3?v=20170606";
		bgm.loop = "loop";
		bgm.play();

		musicA = setInterval(function(){
			if ( bgm.currentTime != 0 )
			{
				clearInterval(musicA);
				$("#music").css({"visibility":"visible",opacity:0}).transition({opacity:1},500);
			}
		},100)
		for ( var i=0;i<musicSrc.length;i++ ){
			var m = new Audio();
			m.src = musicSrc[i];
			music.push(m);
		}
		for ( var i=0;i<music.length;i++ ){
			music[i].load();
		}
	}
	$(".music").on("tap",function(){
		if ( $(this).hasClass("play") )
		{
			$(this).removeClass("play");
			$("#music>span").addClass("zshow").html("关闭");
			setTimeout(function(){$("#music>span").removeClass("zshow")},1000);
			bgm.pause();
		}
		else
		{
			$(this).addClass("play");
			$("#music>span").addClass("zshow").html("开启");
			setTimeout(function(){$("#music>span").removeClass("zshow")},1000);
			bgm.play();
		}
	})
	function stopMusic(){
		if ( typeof(musicAuto) != "undefined" ){
			clearInterval(musicAuto);
		}
		if ( typeof(musicAutos) != "undefined" ){
			clearInterval(musicAutos);
		}
		if ( typeof(musicAutoss) != "undefined" ){
			clearInterval(musicAutoss);
		}
		for ( var i=0;i<music.length;i++ ){
			music[i].currentTime = 0;
			music[i].pause();
		}
	}
	function playMusic(){
		stopMusic();
		music[page].play();
		musicAuto = setInterval(function(){
			if ( music[page].currentTime != 0 )
			{
				clearInterval(musicAuto);
				mySwiper.find(">.swiper-slide").eq(page).addClass("on");
				musicAutos = setInterval(function(){
					if ( music[page].paused ){
						clearInterval(musicAutos);
						if ( page == 5 ){
							music[7].play();
							musicAutoss = setInterval(function(){
								if ( music[7].paused ){
									clearInterval(musicAutoss);
									document.getElementById("page-tip").style.display = "block";
									up = false;
									down = false;
									if ( !isIos() && $(".music").hasClass("play") ){
										bgm.play();
									}
								}
							},100)
						}
						else{
							document.getElementById("page-tip").style.display = "block";
							up = false;
							down = false;
							if ( !isIos() && $(".music").hasClass("play") ){
								bgm.play();
							}
						}
					}
				},100)
			}
		},100)
	}
//分享
	$(document).on("tap",".share",function(event){
		event.preventDefault();
		$("#share").css({"display":"block",opacity:0}).transition({opacity:1},500);
		up = true;
		down = true;
	})
	$(document).on("tap","#share",function(event){
		event.preventDefault();
		$(this).transition({opacity:0,complete:function(){
			$(this).hide();
			up = false;
			down = false;
		}},300);
	})
})