$(function(){

	$("#sub").click(function(){
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
        $.post("ajax.php?openid="+$("#openid").val(),{name:name,tel:tel},function(txt){
            if(txt == 0){
             tisp("提交成功");
			
            }else{
				 tisp("不要重复提交");
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
});
