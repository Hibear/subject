<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $lottery['name'];?></title>
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

		     <link rel="stylesheet" href="<?php echo css_js_url_v2('style.css', 'fireworks');?>" />
		     <link rel="stylesheet" href="<?php echo css_js_url_v2('animate.css', 'fireworks');?>" />
	</head>

	

	<body>
	<audio src="http://xunlei.sc.chinaz.com/Files/DownLoad/sound1/201502/5504.wav" id="bgaudio"></audio>
	
	<!--首页-->
	
	<div class="btn-start home fadeInDown"><img src='<?php echo static_img_uri("fireworks/img/start.png");?>' /></div>
	<div class="text home slideInLeft"><img src='<?php echo static_img_uri("fireworks/img/jiangxin.png");?>' /></div>
	
	<!--首页end-->
	
	<div class="ready ready1 game-second"><img src='<?php echo static_img_uri("fireworks/img/ready1.png");?>'></div>
	<div class="ready ready2 game-second"><img src='<?php echo static_img_uri("fireworks/img/ready2.png");?>' ></div>
	<div class="ready3" style="display: none;">3</div>
	
	 <div class="bg_1 page1 yanhua"> </div>
	 <div id="time" class="page1">15</div>
	  <div class="progress page1">
          <div class="pro-color"></div>
      </div>
      <div id="per" class="page1">0%</div>      	
	  
	   <div class="next"><img src='<?php echo static_img_uri("fireworks/img/next.png");?>'></div>
	  
	   <input type="hidden" value="<?php echo $openid;?>" id="openid">
	   <input type="hidden" value="<?php echo $token; ?>" id="token">
	   <input type="hidden" value="<?php echo $recoder; ?>" id="recoder">
	   <input type="hidden" value="<?php echo $lottery['switch']; ?>" id="switch">

		
		<div class="choujiang" style="display:none">
			<ul id="prize">
				<li class="red" title="点击抽奖"></li>
				<li class="green" title="点击抽奖"></li>
				<li class="blue" title="点击抽奖"></li>
				<li class="purple" title="点击抽奖"></li>
				<li class="olive" title="点击抽奖"></li>
				<li class="brown" title="点击抽奖"></li>
			</ul>
			<div style="clear:both; margin-top:20px;color:#d3b267">
				<a href="javascript:void(0)" id="viewother">【翻开其他】</a> 
			 </div>
			 <div class="info">
				<h3>活动说明:</h3>
				<?php echo $lottery['info'];?>
				<p style="padding:5px; border:1px solid #d3b267; margin-top:15px;">★点击数字方块，翻转即抽奖，每人有且只有一次抽奖机会，快来试试你
     的手气吧！</p>
             
			</div>


			<span class="rgiser"> 
				<a href="/fireworks/baoming"> <img src='<?php echo static_img_uri("fireworks/img/baoming.png");?>' /></a>
			</span>

			<div id="data"></div>
		</div>
		
	
		<div class="con" title=""></div>
		<div class="con2" title="" ></div>
	
		<div class="weui_dialog_alert" id="tips" style="display:none;">
		   <div class="weui_mask"></div>
		   <div class="weui_dialog">
			   <div class="weui_dialog_hd"><strong class="weui_dialog_title">消息提示</strong></div>
			   <div class="weui_dialog_bd" id="msg">很遗憾~您没有闯关成功哦~</div>
			   <div class="weui_dialog_ft">
				   <a href="#" class="weui_btn_dialog primary" id="btn">确定</a>
			   </div>
		   </div>
		</div>
		
		
		
		
		
		<div class="weui_dialog_alert" id="info" style="display:none;">
		   <div class="weui_mask"></div>
		   <div class="weui_dialog">
			   <div class="weui_dialog_hd"><strong class="weui_dialog_title">请输入联系方式</strong></div>
			   <div class="weui_dialog_bd">
					<div class="weui_cell">
						<div class="weui_cell_hd"><label class="weui_label">姓名</label></div>
						<div class="weui_cell_bd weui_cell_primary">
							<input class="weui_input" type="text" id="name1"  placeholder="请输入姓名">
						</div>
					</div>
					<div class="weui_cell">
						<div class="weui_cell_hd"><label class="weui_label">电话</label></div>
						<div class="weui_cell_bd weui_cell_primary">
							<input class="weui_input" type="number" id="tel1" placeholder="请输入电话号码">
						</div>
					</div>
			   </div>
			   
			   <div class="weui_dialog_ft">
				   <a href="javascript:;" class="weui_btn_dialog primary sub" class="sub" data-type="1">确定</a>
               
			   </div>
		   </div>
		</div>
	
	

 <script type="text/javascript" src="<?php echo css_js_url_v2('jquery.min.js', 'fireworks');?>" ></script>
 <script type="text/javascript" src="<?php echo css_js_url_v2('fastclick.js', 'fireworks');?>"></script> 
 <script type="text/javascript" src="<?php echo css_js_url_v2('style.js', 'fireworks');?>" ></script>
 <script type="text/javascript" src="<?php echo css_js_url_v2('jquery.flip.min.js', 'fireworks');?>" ></script>

     <script type="text/javascript">
            $(function() {
                $("#prize li").each(function() {
					
					
                    var p = $(this);
                    var c = $(this).attr('class');
                    p.css("background-color", c);
                    p.click(function() {
						if(parseInt($("#recoder").val()) == 1){
						    tisp("明天再来抽奖");
							return false;
						}
						
						if(parseInt($("#switch").val()) == 0){
						    tisp("活动还没有开始");
							return false;
						}
						
                        $("#prize li").unbind('click'); //连续翻动
                        $.getJSON("/fireworks/get_ajax", function(json) {
							
							if(json.code == 1){
								tisp("你中过奖,不能再抽奖了");
								return false;
							}
							
							if(json.code == 0){
								 setTimeout(function (){
										$("#info").fadeIn();
								}, 2000);
							}
							
							
                            var prize = json.yes; //抽中的奖项 
                            p.flip({
                                direction: 'rl', //翻动的方向rl：right to left 
                                content: prize, //翻转后显示的内容即奖品 
                                color: c, //背景色 
                                onEnd: function() { //翻转结束 
                                    p.css({"font-size": "22px", "line-height": "100px"});
                                    p.attr("id", "r"); //标记中奖方块的id 
                                    $("#viewother").show(); //显示查看其他按钮 
                                    $("#prize li").unbind('click').css("cursor", "default").removeAttr("title");
                                }
                            });
                            $("#data").data("nolist", json.no); //保存未中奖信息 
                        });
                    });
                });

                $("#viewother").click(function() {
                    var mydata = $("#data").data("nolist"); //获取数据 
                    var mydata2 = eval(mydata);//通过eval()函数可以将JSON转换成数组 

                    $("#prize li").not($('#r')[0]).each(function(index) {
                        var pr = $(this);
                        pr.flip({
                            direction: 'bt',
                            color: 'lightgrey',
                            content: mydata2[index], //奖品信息（未抽中） 
                            onEnd: function() {
                                pr.css({"font-size": "22px", "line-height": "100px", "color": "#333"});
                                $("#viewother").hide();
                            }
                        });
                    });
                    $("#data").removeData("nolist");
                });
                
				
				function tisp(info){
					$("#toast").show();
					 $(".toast-info").html(info);
					  setTimeout(function () {
						 $('#toast').hide();
					}, 5000);
				}
            });
        </script>
