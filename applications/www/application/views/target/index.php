<!DOCTYPE hmtl>
<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>爱在2017，说出你心中的话</title>
		<script type="text/javascript" charset="UTF-8" src="/static/target/js/rem.js"></script>
		<link rel="stylesheet" charset="UTF-8" type="text/css" href="/static/target/css/base.css"  />
		<link rel="stylesheet" charset="UTF-8" type="text/css" href="/static/target/css/style.css"  />
		<script src="/static/target/js/jweixin-1.0.0.js" type="text/javascript"></script>
		<script type="text/javascript" charset="UTF-8" src="/static/target/js/jquery.js" ></script>
		<script>
		var arrCircle = ["/static/target/images/circle1.png","/static/target/images/circle2.png", "/static/target/images/circle3.png", "/static/target/images/circle4.png", "/static/target/images/circle5.png"];
			var arrBgMid = ["/static/target/images/paper-m1.png", "/static/target/images/paper-m2.png", "/static/target/images/paper-m3.png", "/static/target/images/paper-m4.png"];
			var arrBgBig = ["/static/target/images/paper-d1.png", "/static/target/images/paper-d2.png", "/static/target/images/paper-d3.png", "/static/target/images/paper-d4.png"];
			var arrDing = ["/static/target/images/ding1.png", "/static/target/images/ding2.png", "/static/target/images/ding3.png", "/static/target/images/ding4.png", "/static/target/images/ding5.png"];
			var arrLike = ["/static/target/images/like1.png", "/static/target/images/like4.png", "/static/target/images/like5.png"];
			var nick = "";
			var click = 0;
			var randomMg = [{
				"b": "-4rem",
				"lr": "0.5rem"
			}, {
				"b": "-4rem",
				"lr": "0.3rem"
			}, {
				"b": "-3rem",
				"lr": "0.4rem"
			}, {
				"b": "-2rem",
				"lr": "0.2rem"
			}, {
				"b": "-2.5rem",
				"lr": "0rem"
			}, {
				"b": "-4.5rem",
				"lr": "0rem"
			}];
	      var userinfo={
			  name:'<?php echo $user['nickname'];?>',
			  headimage:'<?php echo $user['headimgurl'];?>'
			  };
		var count = 0;
		
		function setCookie(name, value) {
			var Days = 1000;
			var exp = new Date();
			exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
			document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
		}

		function getCookie(name) {
			var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
			if (arr = document.cookie.match(reg))
				return unescape(arr[2]);
			else
				return null;
		}
		
		var iniWeixinShare = {
			title:'爱在2017，说出你心中的话',
			desc:'爱在2017，说出你心中的话',
			link:'http://h5.wesogou.com/target',
			logo:'http://h5.wesogou.com/static/target/images/logo.jpg'
		};
		//share();
		</script>
	
		
	</head>

	<body>
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
		<div class="fullpage page1">
			
			<div class="btn-group">
				<a href="javascript:;" onclick='goEdit()'><img src="/static/target/images/goedit.png"></a>
				<a href="javascript:;" onclick='goList()'><img src="/static/target/images/golist.png"></a>
			</div>
			<div id='targetCount'>
			</div>
		</div>
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
		<div class='page2' style="display: none;">
			<div class="inner">
				<div id='targetCount2' style="font-family: 微软雅黑;">
				</div>
				<div class="btn-group">
					<a href="javascript:;" onclick='hotTarget()'>最新的</a>
					<a href="javascript:;" onclick='newTarget()'>大家的</a>
					<a href="javascript:;" onclick='myTarget()'>我写的</a>
				</div>
				<div class="list-msg" id='list-msg' onscroll="listscroll()">
				</div>
				<div class="btn-more" href="javascript:;" onclick='getMore()' >点击加载更多</div>
				<a href="javascript:;" onclick='goEdit2()' class="btn-fix"></a>
			</div>
		</div>
		<script>
			$.get('/target/allcount',function (res) {
				if (res) {
					window.count = parseInt(res);
					$('#targetCount2').html('爱之屋语墙<br>'+res+'条');
				}
			})
			
		</script>
		<!-- 编写页 -->
		<div class='fullpage page3' style="display: none;">
			<img class="mask" src="/static/target/images/page2.jpg" />
			<img class="bg" src="/static/target/images/paper-d1.png" />
			<img class="placeholder" src="/static/target/images/draw-txt.png"/>
			<div class="canvas">
				<div id='upcanvas' class="js-signature" data-width="600" data-height="200" data-line-color="#000" data-auto-fit="true"></div>
				<div id='downcanvas' class="js-signature" data-width="600" data-height="200" data-auto-fit="true"></div>
			</div>
			<div class="canvas-btn">
				<button id="colorBtn" onclick="changeImg()">变色</button>
				<button id="clearBtn" onclick="clearCanvas();">清空</button>
				<button id="backBtn" onclick="backSignature();">撤销</button>
				<button id="saveBtn" onclick="saveSignature();">生成</button>
			</div>
		</div>
		<!-- 生成页 -->
		<style>
		.page4 .dianzan4{
		    position: absolute;
		    width: 0rem;
		    height: 0.5rem;
		    line-height: 0.5rem;
		    right: 2.2rem;
		    top: 30%;
		    z-index: 999;
		    font-size: 13px;
		    text-align: right;
		    padding-left: 0.7rem;
		    color: #845531;
		    font-weight: 300;
		    background: url("/static/target/images/like1.png") no-repeat;
		    background-size: contain;
		}
		.page4 .dianzan4 .on{
			background: url("/static/target/like-on.png") no-repeat;
			color: #000;
		}
		#toastMess{
			width: 5rem;
		    height: 1rem;
		    text-align: center;
		    position: fixed;
		    font-size: 0.3rem;
		    left: 1.25rem;
		    border-radius: 5px;
		    top: 45%;
		    line-height: 1rem;
		    background: #000;
		    color: #fff;
		    z-index: 99999;
		}
		</style>
		<div class='fullpage page4' style="display: none;">
			<!--<img class="top" src="/static/target/images/page4-top.png" />
			<img class="bot" src="/static/target/images/page4-bot.png" />-->
			<img class="light" src="/static/target/images/light-home.png" />
			<img class="mask" src="/static/target/images/page4.jpg" />

			<div class="dianzan4"></div>
			<div class="btn-group" style='bottom:0rem;'>
				<a href="javascript:;" onclick="goHome();">返回首页</a>
				<a href="javascript:;" onclick="goList()">看大家的</a>
			</div>
			<div class="canvas-ok-wrap">
				<canvas id="canvas-ok" style="width: 5.6rem; height: 7.22rem;" width="560" height="722"></canvas>
			</div>
	
	</body>

	
	<script>

		var screenWidth = window.document.body.clientWidth;
		var screenHeight = window.document.body.clientHeight;
		$('.fullpage').css({
			width: screenWidth,
			height: screenHeight
		});
		function goHome() {
			window.location.hash = '';
			$('.page1').show();
			$('.page3').hide();
			$('.page4').hide();
			$('.page2').hide();
			
			 
		}
		function goList() {
			window.location.hash = '';
			
			$('.page1').hide();
			$('.page3').hide();
			$('.page4').hide();
			$('.page2').show();
			listDateLoad(0,'new');
			
		}

		function goEdit() {
		
				$('.page1').hide();
				$('.page3').show();
				if($('.js-signature').length) {
					$('.js-signature').jqSignature();
					clearCanvas()
					$(".page3 .bg").attr("src",arrBg[randomNum(0, 4)]);
				}

		}
		function goEdit2() {
		
		        $('.page2').hide();
				$('.page3').show();
				if($('.js-signature').length) {
					$('.js-signature').jqSignature();
					clearCanvas()
					$(".page3 .bg").attr("src",arrBg[randomNum(0, 4)]);
				}

		}
		function hotTarget(){
			listDateLoad(0,'hot')
		}
		function newTarget(){
			listDateLoad(0,'new')
		}
		function myTarget(){
			listDateLoad(0,'my')
		}
