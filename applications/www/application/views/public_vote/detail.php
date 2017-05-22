<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <meta name="poweredby" content="gztwkj.cn" />
    <title><?php echo $obj['vote_obj']?> - <?php echo $obj['title']?></title>
    <link rel="stylesheet" href="/WeixinPublic/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    <script type="text/javascript" src="/WeixinPublic/js/jquery-1.9.1.js" ></script>
    <script src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
    <script>
        window.onload=function(){
            $(".load").hide();
        }
    </script>
    <style>
        .con{ width: 100%; display: none; background: #404a53;  z-index: 100; position: fixed !important; opacity: 0.3;}
        .tp{ background: #2CCB6F; color:#FFFFFF; text-align:center; margin-left:5%; margin-top:4px; margin-right:4px; width:40%; padding:6px 0px; border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px; float:left; display:block;}
        .xyimg img{ width:100%; margin-bottom:5px;margin-top:5px;}
        #erpic img{ width:60%;}
        #erpic{ width:100%; text-align:center; background:#ededed; margin-top:5px; padding-top:8px; padding-bottom:8px;}
        .user_top{ position:relative;}
        .user_top a {
            display: block;
            border-radius: 6px;
            padding: 4px;
            color: #F9F9F9;
            width: 80px;
            text-align: center;
            position: absolute;
            left: -5px;
            top: -5px;
        }
   </style>
</head>
<body>
<div class="user_top">
    <a href="javascript:window.history.go(-1);" style="left: -20px"> &lt;返回</a>
</div>

<div class="user_p">
    <ul>
        <li>
            <p><font color="#b52622"><?php echo $obj['score']  ?></font>票</p>
        </li>
        <li>
            <p>当前排名:<font color="#b52622"><?php echo $range  ?></font></p>
        </li>
    </ul>
</div>
<div class="xuanyan">
    <p>演员简介：</p>
    <p style="text-align:left; border-bottom:1px solid pink; padding:5px 0px;"><?php echo $obj['desc']  ?></p>
    <p class="xyimg">


        <img src="<?php echo get_img_url($obj['cover_img']);?>" />
        <?php if($obj['images']):?>
        <?php foreach (explode(';', $obj['images']) as $key => $val):?>
            <img src="<?php echo get_img_url($val);?>" />
        <?php endforeach;?>
        <?php endif;?>
    </p>

</div>

<div class="tou">
    <p id="tp">投票</p>
</div>

<div class="copy"><a href="#" style="color:#9c9c9c">贵州时代纵横提供技术支持</a></div>

<script src="/WeixinPublic/plugins/layui/layui.js"></script>
<script type="text/javascript" >
    var layer = '';
    layui.use(['layer'], function(){
        layer = layui.layer
    });
    $(function(){

    	$('#vote').on('click', function(){
            status = $(this).attr('status');
            if(status == 1){
                var obj_id = $(this).attr('data');
                var active_id = <?php echo $info['id']?>;
                var html = '<div style="text-align:center">'
                html += '<img src="/public_vote/code/'+obj_id+'" />';
                html += '<input id="code" style="width:100px;height:30px;" autofocus />';
                html += '</div>'
                var d = dialog({
                	title: '请输入验证码',
                	content: html,
                	width:150,
                	okValue: '确定',
                	ok : function(){
                    	if($('#code').val() == ''){
                    	    return false;
                        }
                        var code = $('#code').val();
                        
                		$.post('/public_vote/add_vote', {'obj_id':obj_id, 'active_id':active_id, 'code':code}, function(data){
                            if(data){
                                if(data.code == 1){
                                	alert(data.msg);
                                }else{
                                	alert(data.msg);
                                }
                            }else{
                                alert('网络异常')
                            }
                        });
                    }
                });
                d.showModal();
                
            }
        });
    })

</script>



<div class="load">
    <p><img src="/WeixinPublic/images/loading.gif" /></p>
    <p id="txt">加载中....</p>
</div>

<?php $this->load->view('common/share_common.php')?>
</body>

</html>