<?php $this->load->view('common/share_weixin.php')?>
<script type="text/javascript">
$(function(){
	FastClick.attach(document.body);
var Fireworks = function(){
var self = this;
var rand = function(rMi, rMa){return ~~((Math.random()*(rMa-rMi+1))+rMi);}
var hitTest = function(x1, y1, w1, h1, x2, y2, w2, h2){return !(x1 + w1 < x2 || x2 + w2 < x1 || y1 + h1 < y2 || y2 + h2 < y1);};
window.requestAnimFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){window.setTimeout(a,1E3/60)}}();

self.init = function(){ 
self.canvas = document.createElement('canvas');             
self.canvas.width = self.cw = $(".yanhua").innerWidth()-10;
self.canvas.height = self.ch = $(".yanhua").innerHeight()-7;  
       
self.particles = [];    
self.partCount = 150;
self.fireworks = [];    
self.mx = self.cw/2;
self.my = self.ch/2;
self.currentHue = 30;
self.partSpeed = 5;
self.partSpeedVariance = 10;
self.partWind = 50;
self.partFriction = 5;
self.partGravity = 1;
self.hueMin = 0;
self.hueMax = 360;
self.fworkSpeed = 4;
self.fworkAccel = 10;
self.hueVariance = 30;
self.flickerDensity = 25;
self.showShockwave = true;
self.showTarget = false;
self.clearAlpha = 25;


$(".yanhua").append(self.canvas);

self.ctx = self.canvas.getContext('2d');
self.ctx.lineCap = 'round';
self.ctx.lineJoin = 'round';
self.lineWidth = 1;
self.bindEvents();          
self.canvasLoop();

self.canvas.onselectstart = function() {
return false;
};
};      

self.createParticles = function(x,y, hue){
var countdown = self.partCount;
while(countdown--){
var newParticle = {
    x: x,
    y: y,
    coordLast: [
        {x: x, y: y},
        {x: x, y: y},
        {x: x, y: y}
    ],
    angle: rand(0, 360),
    speed: rand(((self.partSpeed - self.partSpeedVariance) <= 0) ? 1 : self.partSpeed - self.partSpeedVariance, (self.partSpeed + self.partSpeedVariance)),
    friction: 1 - self.partFriction/100,
    gravity: self.partGravity/2,
    hue: rand(hue-self.hueVariance, hue+self.hueVariance),
    brightness: rand(50, 80),
    alpha: rand(40,100)/100,
    decay: rand(10, 50)/1000,
    wind: (rand(0, self.partWind) - (self.partWind/2))/25,
    lineWidth: self.lineWidth
};              
self.particles.push(newParticle);
}
};


self.updateParticles = function(){
var i = self.particles.length;
while(i--){
var p = self.particles[i];
var radians = p.angle * Math.PI / 180;
var vx = Math.cos(radians) * p.speed;
var vy = Math.sin(radians) * p.speed;
p.speed *= p.friction;
                
p.coordLast[2].x = p.coordLast[1].x;
p.coordLast[2].y = p.coordLast[1].y;
p.coordLast[1].x = p.coordLast[0].x;
p.coordLast[1].y = p.coordLast[0].y;
p.coordLast[0].x = p.x;
p.coordLast[0].y = p.y;

p.x += vx;
p.y += vy;
p.y += p.gravity;

p.angle += p.wind;              
p.alpha -= p.decay;

if(!hitTest(0,0,self.cw,self.ch,p.x-p.radius, p.y-p.radius, p.radius*2, p.radius*2) || p.alpha < .05){                  
    self.particles.splice(i, 1);    
}
};
};

self.drawParticles = function(){
var i = self.particles.length;
while(i--){
var p = self.particles[i];                          

var coordRand = (rand(1,3)-1);
self.ctx.beginPath();                               
self.ctx.moveTo(Math.round(p.coordLast[coordRand].x), Math.round(p.coordLast[coordRand].y));
self.ctx.lineTo(Math.round(p.x), Math.round(p.y));
self.ctx.closePath();               
self.ctx.strokeStyle = 'hsla('+p.hue+', 100%, '+p.brightness+'%, '+p.alpha+')';
self.ctx.stroke();              

if(self.flickerDensity > 0){
    var inverseDensity = 50 - self.flickerDensity;                  
    if(rand(0, inverseDensity) === inverseDensity){
        self.ctx.beginPath();
        self.ctx.arc(Math.round(p.x), Math.round(p.y), rand(p.lineWidth,p.lineWidth+3)/2, 0, Math.PI*2, false)
        self.ctx.closePath();
        var randAlpha = rand(50,100)/100;
        self.ctx.fillStyle = 'hsla('+p.hue+', 100%, '+p.brightness+'%, '+randAlpha+')';
        self.ctx.fill();
    }   
}
};
};


self.createFireworks = function(startX, startY, targetX, targetY){
var newFirework = {
x: startX,
y: startY,
startX: startX,
startY: startY,
hitX: false,
hitY: false,
coordLast: [
    {x: startX, y: startY},
    {x: startX, y: startY},
    {x: startX, y: startY}
],
targetX: targetX,
targetY: targetY,
speed: self.fworkSpeed,
angle: Math.atan2(targetY - startY, targetX - startX),
shockwaveAngle: Math.atan2(targetY - startY, targetX - startX)+(90*(Math.PI/180)),
acceleration: self.fworkAccel/100,
hue: self.currentHue,
brightness: rand(50, 80),
alpha: rand(50,100)/100,
lineWidth: self.lineWidth
};          
self.fireworks.push(newFirework);

};


self.updateFireworks = function(){
var i = self.fireworks.length;

while(i--){
var f = self.fireworks[i];
self.ctx.lineWidth = f.lineWidth;

vx = Math.cos(f.angle) * f.speed,
vy = Math.sin(f.angle) * f.speed;
f.speed *= 1 + f.acceleration;              
f.coordLast[2].x = f.coordLast[1].x;
f.coordLast[2].y = f.coordLast[1].y;
f.coordLast[1].x = f.coordLast[0].x;
f.coordLast[1].y = f.coordLast[0].y;
f.coordLast[0].x = f.x;
f.coordLast[0].y = f.y;

if(f.startX >= f.targetX){
    if(f.x + vx <= f.targetX){
        f.x = f.targetX;
        f.hitX = true;
    } else {
        f.x += vx;
    }
} else {
    if(f.x + vx >= f.targetX){
        f.x = f.targetX;
        f.hitX = true;
    } else {
        f.x += vx;
    }
}

if(f.startY >= f.targetY){
    if(f.y + vy <= f.targetY){
        f.y = f.targetY;
        f.hitY = true;
    } else {
        f.y += vy;
    }
} else {
    if(f.y + vy >= f.targetY){
        f.y = f.targetY;
        f.hitY = true;
    } else {
        f.y += vy;
    }
}               

if(f.hitX && f.hitY){
    self.createParticles(f.targetX, f.targetY, f.hue);
    self.fireworks.splice(i, 1);
    
}
};
};

self.drawFireworks = function(){
var i = self.fireworks.length;
self.ctx.globalCompositeOperation = 'lighter';
while(i--){
var f = self.fireworks[i];      
self.ctx.lineWidth = f.lineWidth;

var coordRand = (rand(1,3)-1);                  
self.ctx.beginPath();                           
self.ctx.moveTo(Math.round(f.coordLast[coordRand].x), Math.round(f.coordLast[coordRand].y));
self.ctx.lineTo(Math.round(f.x), Math.round(f.y));
self.ctx.closePath();
self.ctx.strokeStyle = 'hsla('+f.hue+', 100%, '+f.brightness+'%, '+f.alpha+')';
self.ctx.stroke();  

if(self.showTarget){
    self.ctx.save();
    self.ctx.beginPath();
    self.ctx.arc(Math.round(f.targetX), Math.round(f.targetY), rand(1,8), 0, Math.PI*2, false)
    self.ctx.closePath();
    self.ctx.lineWidth = 1;
    self.ctx.stroke();
    self.ctx.restore();
}
    
if(self.showShockwave){
    self.ctx.save();
    self.ctx.translate(Math.round(f.x), Math.round(f.y));
    self.ctx.rotate(f.shockwaveAngle);
    self.ctx.beginPath();
    self.ctx.arc(0, 0, 1*(f.speed/5), 0, Math.PI, true);
    self.ctx.strokeStyle = 'hsla('+f.hue+', 100%, '+f.brightness+'%, '+rand(25, 60)/100+')';
    self.ctx.lineWidth = f.lineWidth;
    self.ctx.stroke();
    self.ctx.restore();
}
};
};

self.bindEvents = function(){
$(window).on('resize', function(){          
clearTimeout(self.timeout);
self.timeout = setTimeout(function() {
    self.canvas.width = self.cw = $(".yanhua").innerWidth();
    self.canvas.height = self.ch = $(".yanhua").innerHeight()-7;
    self.ctx.lineCap = 'round';
    self.ctx.lineJoin = 'round';
}, 100);
});

$(".next").click(function(){
	clearInterval(m);
	
		
	 	var pro = parseInt($(".progress").css("padding-top"));
	 	var height =  parseInt($(".progress").css("height"));
	 
	 	var gameHeight =  parseInt($(".pro-color").css("height"));
	 	
	 	var  perTxt=  parseInt($("#per").html());
	 	
	 	//判断是否已经到100%
	 	if((gameHeight/(height+pro)).toFixed(2) <=0.96 ){
	 		pro -= 6;
	 		height += 6; 
	 		$(".progress").css({
	 			"padding-top":pro+"px",
	 			"height":height+"px"
	 		});
	 		
	 		if(perTxt <= 100){
	 			//$("#per").html(percent+"%");
	 			percent = parseInt(gameHeight/(height+pro)*100);
	 			$("#per").html(percent+"%");
	 		}
	 		
	 		
	 	}else
	 	{
			//$(".next").hide();
			var n = height+pro ;
			$(".progress").css({
	 			"padding-top":0+"px",
	 			"height":n+"px"
	 		});
			var audio = document.getElementById('bgaudio'); 
			  audio.play();// 播放
			var n = 1;  
			var m = setInterval(function(){
				if(n == 10){
					clearInterval(m);
					audio.pause();// 暂停
					$("#msg").html("蓄力成功，点击确定去抽奖！");
					$("#tips").show();
				}
				self.mx = GetRandomNum(100,$(".yanhua").innerWidth()-100); 
				self.my = GetRandomNum(1,$(".yanhua").innerHeight()/2);
				self.currentHue = GetRandomNum(self.hueMin, self.hueMax);
				self.createFireworks(self.cw/2, self.ch, self.mx, self.my);                     	 	
				n++;
			
			},800);
	 		$("#per").html(100+"%"); 
	 	}
	 
	 	
	
});


$(self.canvas).on('mouseup', function(e){
$(self.canvas).off('mousemove.fireworks');                                  
});
        
}

self.clear = function(){
self.particles = [];
self.fireworks = [];
self.ctx.clearRect(0, 0, self.cw, self.ch);
};


self.canvasLoop = function(){
requestAnimFrame(self.canvasLoop, self.canvas);         
self.ctx.globalCompositeOperation = 'destination-out';
self.ctx.fillStyle = 'rgba(0,0,0,'+self.clearAlpha/100+')';
self.ctx.fillRect(0,0,self.cw,self.ch);
self.updateFireworks();
self.updateParticles();
self.drawFireworks();           
self.drawParticles();

};

self.init();        

}
var fworks = new Fireworks();


function GetRandomNum(Min,Max)
{   
	var Range = Max - Min;   
	var Rand = Math.random();   
	return(Min + Math.round(Rand * Range));   
}   

});

</script>
	</body>
</html>
