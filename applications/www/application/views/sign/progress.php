<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <title>ÿ��ǩ��</title>
    <link rel="stylesheet" href="<?php echo get_css_js_url('progress.css', 'www')?>">
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

<!--progress background-->
    <div id="progress">
        <div class="pro_head">

            <div class="head_time"><?php echo date('Y-m-d') ?></div>
            <div class="qiandao">
                <p>
                   <?php
                    if($list[0]['sign_time'] == date('Y-m-d'))
                    {?>
                        <?php echo '��ǩ��'; ?>
                    <?php
                    }
                    else
                    {?>
                        <?php echo 'δǩ��';
                    }?>
                &verbar;
                                                ������ǩ��<?php echo $list[0]['continuous_days'] ?>��
                </p>                                
            </div>
            
            <div id='all_score'>
                                                        �ܻ���:<?php echo $userscore['score'] ?>
            </div>
            
            <input type="button" id="btn" value="&nbsp;ǩ��&nbsp;">

        </div>
        <div class="pro_body">
            <p class="record">ǩ����¼</p>
            <div class="record_ul">
            <?php foreach ($list as $v):?>
                <div class="ul_li">
                    <div class="li_time"><?php echo $v['sign_time'] ?></div>
                    <div class="li_continuous">����ǩ��<?php echo $v['continuous_days'] ?>��</div>
                    <div class="li_score">+<?php echo $v['score'] ?>��</div>
                </div>
            <?php endforeach; ?>    
            </div>
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
            	layer.msg('δ֪����');
            }
        })
     })
    
	</script>
</body>
</html>