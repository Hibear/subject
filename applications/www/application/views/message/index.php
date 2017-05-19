<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo css_js_url('bootstrap.min.css', 'admin');?>" rel="stylesheet" />
        <link href="<?php echo get_css_js_url('message/style.css', 'h5')?>" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('swiper/swiper.min.css', 'h5')?>" media="all" />
        <script type="text/javascript" src="<?php echo get_css_js_url('jquery-1.9.1.js', 'h5')?>"></script>
        <script src="<?php echo get_css_js_url('swiper/swiper.min.js', 'h5')?>" type="text/javascript"></script>
    </head>
<body>
    <?php if($lists):?>
    <div class="list">
        <h4>&nbsp;最新留言：</h4>
        <div class="swiper-container">
          <div class="swiper-wrapper">
          <?php foreach ($lists as $k => $v) :?>
            <div class="swiper-slide">
                <div class="text">
                    <p><?php echo $v['msg']?></p>
                </div>
                
            </div>
          <?php endforeach;?>
          </div>
        </div>
    </div>
    <?php endif;?>

    <div class="message">
          <div class="form-group">
            <input type="hidden" id ="_csrf" value="<?php echo $csrf;?>">
            <textarea class="form-control" id="msg" placeholder="请您留言"></textarea>
            <p id="tip"></p>
            <p id="success"></p>
          </div>
          <button type="submit" class="btn btn-default">提交</button>
    </div>
    
    <script type="text/javascript">
        var mySwiper = new Swiper('.swiper-container', {
        	autoplay: 10000,//可选选项，自动滑动
        })
        //提交留言
        $('.btn.btn-default').on('click' , function(){
            var _csrf = $('#_csrf').val();
            var msg = $('#msg').val();
            if(msg == '' || !msg){
                $('#tip').text('留言不能为空！');
                return;
            }
            $.post('/message/save', {'_csrf':_csrf, 'msg':msg}, function(data){
                if(data){
                    if(data.code == 0){
                    	$('#tip').text(data.msg);
                    }else{
                        $('#msg').val('');
                    	$('#success').text(data.msg);
                    	setInterval(function(){
                    		$('#success').text('');
            			}, 3000);
                    }
                }else{
                	$('#tip').text('网络异常！');
                }
            })
        })
    </script>
</body>
</html>