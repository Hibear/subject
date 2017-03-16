<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>2016腾讯房产年度盛典现场抽奖</title>
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<meta name="Description" content="">
		<!-- Mobile Devices Support @begin -->
		<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
		<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
		<meta content="no-cache" http-equiv="pragma">
		<meta content="0" http-equiv="expires">
		<meta content="telephone=no, address=no" name="format-detection">
		<meta name="apple-mobile-web-app-capable" content="yes"> <!-- apple devices fullscreen -->
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="viewport" content="width=device-width, initial-scale=1">
			
		<link href="<?php echo css_js_url('bootstrap.min.css', 'admin');?>" rel="stylesheet" />
		

		<style>  
            body{  
                background-position: center;  
                background-repeat: no-repeat;  
                background-attachment: fixed;  
            }  
            .demo{width:800px; margin:10px auto; text-align:center;height:730px;position: relative;padding: 2% 0;}  
            #roll{padding: 3% 0;}   
            .h1{font-size:4em;  color: #ffb400;margin-bottom: 10px;}  
            .col-sm-3{ font-size:3.8em; color: #fff;}  
            .col-sm-12{ font-size:4em; color: #fff; line-height: 2em;}  
            .huge{font-size:8em; margin-top: 60px;}  
            .btn{width:165px; height:55px; line-height:26px;border:1px solid #d3d3d3; cursor:pointer;font-weight: bold;font-size: 2em;}   
            #start{color: green;}  
            #stop{display:none;color: red;}   
            #result{margin-top:20px; line-height:24px; font-size:16px; text-align:center}   

            .has-won{
            	width: 1000px;
			    margin: 30px auto;
			    position: relative;
			}
			.has-won h1 {color: #ffb400; font-size: 28px;}
			.has-won h1 span{color: #fff;}
        </style>  
	</head>
	<body style="width:100%; height:100%; background: black">
		<?php $this->load->view('/Choujiang/header');?>
		<div class="container-fluid">  
	        <div class="demo">  
	            <h1 class="center h1">2016腾讯房产年度盛典现场抽奖</h1>  
	            <div id="roll">  
	                <span class="col-sm-12 huge"  id="hiden">准 备 !</span>  
	                <div class="child">  
	                    <?php if($num==1):?>  
	                        <span class="col-sm-12 huge"  id="roll1"></span>  
	                        <input type="hidden" name="mid[]" id="mid1" value="">   
	                    <?php elseif($num<=4):?>  
	                        <?php for($i=1;$i<=$num;$i++):?>  
	                            <span class="col-sm-12"  id="roll<?echo $i?>"></span>  
	                            <input type="hidden" name="mid[]" id="mid<?echo $i?>" value="">   
	                        <?php endfor;?>  
	                    <?php else:?>  
	                        <?php for($i=1;$i<=$num;$i++):?>  
	                            <span class="col-sm-3"  id="roll<?echo $i?>"></span>  
	                            <input type="hidden" name="mid[]" id="mid<?echo $i?>" value="">   
	                        <?php endfor;?>  
	                    <?php endif;?>  
	                </div>  
	            </div>  
	        </div> 
	        <div style="text-align:center; position:relative">  
	            <p class="mt40">  
	            	<input type="hidden" name="allcount" id="allcount" value="<?php echo $allcount;?>" />
	            	<input type="hidden" name="levelcount" id="levelcount" value="<?php echo $levelcount;?>" />
	            	<input type="hidden" name="remaincount" id="remaincount" value="<?php echo $remaincount;?>" />
	            	<input type="hidden" name="prize" id="prize" value="<?php echo $prize;?>" />
	                <input type="button" class="btn" id="back" value="返 回" onclick="window.location.href='/choujiang'">    
	                <input type="button" class="btn" id="start" value="开 始">    
	                <input type="button" class="btn" id="stop" value="停 止">  
	        	</p>  
	        </div>  
	        <div class="has-won">  
	            <h1><label><?php echo $prizename; ?>当前中奖编号：</label><span id="current_number"></span></h1>  
	            <h1><label><?php echo $prizename; ?>已中奖编号：</label><span id="own_number"><?php echo $has_own_number;?></span></h1>  
	        </div> 
        </div>  
		<script type="text/javascript" src="/static/naoxinchun/js/jquery.min.js" ></script>
		<script type="text/javascript">
			var level = '<?php echo $level; ?>';  
			var count = '<?php echo $num; ?>';  
	        var min = '<?php echo $min; ?>';  
	        var max = '<?php echo $max; ?>'; 
	        var allownum = '<?php echo $allownum; ?>'; 
	        var prizename = '<?php echo $prizename; ?>'; 
			$(function() {  
                var _gogo;   
                var start_btn = $("#start");   
                var stop_btn = $("#stop");   
    
                $('#start').on('click', function() { 
                	if (!confirm('确定开始吗？')) {
                		return false;
                	} 

                	// if ($("#allcount").val() == 49) {
                		// alert('所有奖项已抽取完毕！');
                		// return false;
                	// }

                	// if ($("#levelcount").val() == allownum) {
                		// alert(prizename+"已抽取完！");
                		// return false;
                	// }

                	// if (parseInt($("#remaincount").val()) < parseInt(count)) {
                		// alert("当前抽取个数大于"+prizename+"剩余个数，请返回重新设置！");
                		// return false;
                	// }

                    $("#hiden").hide();   

                	var prize = $("#prize").val();  
                    $.post('/Choujiang/data',{min:min,max:max},function(data) {  
                        if(data){   
                            var obj = eval(data);//将JSON字符串转化为对象   
                            var len = obj.length;   
                            _gogo = setInterval(function(){   
                                var form = 0; 
                                for(i = 1; i <= count; i++){  
                                    var num = Math.floor(Math.random()*(len-form))+form;//获取随机数  
                                    if(prize.indexOf(obj[num]['number']) == -1) {  
                                        $("#roll" + i).html(obj[num]['number']);   
                                        $("#mid" + i).val(obj[num]['number']);   
                                    }
                                }  
                            },100); //每隔0.1秒执行一次   
                            stop_btn.show();   
                            start_btn.hide();   
                        }else{   
                            $(".roll").html('系统找不到数据源，请先导入数据。');   
                        }   
                    });  
                });   

                $('#stop').on('click', function() {  
                    clearInterval(_gogo);   
					
					//二等奖内定213
					if(level == 2 && $("#own_number").html().indexOf(213) == -1) {
						$("#roll" + count).html(213);   
						$("#mid" + count).val(213);
					}
					
                    var numberArr = [];
                    for(i = 1; i <= count; i++){
                    	numberArr.push($("#mid"+i).val());
                    };

					$.ajax({
			            type: "POST",
			            url: "/Choujiang/updateprize",
			            data: {numberArr: numberArr, level: level},
			            dataType: "json",
			            success: function (data) {
			                if (data.flag) {
			                	stop_btn.hide();   
	                    		start_btn.show();
	                    		$("#prize").val(data.prize);
	                    		$("#allcount").val(data.allcount);
	                    		$("#levelcount").val(data.levelcount);
	                    		$("#remaincount").val(data.remaincount);
	                    		$("#current_number").html(data.current_number);
	                    		$("#own_number").html(data.own_number);
			                }
			            },
			            error: function (msg) {
			                
			            }
			        });
                });  

            }); 
		</script>
	</body>
</html>
