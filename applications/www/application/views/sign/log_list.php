<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <title>每日签到</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('sign/progress_2.css', 'www')?>">
    <script src="<?php echo get_css_js_url('jquery-1.9.1.js', 'www')?>"></script>
     <script type="text/javascript" src="/WeixinPublic/plugins/layui/layui.js"></script>
    <script type="text/javascript">
        var layer = '';
        layui.use(['layer'], function(){
            layer = layui.layer;

        });
    </script>
</head>
<body>

<!-- background -->
<div id="background">

    <!-- 签到头部 -->
    <div id="sign_head">      
        <div id="sign" rz="<?php echo $user['status'] ?>"  status="<?php if($list[0]['sign_time'] == date('Y-m-d')){ echo 1;}else{echo 0;}?>" >
            <div id="sign_1">
                <?php
                    if($list[0]['sign_time'] == date('Y-m-d'))
                    {?>
                        <?php echo '已签到'; ?>
                    <?php
                    }
                    else
                    {?>
                        <?php echo '签到';
                    }?>
            </div>
            <?php if($list[0]['sign_time'] == date('Y-m-d')):?>
            <hr>
            <div id="sign_2">连续<?php echo $list[0]['continuous_days'] ?>天</div>
            <?php endif;?>
        </div>
                <div style="margin-top:10px;color: #e28b3b;">积分：<?php echo $user['score'] ?></div>
                <div class="hr_background">
            
                 <hr class="hr_1">
                    <div class="hr_text">签到记录</div>
                 <hr class="hr_2">
            
        </div>
        
    </div>
    

    
    <!--  签到记录 -->
    <div class="sign_foot">
        

            
        <div class="sign_Recordback">
        <?php foreach ($list as $v):?>
             <div class="record">
                  <p class="record_1"><?php echo $v['sign_time'] ?></p>
                  <p class="record_2">连续签到<?php echo $v['continuous_days'] ?>天</p>
                  <p class="record_3">+<?php echo $v['score'] ?>分</p>
             </div>
        <?php endforeach; ?>
             <div style="text-align:center;height:50px;color: #757575;font-family:微软雅黑;padding:5px;font-size: 10px;">显示最新15次的签到哦</div>
        </div>

    </div>

    <div id="bottom_nav">
            <div class="hr_text"><p onclick="window.open('/sign/goods', '_self')">兑换礼品</p></div>
    </div>
    
</div>
<script type="text/javascript">
    $('#sign').click(function(){
        var status = $(this).attr('status');
        var rz_status = $(this).attr('rz');
        if(rz_status != 1){
        	layer.msg('您还未认证个人信息！');
        	setTimeout(function () {
            	window.open('/sign/renzheng', '_self');
 	       	}, 2000);
 	       	return;
        }
        if(status == 0){
        	$.ajax({
                type:"post",
                url:"/sign/log",
                dataType:'json',
                success:function (data) {
                    if(data.code == 1){
                    	layer.msg(data.msg);
                    }else{
                    	layer.msg(data.msg);
                    }
                    window.location.reload();
                },
                error:function(){
                	layer.msg('网络错误！');
                }
            });
        }
     });
</script>
</body>
</html>