//分享链接判断
var projectNum = window.location.hash;
if (projectNum) {
	toPage4(projectNum.substr(1))
};
function toPage4(id){
    console.log(id)
	$('.page1').hide();
	$('.page3').hide();
	$('.page4').show();
	$('.page2').hide();
	$.get('targetDetail?id='+id,function (res) {
		//参数:索引,头像地址,数字,标题,图片
		res=JSON.parse(res);
		drawPaper(1,res.headimage,res.like_count,res.name+' 的爱之印记',res.target_img)
		$('.dianzan4').addClass('on');
    	$('.dianzan4').html(res.like_count);
		if (getCookie('liked'+id)) return false;
			$('.dianzan4').removeClass('on');
		    $('.dianzan4').on('click',function (e) {
		    	$.get('clickLike?id='+id,function(){
		    	$('.dianzan4').addClass('on');
		    	var num = $('.dianzan4').html();
		    	num++;
		    	$('.dianzan4').html(num);
		    	$('.dianzan4').off('click');
		    })
	    })
	})
}



var index=1;
var listtype = 'new';
function getMore(){
	
	listDateLoad(index,listtype);
}
function listDateLoad(index,type){
	listtype = type;
    $.get('/target/targetList?offset='+index+"&type="+type,function(res){
        var html='';
		
        for (var i = 0; i < res.length; i++) {
            html = html + data2html(res[i]);
        }
        if (index!==0) {
            $('#list-msg').append(html);
        }else {
            $('#list-msg').html(html);
        }
        window.index++;
    });
}

