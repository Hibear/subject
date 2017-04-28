<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <title>每日签到</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('progress_2.css', 'www')?>">
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
        <input type="button" id="btn" value="&nbsp;签到&nbsp;">
        <div id="time_back">
            <div id="tianchong"></div>
            <div id="time"><?php echo date('Y年m月d日') ?></div>
            <div id="duihuan">
            </div>
        </div>
        
        
        <div id="sign">
            <div id="sign_1">
                <?php
                    if($list[0]['sign_time'] == date('Y-m-d'))
                    {?>
                        <?php echo '已签到'; ?>
                    <?php
                    }
                    else
                    {?>
                        <?php echo '未签到';
                    }?>
            </div>
            <hr>
            <div id="sign_2">连续<?php echo $list[0]['continuous_days'] ?>天</div> 
        </div>
        
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
        </div>

    </div>

    <div id="bottom_nav">
            <div><p>去兑换:<?php echo $userscore['score'] ?>分>></p></div>
    </div>
    
</div>
<script type="text/javascript">
    $('#btn').click(function(){
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
            	layer.msg('未知错误！');
            }
        })
     })
    
</script>
</body>
</html>