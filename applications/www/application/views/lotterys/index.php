<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>幸运大转盘</title>
<link href="/static/lottery/css/style.css" rel="stylesheet" type="text/css">
<link href="/static/lottery/css/activity-style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/lottery/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/lottery/js/awardRotate.js"></script>
<link rel="stylesheet" href="http://shop.gztwkj.cn/Public/plugins/layui/css/layui.css">
<script type="text/javascript" src="http://shop.gztwkj.cn/Public/plugins/layui/layui.js"></script>
<script type="text/javascript">
 var layer;
layui.use(['layer'], function(){
	 layer = layui.layer;

});
	
var turnplate={
		restaraunts:[],				//大转盘奖品名称
		colors:[],					//大转盘奖品区块对应背景颜色
		outsideRadius:192,			//大转盘外圆的半径
		textRadius:155,				//大转盘奖品位置距离圆心的距离
		insideRadius:68,			//大转盘内圆的半径
		startAngle:0,				//开始角度
		
		bRotate:false				//false:停止;ture:旋转
};

$(document).ready(function(){
	//动态添加大转盘的奖品与奖品区域背景颜色
	turnplate.restaraunts = [
		"戏票一张", "谢谢参与", 
	    "谢谢参与", "谢谢参与", 
		"戏票一张"];
	turnplate.colors = ["#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF", "#FFF4D6", "#FFFFFF","#FFF4D6", "#FFFFFF"];

	
	var rotateTimeOut = function (){
		$('#wheelcanvas').rotate({
			angle:0,
			animateTo:2160,
			duration:8000,
			callback:function (){
				alert('网络超时，请检查您的网络设置！');
			}
		});
	};

	

	$('.pointer').click(function (){
		if(turnplate.bRotate)return;
		turnplate.bRotate = !turnplate.bRotate;
		//获取随机数(奖品个数范围内)
		 item = rnd(1,turnplate.restaraunts.length);
		//奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
		//rotateFn(item, turnplate.restaraunts[item-1]);
		//console.log(item);
	});
});


function rnd(n, m){
	$.ajax({
		url: "/lotterys/rand_lottery",
		dataType:'text',
		type:'get',
		success: function(d){
			item = d;
			if(item == -1){
				layer.msg("你今天已经抽过奖了！");
			} else if (item == -2){
				layer.msg("获取用户信息失败,请退出重新进入!");
			} else if (item == -3){
				layer.msg("今天奖品已经抽取完,明天再来!");
			}else if (item == -4){
				layer.msg("您今天还没有达到抽奖的条件哦!");
			}else {
				if(item != 1 && item !=5){
					rotateFn(item, "sorry!您抽中了" + turnplate.restaraunts[item-1]);
				}else{
					rotateFn(item, "恭喜您抽中" + turnplate.restaraunts[item-1]);
				}
				
			}
			
        }
	 });
}
//旋转转盘 item:奖品位置; txt：提示语;
function rotateFn (item, txt){
	var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
	console.log(angles);
	console.log(txt);
	if(angles<270){
		angles = 270 - angles; 
	}else{
		angles = 360 - angles + 270;
	}
	$('#wheelcanvas').stopRotate();
	$('#wheelcanvas').rotate({
		angle:0,
		animateTo:angles+1800,
		duration:8000,
		callback:function (){
			//alert(txt);
			layer.msg(txt);
			turnplate.bRotate = !turnplate.bRotate;
			setInterval(function(){
				//抽奖完成刷新页面
				window.location.reload();
			}, 3000);
		}
	});
};

//页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
window.onload=function(){
	drawRouletteWheel();
};

function drawRouletteWheel() {    
  var canvas = document.getElementById("wheelcanvas");    
  if (canvas.getContext) {
	  //根据奖品个数计算圆周角度
	  var arc = Math.PI / (turnplate.restaraunts.length/2);
	  var ctx = canvas.getContext("2d");
	  //在给定矩形内清空一个矩形
	  ctx.clearRect(0,0,422,422);
	  //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式  
	  ctx.strokeStyle = "#FFBE04";
	  //font 属性设置或返回画布上文本内容的当前字体属性
	  ctx.font = '16px Microsoft YaHei';      
	  for(var i = 0; i < turnplate.restaraunts.length; i++) {       
		  var angle = turnplate.startAngle + i * arc;
		  ctx.fillStyle = turnplate.colors[i];
		  ctx.beginPath();
		  //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）    
		  ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);    
		  ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
		  ctx.stroke();  
		  ctx.fill();
		  //锁画布(为了保存之前的画布状态)
		  ctx.save();   
		  
		  //----绘制奖品开始----
		  ctx.fillStyle = "#E5302F";
		  var text = turnplate.restaraunts[i];
		  var line_height = 17;
		  //translate方法重新映射画布上的 (0,0) 位置
		  ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);
		  
		  //rotate方法旋转当前的绘图
		  ctx.rotate(angle + arc / 2 + Math.PI / 2);
		  
		  /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
		  //在画布上绘制填色的文本。文本的默认颜色是黑色
			//measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
			ctx.font ='bold 20px Microsoft YaHei';
			ctx.fillText(text, -ctx.measureText(text).width / 2, line_height);

		  
		  
		  
		  //把当前画布返回（调整）到上一个save()状态之前 
		  ctx.restore();
		  //----绘制奖品结束----
	  }     
  } 
}

