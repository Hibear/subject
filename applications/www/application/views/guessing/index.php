<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('gold/reset.css', 'www')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('public_vote/style.css', 'h5')?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_css_js_url('ui-dialog.css', 'common')?>" media="all" />
    <title><?php echo $info['title']?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <!-- Mobile Devices Support @begin -->
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    
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
    <div class="container center">
        <div class="header">
            
            <!--  div class="h-time"><?php echo date('Y-m-d', strtotime($info['start_time']));?></div-->
            <div class="h-coverimg"><img alt="" src="<?php echo get_img_url($info['cover_img']);?>"></div>
            <div class="h-desc">
                <span>竞猜说明：</span>
                <?php echo $info['desc']?>
            </div>
            <div style="text-align:center;"><br><button id="show_desc_img" status="0" style="border: 1px solid #ccc;height: 1.7rem;width: 4rem;">显示详情</button>
                <?php if($info['img_desc']):?>
                <img id="desc_img" style="display: none;width:92%;margin-top: 1rem;" alt="" src="<?php echo get_img_url($info['img_desc']);?>" />
                <?php endif;?>
            </div>
        </div>
        
        <div class="line"></div>
        <div class="main">
        <?php if(isset($lists)):?>
        <?php foreach ($lists as $k => $v):?>
            <div class="lists">
                <div id="p_<?php echo $v['id']?>" class="m-coverimg">
                    <img class="lazy" data="<?php echo $v['id']?>" data-page="1" video="<?php if($v['video']){echo $v['video'];}else{echo 0;}?>" data-original="<?php echo get_img_url($v['cover_img'])?>">
                </div>
				
                <div class="m-title"><div class="m-radio" data="<?php echo $v['id']?>" id="l_<?php echo $v['id']?>"></div><?php echo $v['vote_obj'].'-《'.$v['title'].'》'?></div>
                <div class="m-score">
                    <div class="jdt">
                        <div style="width:<?php echo sprintf('%.2f', ($v['score']/$total)*100)?>%" class="jdz"></div>
                    </div>
                    &nbsp;<?php echo sprintf('%.2f', ($v['score']/$total)*100)?>%(<?php echo $v['score']?>人支持)
                </div>
            </div>
            <?php endforeach;?>
        <?php endif;?>
        <div class="lists" style="height: 3rem;"></div>
        </div>
    </div>

    <footer class="footer">
        <button class="button" id="vote" data="0" status="0">开始竞猜</button>
    </footer>
    <script src="<?php echo get_css_js_url('guaguaka/jquery-1.9.1.js', 'h5')?>"></script>
    <script src="<?php echo get_css_js_url('dialog.js', 'common')?>"></script>
    <script>

        <?php if(!$lists):?>
            alert('暂无信息！');
        <?php endif;?>
        //选择
        $('.m-radio').on('click', function(){
            var _obj = $(this);
            var id = _obj.attr('data');
            //所有同胞失去焦点
            $('.m-radio').removeClass('act');
            _obj.addClass('act');
            //激活投票按钮
            $('#vote').attr('data', id);
            $('#vote').attr('status', 1);
            $('#vote').addClass('active');
        })
        //投票
        $('#vote').on('click', function(){
            status = $(this).attr('status');
            if(status == 1){
                var obj_id = $(this).attr('data');
                var active_id = <?php echo $info['id']?>;
                var html = '<div style="text-align:left">'
                   html += '<img src="/guessing/code/'+obj_id+'" />';
                   html += '<input id="code" placeholder="验证码" style="width:100px;height:30px;" autofocus />';
                   <?php if($r_status != 1):?>
                   html += '<input id="realname" placeholder="真实姓名" style="width:100px;height:30px;"/>';
                   html += '<input type="tel" id="tel" placeholder="手机号" style="width:100px;height:30px;"  />';
                   <?php endif;?>
                   html += '</div>'
                var d = dialog({
                	title: '请输入验证码',
                	content: html,
                	width:200,
                	okValue: '确定',
                	ok : function(){
                    	if($('#code').val() == ''){
                    	    return false;
                        }
                        var code = $('#code').val();
                        var realname = $('#realname').val();
                        var tel = $('#tel').val();
                        
                		$.post('/guessing/add_vote', {'obj_id':obj_id, 'active_id':active_id, 'code':code, 'realname':realname, 'tel':tel}, function(data){
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

        //点击图片选择
        $('.lazy').on('click', function(){
            var id = $(this).attr('data');
            var singlepage = parseInt($(this).attr('data-page'));
            var video = $(this).attr('video');
        	//所有同胞失去焦点
            $('.m-radio').removeClass('act');
            $('#l_'+id).addClass('act');

            //如果不是单页即包含详情页， 跳转到详情页
            if(singlepage != 1){
            	var active_id = <?php echo $info['id']?>;
            	self.location.href = "<?php echo $domain['h5']['url']?>/guessing/detail?active_id="+active_id+"&obj_id="+id;
            	return;
            }

            //绑定视频
            if(video!= 0 || video!= '0'){
                //隐藏视频显示视频
                $(this).hide();
            	//开始播放视频
                var html ='<iframe frameborder="0" width="100%" height="" src="'+video+'" allowfullscreen></iframe>';
                $('#p_'+id).append(html);
            }

            //激活投票按钮
            $('#vote').attr('data', id);
            $('#vote').attr('status', 1);
            $('#vote').addClass('active');
        });

        $('#show_desc_img').on('click', function(){
            var status = $(this).attr('status');
            if(status == 0){
                $('#desc_img').show();
                $(this).text('隐藏详细');
                $(this).attr('status', 1);
            }else if(status == 1){
            	$(this).text('查看详细');
            	$('#desc_img').hide();
                $(this).attr('status', 0);
            }
        })
    </script>
    <script type="text/javascript" src="/comment/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript">
    $(function() {
    	$("img.lazy").lazyload({ threshold : 500 });
    });
</script>
</body>
</html>