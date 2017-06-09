<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>父爱如山，我的爸爸是超人</title>
<link rel="stylesheet" href="<?php echo get_css_js_url('father/diy.css', 'h5')?>" />
<link rel="stylesheet" href="<?php echo get_css_js_url('father/message.css', 'h5')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="MobileOptimized" content="320"/>
<script>
  var _hmt = _hmt || [];
  (function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?e2539c7271055443ffc698b8c5c88300";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
  })();
</script>

</head>
<body>
    <img style="width:100%" src="<?php echo $domain['statics']['url']?>/h5/images/father/bg_9.png" />
    <div class="main">
        <textarea placeholder="请留言..." style="border: 1px solid #e5e5e5;height: 2.6rem;width: 100%;max-width: 250px;" id="saymsg"></textarea><br>
        <img id="code_img" style="height: 35px;width: 49%;" src="/father/code"><br>
        <input style="border: 1px solid #e5e5e5;height: 1.25rem;width: 100%;max-width: 250px;" placeholder="图片验证码" type="text" id="code"><br>
        <?php if($r_status == 0):?>
        <input style="border: 1px solid #e5e5e5;height: 1.25rem;width: 100%;max-width: 250px;" placeholder="姓名" type="text" id="realname"><br>
        <input style="border: 1px solid #e5e5e5;height: 1.25rem;width: 100%;max-width: 250px;" placeholder="电话" type="text" id="tel"><br>
        <?php endif;?>
    </div>
    <div class="btn"><img id="say" src="<?php echo $domain['statics']['url']?>/h5/images/father/btn.png"></div>
    <div class="button auto-x">
    	<a class="see-more" href="/father/other">为爸爸赢大礼</a>
    </div>
    <script type="text/javascript" src="<?php echo get_css_js_url('father/jquery-2.1.1.min.js', 'h5')?>"></script>
    <script type="text/javascript">
        //留言
        $('#say').on('click', function(){
        	var msg = $('#saymsg').val();
		    if(!msg || msg == ''){
		        alert('请填写留言');
		        return;
    		}
		    var code = $('#code').val();
		    if(!code || code == ''){
		        alert('请填写图片验证码');
		        return;
    		}
		    var realname = $('#realname').val();
		    var tel = $('#tel').val();
		    var _f_token = "<?php echo $f_csrf?>";
		    $.post('/father/say', {'msg':msg, 'f_yzm':code, 'realname':realname, 'tel':tel, '_f_csrf':_f_token}, function(data){
		    	if(data){
                    alert(data.msg);
                }else{
                    alert('网络异常');
                }
    		})
        });
	</script>
	<?php $this->load->view('common/share_common.php')?>
	</body>
</html>