//提交个人信息
$(document).on('click', '#submit', function(){
	var fullname = $('#fullname').val();
	var tel = $('#tel').val();
	if(!fullname || fullname == ''){
		alert('请填写领奖人姓名！');
	    return false;
	}
	if(!tel || tel == ''){
		alert('请填写领奖人电话！');
	    return false;
	}
	$.post('/lotterys/update_user_info', {'fullname':fullname,'tel':tel}, function(data){
	    if(data.status == 1){
	    	window.location.href = "/lotterys";
		}else{
		    alert(data.msg);
	    }
	})
})

</script>
</head>
<body style="background:#e62d2d;overflow-x:hidden;">
<!-- 代码 开始 -->
<img src="/static/lottery/images/1.png" id="shan-img" style="display:none;" />
<img src="/static/lottery/images/2.png" id="sorry-img" style="display:none;" />
<div class="banner">
	<div class="turnplate" style="background-image:url(/static/lottery/images/turnplate-bg.png);background-size:100% 100%;">
		<canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
		<img class="pointer" src="/static/lottery/images/turnplate-pointer.png"/>
	</div>
</div>
<div class="content">
	<?php if(count($prize) > 0) { ?>
	<div class="boxcontent boxyellow">
        <div class="box">
            <div class="title-green"><span>您的奖项：</span></div>
            <div class="Detail">
                <?php foreach($prize as $key => $val):?>
                	<?php if($key == 0 && date('Y-m-d',strtotime($val['create_time'])) == date('Y-m-d') ):?>
                	    <?php if($val['level'] == 1 || $val['level'] == 5):?>
						<p>恭喜您！您今天抽中<?php echo $val['lottery_info'];?>一张！</p>
						<?php else:?>
						<p>Sorry！您今天抽中<?php echo $val['lottery_info'];?>！</p>
						<?php endif;?>
					<?php else:?>
					    <?php if($val['level'] == 1 || $val['level'] == 5):?>
				    	<p>恭喜您！您在<?php echo $val['create_time']?>抽中<?php echo $val['lottery_info'];?>一张！</p>
				    	<?php else:?>
				    	<p>Sorry！您在<?php echo $val['create_time']?>抽中<?php echo $val['lottery_info'];?>！</p>
				    	<?php endif;?>
					<?php endif;?>
			    <?php endforeach;?>
			</div>
        </div>
    </div>
	<?php } ?>
	<?php if(count($prize) > 0):?>
	<?php if($status == 1):?>
	<div class="boxcontent boxyellow lj">
        <div class="box">
            <div class="title-green">完善领奖信息：</div>
            <div class="Detail">
                <p style="padding-top:1rem;">领奖人：<input type="text" id="fullname"></p>
                <p style="padding-top:1rem;">电　话：<input type="text" id="tel"></p>
                <p style="text-align:center;padding-top:1rem;"><button style="width:3rem;height:1.5rem;border:1px solid #3b9600;background-color: #3b9600;" id="submit">提交</button></p>
                <br>
                <p style="text-align:center;">提示：请完善信息便于中奖后领奖！</p>
            </div>
        </div>
    </div>
    <?php else:?>
    <div class="boxcontent boxyellow lj">
        <div class="box">
            <div class="title-green">领奖人信息：</div>
            <div class="Detail">
                <p style="padding-top:1rem;">领奖人：<?php echo $user['fullname'];?></p>
                <p style="padding-top:1rem;">电　话：<?php echo $user['tel'];?></p>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php endif;?>
    <div class="boxcontent boxyellow">
        <div class="box">
            <div class="title-green">游戏规则：</div>
            <div class="Detail">
                <p>1、点击幸运大转盘，开始抽奖；</p>
                <p>2、每个ID每天有一次抽奖机会；（完成三次投票）</p>
                <p>3、客户凭中奖截图到方舟戏台处领奖；</p>
                <p>4、如果奖品已抽完，开发商用同等价值奖品替换；</p>
                <p>5、本活动最终解释权归开发商所有。</p>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/share_common.php')?>
</body>
</html>