function data2html(obj){
    var liked = 'like';
   // if (getCookie('liked'+obj.id)) {liked = 'like on';}
    var html='<div id="'+"id"+obj.id+'" class="msg bg'+Math.floor(Math.random()*5+1)+'"><img class="tx" src="'+obj.headimage+'" alt="" /><span class="ding"></span><span onclick="dianzan('+obj.id+')" class="'+liked+'"><b></b><s>'+obj.like_count+'</s></span><div class="msg-con"><a id="'+"link"+obj.id+'"  href="javascript:;" onclick="onShow(this);" href="#"><h4>'+obj.name+'的<span>的爱之印记</span></h4><img  src="'+obj.target_img+'" /></a></div></div>';
    return html;
}

function dianzan(id){
    console.log(id);
	if (getCookie('liked'+id)) return false;
    setCookie(('liked'+id),1);
    $.get('/target/clickLike?id='+id,function(){
    	$('#id'+id+' .like').addClass('on');
    	var num = $('#id'+id+' .like s').html();
    	num++;
    	$('#id'+id+' .like s').html(num);
    })
}


function onShow(that) {
	return ;
	var obj = $(that);
	var $class = (obj.parent().parent().attr("class")).toString();
	var $idx = parseInt($class.substr($class.length - 1, 1)) - 1;
	var $h4 = obj.find("h4").text();
	var $img = obj.find("img").attr("src");
	var $like = obj.parent().parent().find(".like s").text();
	var $tx = obj.parent().parent().find(".tx").attr("src");
	console.log($tx)
	$(".page1,.page2,.page3,.page4").hide();
	$(".page4").show();
	
	showdianzan4($class,$like,that);
	window.iniWeixinShare = {
		title:that.innerText,
		title1:that.innerText, 
		desc:'2017年把爱说出来',
		link:'http://h5.wesogou.com/target',
		logo:'http://h5.wesogou.com/target/static/target/images/logo.jpg'
	};
	//参数:索引,头像地址,数字,标题,图片
	drawPaper($idx,$tx,$like,$h4,$img)

}


	</script>
	<script>
	
		$('.js-signature')[0].dataset.width = screenWidth - screenWidth*0.2;
		$('.js-signature')[0].dataset.height = screenHeight - screenHeight*0.28;
		$('.js-signature')[1].dataset.width = screenWidth - screenWidth*0.2;
		$('.js-signature')[1].dataset.height = screenHeight - screenHeight*0.28;

		$('.js-signature').css({
			"margin-left": -(screenWidth - screenWidth*0.2) / 2
		})
		$('.canvas').css({
			"width": screenWidth - screenWidth*0.2,
			"height": screenHeight - screenHeight*0.28,
			top: "8%"
		});

		//跳转展示页并绘制paper
