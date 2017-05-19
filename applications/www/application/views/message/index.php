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
            <textarea style="height: 100px;" class="form-control" id="msg" placeholder="请您留言"></textarea>
            <p id="tip"></p>
            <p id="success"></p>
          </div>
          <div class="form-group">
            <img id="verify_img" style="border: 1px solid #ccc;" src="/message/code" /><br><br>
            <input type="text" style="height:34px;" class="col-xs-5 col-sm-3" id="p_yzm" placeholder="验证码" />
            <button type="submit" class="btn btn-default">提交</button>
          </div>
          
    </div>
    
    <script type="text/javascript">

        $('#verify_img').click(function(){
            $('#verify_img').attr('src',$('#verify_img').attr('src')+'?');
        });
    
        var mySwiper = new Swiper('.swiper-container', {
        	autoplay: 10000,//可选选项，自动滑动
        })
        //提交留言
        $('.btn.btn-default').on('click' , function(){
            var _csrf = $('#_csrf').val();
            var msg = $('#msg').val();
            var p_yzm = $('#p_yzm').val();
            if(p_yzm == '' || !p_yzm){
                $('#tip').text('验证码不能为空！');
                return;
            }
            if(msg == '' || !msg){
                $('#tip').text('留言不能为空！');
                return;
            }
            $.post('/message/save', {'_csrf':_csrf, 'msg':msg, 'p_yzm':p_yzm}, function(data){
                if(data){
                    if(data.code == 0){
                    	$('#tip').text(data.msg);
                    }else{
                        $('#msg').val('');
                        $('#p_yzm').val('');
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