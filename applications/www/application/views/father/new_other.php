<!DOCTYPE hmtl>
<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>父爱如山，我的爸爸是超人</title>
		<script type="text/javascript" charset="UTF-8" src="/static/target/js/rem.js"></script>
		<link rel="stylesheet" charset="UTF-8" type="text/css" href="/static/target/css/base.css"  />
		<link rel="stylesheet" charset="UTF-8" type="text/css" href="/static/target/css/style_other.css?v=2017060923"  />
		<link rel="stylesheet" href="<?php echo get_css_js_url('father/list.css', 'h5')?>" />
		<link rel="stylesheet" href="<?php echo get_css_js_url('dropload.css', 'common')?>" />

		<script src="/static/target/js/jweixin-1.0.0.js" type="text/javascript"></script>
		<script type="text/javascript" charset="UTF-8" src="/static/target/js/jquery.js" ></script>
		<script type="text/javascript" charset="UTF-8" src="<?php echo get_css_js_url('dropload.js', 'common')?>" ></script>
	</head>

	<body>
	   <div id="logo">
	       <div class="logo-left"><img src="<?php echo $domain['statics']['url']?>/h5/images/father/logo-left.png"></div>
	       <div class="logo-right"><img src="<?php echo $domain['statics']['url']?>/h5/images/father/logo-right.png"></div>
	   </div>
		<!--首页-->
		<style>
		#targetCount{
			width: 7.5rem;
		    height: 12px;
		    font-size: 12px;
		    text-align: center;
		    position: absolute;
		    bottom: 20px;
		    color: #fff;
		}
	    </style>
		<style>
		#targetCount2{
			position: absolute;
			top: 1rem;
			left: 0.3rem;
			font-size: 0.34rem;
			color: #5a4a3c;
			line-height: 0.46rem;
		}
		</style>
		<!-- 列表页 -->
		<div class='page2' data="2" type="<?php if(isset($type)){echo $type;}else{echo 0;}?>">
			<div class="inner">
				<div id='targetCount2' style="font-family: 微软雅黑;">
				    共有小目标<br><?php echo $counts;?>个
				</div>
				<div class="btn-group">
					<a href="/father/other">最热的</a>
					<a href="/father/other?type=1">我写的</a>
				</div>
				<div class="list-msg" id='list-msg'>
				    <?php if($list):?>
                    <?php foreach ($list as $k => $v):?>
				    <div class="lists">
				        <div class="list-info">
				            <div class="p-head">
                    			<img src="<?php echo $v['head_img']?>">
                    		</div>
                    		<div class="p-name">
                    			<p><?php echo $v['nickname']?> : </p>
                    		</div>
                    		<div class="p-zan">
                    			<span id="zan_<?php echo $v['id']?>"><?php echo $v['zan_num']?></span>
                    			<img class="img_zan" data="<?php echo $v['id']?>" src="<?php echo $domain['statics']['url']?>/h5/images/father/no_zan.png">
                    		</div>
                    		<div class="p-msg">
                    			<p><?php echo $v['msg']?></p>
                    		</div>
				        </div>
				    </div>
				    <?php endforeach;?>
                    <?php endif;?>
				</div>
				<a href="/father/message" class="btn-fix"></a>
			</div>
		</div>
		
		

		<script type="text/javascript">

		$('.page2').dropload({
			
		    scrollArea : window,
		    loadDownFn : function(me){
		    	var page = $('.page2').attr('data');
		    	var type = $('.page2').attr('type');
		        $.get('/father/get_more?p='+page+'&type='+type, function(data){
		        	if(data.page != -1){
	                    for(i=0;i<data.list.length;i++){
	                        var html  = '<div class="lists"><div class="list-info">';
	                        html += '<div class="p-head">';
	                        html += '<img src="'+data.list[i].head_img+'">';
	                        html += '</div>';
	                        html += '<div class="p-name">';
	                        html += '<p>'+data.list[i].nickname+' : </p>';
	                        html += '</div>';
	                        html += '<div class="p-zan">';
	                        html += '<span id="zan_1">'+data.list[i].zan_num+'</span>';
	                        html += '<img class="img_zan" data="0" src="http://static.wesogou.com/h5/images/father/no_zan.png">';
	                        html += '</div>';
	                        html += '<div class="p-msg">';
	                        html += '<p>'+data.list[i].msg+'</p>';
	                        html += '</div>';
	                        html += '</div></div>';
	                        $('#list-msg').append(html);
	                        $('.page2').attr('data', data.page);
		                }
		            }else{
		            	// 锁定
                        me.lock();
                        // 无数据
                        me.noData();
			        }
		        	me.resetload();
			    });
		    }
		});
		
        $('.img_zan').on('click', function(){
            var _obj = $(this);
        	var id = _obj.attr('data');
            $.get('/father/zan', {'p_id':id}, function(data){
                if(data){
                    if(data.code == 1){
                    	_obj.attr('src', "<?php echo $domain['statics']['url']?>/h5/images/father/is_zan.png");
                        $('#zan_'+id).text( (parseInt($('#zan_'+id).text())+1) );
                    }else{
                    	alert(data.msg);
                    }
                }else{
                    alert('网络异常');
                }
            });
        });
        
        
		</script>
		<?php $this->load->view('common/share_common.php')?>
	</body>
</html>