//$idx,$tx,$like,$h4,$img
function drawPaper($idx,$tx,$like,$h4,$img) {
	var loader = new PxLoader(),
		paper = loader.addImage(arrBgMid[$idx]),
		ding = loader.addImage(arrDing[randomNum(0, 4)]),
		txt = loader.addImage($img),
		tx = loader.addImage($tx),
		maskTx = loader.addImage(arrCircle[$idx]);
		// like = loader.addImage(arrLike[$idx]);

	loader.addCompletionListener(function() {
		var canvas = document.getElementById('canvas-ok'),
			ctx = canvas.getContext('2d');
		ctx.drawImage(paper, 0, 0, 560, 722);
		ctx.drawImage(ding, 280, 20, 42, 70);
		ctx.drawImage(txt, 95, 210, 380, 380);
		ctx.drawImage(tx, 95, 55, 75, 75);
		ctx.drawImage(maskTx, 95, 55, 75, 75);
		// ctx.drawImage(like, 300, 80, 42, 43);

		ctx.font = '24px Helvetica';
		ctx.textAlign = 'center';
		ctx.fillText($h4, (canvas.width / 2), 160);

		ctx.font = '24px Helvetica';
		ctx.textAlign = 'right';
		// ctx.fillText($like, canvas.width - 100, 110);
	})
	loader.start();
}

		(function(window, document, $) {
			'use strict';
			var speed = 5;
			var lasttime;
			// Get a regular interval for drawing to the screen
			window.requestAnimFrame = (function(callback) {
				return window.requestAnimationFrame ||
					window.webkitRequestAnimationFrame ||
					window.mozRequestAnimationFrame ||
					window.oRequestAnimationFrame ||
					window.msRequestAnimaitonFrame ||
					function(callback) {
						window.setTimeout(callback, 1000 / 60);
					};
			})();

			/*
			 * Plugin Constructor
			 */

			var pluginName = 'jqSignature',
				defaults = {
					lineColor: '#222222',
					lineWidth: speed,
					width: 300,
					height: 100,
					autoFit: false
				},
				canvasFixture = '<canvas></canvas>';

			function Signature(element, options) {
				// DOM elements/objects
				this.element = element;
				this.$element = $(this.element);
				this.canvas = false;
				this.$canvas = false;
				this.ctx = false;
				// Drawing state
				this.drawing = false;
				this.currentPos = {
					x: 0,
					y: 0
				};
				this.lastPos = this.currentPos;
				// Determine plugin settings
				this._data = this.$element.data();
				this.settings = $.extend({}, defaults, options, this._data);
				// Initialize the plugin
				this.init();
			}

			Signature.prototype = {
				// Initialize the signature canvas
				init: function() {
					// Set up the canvas
					this.$canvas = $(canvasFixture).appendTo(this.$element);
					this.$canvas.attr({
						width: this.settings.width,
						height: this.settings.height
					});
					this.$canvas.css({
						boxSizing: 'border-box',
						width: this.settings.width + 'px',
						height: this.settings.height + 'px',
						border: this.settings.border,
						cursor: 'crosshair'
					});
					// Fit canvas to width of parent
					if(this.settings.autoFit === true) {
						this._resizeCanvas();
						// TO-DO - allow for dynamic canvas resizing 
						// (need to save canvas state before changing width to avoid getting cleared)
						// var timeout = false;
						// $(window).on('resize', $.proxy(function(e) {
						//   clearTimeout(timeout);
						//   timeout = setTimeout($.proxy(this._resizeCanvas, this), 250);
						// }, this));
					}
					this.canvas = this.$canvas[0];
					this._resetCanvas();
					// Set up mouse events
					this.$canvas.on('mousedown touchstart', $.proxy(function(e) {
						this.drawing = true;
						this.lastPos = this.currentPos = this._getPosition(e);
						lasttime = e.timeStamp * 1000;
					}, this));
					this.$canvas.on('mousemove touchmove', $.proxy(function(e) {
						this.currentPos = this._getPosition(e);
						var tspeed = ((this.currentPos.x - this.lastPos.x) * (this.currentPos.x - this.lastPos.x) + (this.currentPos.y - this.lastPos.y) * (this.currentPos.y - this.lastPos.y)) / (e.timeStamp * 1000 - lasttime) / (e.timeStamp * 1000 - lasttime);
						tspeed = Math.floor(Math.sqrt(tspeed) * 6000);

						tspeed = 5 - tspeed;
						if(tspeed > 2) {
							speed = tspeed;
						} else {
							speed = 2;
						}
						console.log(speed);
						lasttime = e.timeStamp * 1000;
					}, this));
					this.$canvas.on('mouseup touchend', $.proxy(function(e) {
						lasttime = 0;
						this.drawing = false;
						// Trigger a change event
						var changedEvent = $.Event('jq.signature.changed');
						this.$element.trigger(changedEvent);
					}, this));
					// Prevent document scrolling when touching canvas
					$(document).on('touchstart touchmove touchend', $.proxy(function(e) {
						if(e.target === this.canvas) {
							e.preventDefault();
						}
					}, this));
					// Start drawing
					var that = this;
					(function drawLoop() {
						window.requestAnimFrame(drawLoop);
						that._renderCanvas();
					})();
				},
				// Clear the canvas
				clearCanvas: function() {
					this.canvas.width = this.canvas.width;
					this._resetCanvas();
				},
				// Get the content of the canvas as a base64 data URL
				getDataURL: function() {
					return this.canvas.toDataURL();
				},
				setColor: function(color) {
					this.settings.lineColor = color;
				},
				// Get the position of the mouse/touch
				_getPosition: function(event) {
					var xPos, yPos, rect;
					rect = this.canvas.getBoundingClientRect();
					event = event.originalEvent;
					// Touch event
					if(event.type.indexOf('touch') !== -1) { // event.constructor === TouchEvent
						xPos = event.touches[0].clientX - rect.left;
						yPos = event.touches[0].clientY - rect.top;
					}
					// Mouse event
					else {
						xPos = event.clientX - rect.left;
						yPos = event.clientY - rect.top;
					}
					return {
						x: xPos,
						y: yPos
					};
				},
				// Render the signature to the canvas
				_renderCanvas: function() {

					if(this.drawing) {
						// this.ctx.beginPath();
						this.ctx.lineWidth = speed;
						this.ctx.lineCap = 'round';
						this.ctx.strokeStyle = this.settings.lineColor;
						this.ctx.moveTo(this.lastPos.x, this.lastPos.y);
						this.ctx.lineTo(this.currentPos.x, this.currentPos.y);
						// this.ctx.closePath();
						this.ctx.stroke();
						this.lastPos = this.currentPos;
					}
				},
				// Reset the canvas context
				_resetCanvas: function() {
					this.ctx = this.canvas.getContext('2d');
					this.ctx.strokeStyle = this.settings.lineColor;
				},
				// Resize the canvas element
				_resizeCanvas: function() {
					var width = this.$element.outerWidth();
					this.$canvas.attr('width', width);
					this.$canvas.css('width', width + 'px');
				}
			};

			/*
			 * Plugin wrapper and initialization
			 */

			$.fn[pluginName] = function(options) {
				var args = arguments;
				if(options === undefined || typeof options === 'object') {
					return this.each(function() {
						if(!$.data(this, 'plugin_' + pluginName)) {
							$.data(this, 'plugin_' + pluginName, new Signature(this, options));
						}
					});
				} else if(typeof options === 'string' && options[0] !== '_' && options !== 'init') {
					var returns;
					this.each(function() {
						var instance = $.data(this, 'plugin_' + pluginName);
						if(instance instanceof Signature && typeof instance[options] === 'function') {
							returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
						}
						if(options === 'destroy') {
							$.data(this, 'plugin_' + pluginName, null);
						}
					});
					return returns !== undefined ? returns : this;
				}
			};

		})(window, document, jQuery);
	</script>
	<script type="text/javascript">
		$(document).on('ready', function() {

		});

		function clearCanvas() {
			drawHistory = [];
			el1.jqSignature('clearCanvas');
			$('#saveBtn').attr('disabled', true);
		}

		function changeImg() {
			click++
			$(".page3 .bg").attr("src",arrBg[click])
			if(click==5)click=0;
		}
		var el = $('.js-signature').eq(0);
		var el1 = $('.js-signature').eq(1);
		var img = $('<img>');

		var limitflag = 1;
		function saveSignature() {
			if (!limitflag) return false;
			limitflag = 0;
			setTimeout(function () {
				limitflag = 1;
			},1000);
			var dataUrl = el1.jqSignature('getDataURL');
			$.post('/target/publish_target',{
				data:dataUrl,
				headimage:"<?php echo $user['headimgurl'];?>",
				name:"<?php echo $user['nickname'];?>",
				openid:"<?php echo $user['openid'];?>",
			},function(res){
				saveSignature2(res);
				iniWeixinShare = {
					title:userinfo.name+'的2017想说的话',
					desc:'爱在2017，说出你心中的话……',
					link:'http://h5.wesogou.com/target',
					logo:'http://h5.wesogou.com/static/target/images/logo.jpg'
				};
				share();
			})
		}
