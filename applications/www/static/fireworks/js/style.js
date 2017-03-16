$(function(){
	//实现首页头部进入动画
	 $(".home-head").animate({top:'0px'},1000);
	

	$(".btn-start").click(function(){
		$(".home,.ready3").hide();
		$(".game-second,.con2").show();
		

	});

  
    $(".ready2").click(function(){
    	$(".ready").hide();
    	$(".ready3").show();
    	var n = 2;
    	var t = setInterval(function(){
    		if(n <= 0){
    			$(".ready3,.con2").hide();
    			clearInterval(t);
    			$(".next,.page1").show();
				$(".page").show();
				//开始倒计时
				Countdown();
    		}
    		$(".ready3").html(n);
    		n--;
    	},1000);
    });
	 
    function Countdown(){
		var tt = parseInt($("#time").html());
		var m = 15;
		var t = setInterval(function(){
    		if(tt <= 1){
    			clearInterval(t);
    		}
    		tt--;
			parseInt($("#time").html(tt));
    	},1000);
		
	}
	
	
	 
	$("#bm").click(function(){
		 
		 $(".choujiang").hide();
		 $(".baoming").show();
	 });
  
  
     $("#btn").click(function(){
		 $("#tips").hide();
		$(".page1").hide();
		$(".next").hide();
		$(".choujiang").show();
	 });
  
	
	
	 
	 $(".sub").click(function(){
       var type = parseInt($(this).attr("data-type"));
       if(type == 1){
 		var name = $("#name1").val();
        var tel = $("#tel1").val();
       }else{
       
         var name = $("#name").val();
        var tel = $("#tel").val();
       }
       
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
     
       $.post("/fireworks/update_users",{name:name,tel:tel},function(txt){
			if(txt > 0){
             setTimeout(function () {
				 tisp("提交成功");
                 $("#info").hide();
			  }, 1000);
			
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
          }, 2000);
	}
	
	
})

