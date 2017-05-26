<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <title>我的礼品</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('sign/myprize.css', 'www')?>">
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
    <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/dialog.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    <script type="text/javascript" src="<?php echo get_css_js_url('gold/dialog_min.js', 'www')?>"></script>
    <script type="text/javascript" src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
       
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;
        });
    </script>
    
</head>
<body>

    <div id="head_background">       
        <div class="rec_bac" id="receive_back">
            <button class="type" status="2" style="background: #feac22">已领取</button>
            <button class="type" status="1">未领取</button>
        </div> 
    </div>

<!--礼品 background-->
<div id="list_back">
    <!--礼品-->

    <!--礼品列表-->
    <div class="lists">
        
        <?php if($list): ?>
        <?php foreach ($list as $v):?>
        <?php if($v['status']==2): ?>
        <div class="none_lipin">
        <a href="/sign/detail?id=<?php echo $v['id']?>">
            <img src="/WeixinPublic/images/caideng.jpg" alt="">
        </a>
            <p>名称:<?php echo $v['title']?></p>
            <p id="score_color">积分:<?php echo $v['score']?></p>
            <p>领取时间:<?php echo date('Y-m-d',strtotime($v['get_time']))?></p>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
       
    </div>

</div>


<script type="text/javascript">

    $('.type').on('click', function(){

        var status = $(this).attr('status');
		if(status ==2)
		{
			$('.type:eq(0)').css("background", "#feac22");
			$('.type:eq(1)').css("background", "#ececec");
			
		}
		if(status <=1)
		{
			$('.type:eq(1)').css("background", "#feac22");
			$('.type:eq(0)').css("background", "#ececec");
		}

    	 $.ajax({
             type: "post",
             url : "/sign/get_status_lists",
             data: {status:status},
             dataType:'json',
             success: function(data){
            	 if(data.code == 0){
	                 	layer.msg;
	                 	return;
	                }
	                
                 if(data.code == 1){

                     var html = "";
                     var score = data.score;
                     for(var i=0;i<score.length;i++){

                                 html += '<div class="none_lipin">';
        						 html += '<img src="/WeixinPublic/images/caideng.jpg" alt="">';
        						 html += '<p>名称:'+score[i]['title']+'</p>';
        						 html += '<p id="score_color">积分:'+score[i]['score']+'</p>';
        						 if(status ==2){
        							 html += '<p>领取时间:'+score[i]['get_time']+'</p>';
            					 }
        						 if(status ==1){
        							 html += '<p>兑换时间:'+score[i]['create_time']+'</p>';

        							 if(score[i]['status']==1){
        								 html += '<p class="rec" data='+score[i]['id']+' style="text-align: center;font-size:10px;">领取</p>';

            						 }

            						 if(score[i]['status']==0){
            							 html += '<p style="text-align: center;font-size:10px;">未发放</p>'; 
                					 }
        							 
        							 
            					 }
        						 html += '</div>';

                     }
                     
                     $(".lipin").hide();
                     $(".lists").html(html);
                 }

             }
         });

    });
    
</script>


<script type="text/javascript">

	$('body').on('click','.rec', function(){
		var sign_id = $(this).attr('data');
		var d = dialog({
			title:'系统提示',
    		content: '确定已收到礼品，并领取吗?',
    		okValue: '确定',
    		ok: function () {
    			d.close().remove();
    			$.ajax({
   	             type:"post",
   	             url:"/sign/get",
   	             dataType:'json',
   	             data:{sign_id:sign_id},
   	             success:function (data) {
   	                 if(data.code == 1){
   	                 	layer.msg(data.msg);
   	                 }else{
   	                 	layer.msg(data.msg);
   	                 }

      	             window.location.reload();
   
   	             },
   	             error:function(){
   	             	layer.msg('未知错误！');
   	             }
   	         })
    		}
    	});
    	d.showModal();
	});
	

</script>



</body>
</html>