function showdianzan4(id,tx,obj) {
	var id ;
    if (id>0) {
    	$('.dianzan4').html(0);
    	id = id;
    	toastMess('2017年心中话已说出来，赶紧晒晒吧！')
    }else{
    	$('.dianzan4').addClass(id);
    	$('.dianzan4').html(tx);
    	id = obj.id.split('link')[1];
    }
	    $('.dianzan4').on('click',function (e) {
	    	$.get('/target/clickLike?id='+id,function(){
	    	$('.dianzan4').addClass('on');
	    	var num = $('.dianzan4').html();
	    	num++;
	    	$('.dianzan4').html(num);
	    	$('.dianzan4').off('click');
	    })
    })
}
function toastMess(str) {
	var html = "<div id='toastMess'>"+str+"<div>"
	$('body').append(html);
	$('#toastMess').animate({opacity:0},2500);
	setTimeout(function () {
		$('#toastMess').remove();
	},2500)
}
function saveSignature2(res) {
	$('#signature').empty();
	var dataUrl = el1.jqSignature('getDataURL');

	$(".page1,.page2,.page3,.page4").hide();
	$(".page4").show();
	showdianzan4(res);
	var loader = new PxLoader(),
		paper = loader.addImage(arrBgMid[click]),
		ding = loader.addImage(arrDing[randomNum(0, 4)]),
		txt = loader.addImage(dataUrl),
		tx = loader.addImage(userinfo.headimage);

	loader.addCompletionListener(function() {
		var canvas = document.getElementById('canvas-ok'),
			ctx = canvas.getContext('2d');
		ctx.drawImage(paper, 0, 0, 560, 722);
		ctx.drawImage(ding, 280, 20, 42, 70);
		ctx.drawImage(txt, 95, 210, 380, 380);
		ctx.drawImage(tx, 95, 55, 75, 75);

		ctx.font = '24px Helvetica';
		ctx.textAlign = 'center';
		ctx.fillText(userinfo.name+"的爱之印记", canvas.width / 2, 170);

		ctx.font = '24px Helvetica';
		ctx.textAlign = 'right';

	});
	loader.start();
}

		function drawimg(img) {
			var mycv = $('#downcanvas canvas')[0];
			var myctx = mycv.getContext('2d');
			myctx.drawImage(img, 0, 0);
			var dataUrl = el1.jqSignature('getDataURL');
			drawHistory.push(dataUrl);
		}

		var drawHistory = [];

		function backSignature() {
			if(drawHistory.length > 1) {
				drawHistory.pop();
				var dataUrl = drawHistory[(drawHistory.length - 1)];
				drawHistory.pop();
				el1.jqSignature('clearCanvas');
				var img = new Image();
				img.src = dataUrl;
				img.onload = function() {
					drawimg(img);
				};
			} else {
				drawHistory = [];
				el1.jqSignature('clearCanvas');
			}
		}

		function changeColor() {
			var arr = ['#000', '#ff0000', '#00ff00', '#0000ff'];
			el.jqSignature('setColor', arr[Math.floor(Math.random() * 4)]);
		}

		el.on('jq.signature.changed', function() {
			$('#saveBtn').attr('disabled', false);
			$('#backBtn').attr('disabled', false);
			var dataUrl = el.jqSignature('getDataURL');
			el.jqSignature('clearCanvas');
			var img = new Image();
			img.src = dataUrl;
			img.onload = function() {
				drawimg(img);
			};
		});
	</script>
	<script type="text/javascript">
		var arrBg = ["/static/target/images/paper-d1.png", "/static/target/images/paper-d2.png", "/static/target/images/paper-d3.png", "/static/target/images/paper-d4.png"];
		var click=0;
		var randomMg = [{
			"b": "-4rem",
			"lr": "0.5rem"
		}, {
			"b": "-4rem",
			"lr": "0.3rem"
		}, {
			"b": "-3rem",
			"lr": "0.4rem"
		}, {
			"b": "-2rem",
			"lr": "0.2rem"
		}, {
			"b": "-2.5rem",
			"lr": "0rem"
		}, {
			"b": "-4.5rem",
			"lr": "0rem"
		}];
		var randomMgLen = randomMg.length - 1;

		function randomNum(x, y) {
			return Math.floor(Math.random() * (y + 1 - x) + x);
		};
		$(function() {

			$(".list-msg .msg").each(function(i) {
				$(this).find(".ding").addClass("d" + randomNum(1, 5));
				if(i % 2 == 0) {
					$(this).css({
						"margin-left": randomMg[randomNum(0, randomMgLen)].lr,
						"margin-bottom": randomMg[randomNum(0, randomMgLen)].b
					})
				} else {
					$(this).css({
						"margin-right": randomMg[randomNum(0, randomMgLen)].lr,
						"margin-bottom": randomMg[randomNum(0, randomMgLen)].b
					})
				}
			});
			$(".like").on("click", function() {
				var status = $(this).hasClass("on");
				var num = parseInt($(this).find("s").html());
				console.log(num)
				if(status) {
					$(this).removeClass("on")
					num--

				} else {
					$(this).addClass("on")
					num++
				}
				$(this).find("s").html(num)
			});
			$(".page3").on("touchstart",function(){
				$(this).find(".placeholder").hide();
			})
		})
	</script>

	<script src="/static/target/js/PxLoader.js"></script>
	<script src="/static/target/js/PxLoaderImage.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>


	function share(){
			wx.config({
		debug:false,
		appId: "<?php echo $signPackage['appId'];?>",
		timestamp:"<?php echo $signPackage['timestamp'];?>",
		nonceStr: "<?php echo $signPackage['nonceStr'];?>",
		signature: "<?php echo $signPackage['signature'];?>",
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage']
	});

	wx.ready(function () {
		wx.checkJsApi({
			jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
			success: function(res) {
				//alert(JSON.stringify(res));
			}
		});
		wx.error(function(res){
			console.log('err:'+JSON.stringify(res));
			// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

		});
		
		//分享给朋友
		wx.onMenuShareAppMessage({
			title: iniWeixinShare.title, // 分享标题
			desc: iniWeixinShare.desc, // 分享描述
			link: iniWeixinShare.link, // 分享链接
			imgUrl: iniWeixinShare.logo, // 分享图标
			type: 'link', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
			},
			cancel: function () { 
				
			}
		});
		//分享到朋友圈
		wx.onMenuShareTimeline({
			title: iniWeixinShare.title, // 分享标题
			link: iniWeixinShare.link, // 分享链接
			imgUrl: iniWeixinShare.logo, // 分享图标
			success: function () { 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
	});
	}
	share();
	</script>
	<audio src="/static/target/bg.mp3" autoplay="autoplay" loop="loop" id="bgaudio"></audio>
<script> 
     //一般情况下，这样就可以自动播放了，但是一些奇葩iPhone机不可以 
     document.getElementById('bgaudio').play(); 
    //必须在微信Weixin JSAPI的WeixinJSBridgeReady才能生效 
    document.addEventListener("WeixinJSBridgeReady", function () { 
        document.getElementById('bgaudio').play(); 
        document.getElementById('bgaudio').play(); 
    }, false); 
</script>
</html>
