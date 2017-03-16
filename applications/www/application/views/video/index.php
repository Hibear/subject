<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>信仰会一直在空中飘扬</title>
		<meta name="format-detection" content="telephone=no" />
		<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0' />
		<meta name="author" content="lyonho" />
		<meta name="date" content="" />
		<link rel="stylesheet" href="http://wesogou.com/gyhouse/bgy/css/custom.css" />
		<link rel="stylesheet" href="http://wesogou.com/gyhouse/bgy/css/layout.css" />
		<link rel="stylesheet" href="http://wesogou.com/gyhouse/bgy/css/animate.css" />
		<style>
		.next-msg{ 
			width: 100%;
			position: absolute;
			height: 50px;
			left: 0;
			top: 38%;
			
			z-index: 99;
			background-position-x: 5px;
			display: none;
		}
		.next-msg img{ width:100%}
		.hand{
			width: 2rem;
			height: 3.5rem;
			position: absolute;
			left: 51%;
			top: 46%;
			z-index: 9999;
			display:none;
		}
		</style>
		<script>
        var browser = {
            versions: function () {
                var u = navigator.userAgent, app = navigator.appVersion;
                return {
                    webKit: u.indexOf('AppleWebKit') > -1,
                    ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                    weixin: u.indexOf('MicroMessenger') > -1,
                    txnews: u.indexOf('qqnews') > -1,
                    sinawb: u.indexOf('weibo') > -1,
                    mqq: u.indexOf('QQ') > -1
                };
            } (),
            language: (navigator.browserLanguage || navigator.language).toLowerCase()
        };
    </script>
	</head>
	<body style="background:#000;">
	<div class="progress">
		<div class="progressbar"></div>
		<div class="text">0%</div>
		<div class="progresstext">
			<span class="current"></span>
			<span class="total"></span>
		</div>
	</div>
	
    <!--loading-->
	    <div id="loading"></div>
	    <div class="next-msg"><img src="http://wesogou.com/gyhouse/bgy/img/weixin.png"></div>
		
	  <div class="vid-wrappper" style="display: none;">
        <video id="vid1" class="vid" preload="auto" x-webkit-airplay="true" playsinline="true"
            webkit-playsinline="true" src="http://wesogou.com/gyhouse/bgy/vid3.MP4"></video>
    </div>
    
   <div class="lastP-1 page" ></div>
	<div class="lastP-2 page" ></div>
	<div class="lastP-4 animated pulse infinite page" ></div>
	<div class="lastP-5 page"></div>
	
	<div class="hand animated pulse infinite"><img src="http://wesogou.com/gyhouse/bgy/img/btn.png"></div>
    <script type="text/javascript" src="http://wesogou.com/gyhouse/bgy/js/jquery-1.11.3.min.js" ></script>
	<script src="http://wesogou.com/gyhouse/bgy/js/resLoader.js"></script>
   
	
	 <script>
		
        var loader = new resLoader({
				resources : [
					'http://wesogou.com/gyhouse/bgy/img/loadBg.jpg',
					'http://wesogou.com/gyhouse/bgy/img/btn.png',
					'http://wesogou.com/gyhouse/bgy/img/weixin.png',
					'http://wesogou.com/gyhouse/bgy/img/bg.jpg',
				//	'http://wesogou.com/gyhouse/bgy/vid1.MP4'
				],
				onStart : function(total){
					console.log('start:'+total);
				},
				onProgress : function(current, total){
					console.log(current+'/'+total);
					var percent = current/total*100;
					$('.progressbar').css('width', percent+'%');
					$('.text').text(percent+"%");
				},
				onComplete : function(total){
					$(".progress").fadeOut();
					$(".hand").fadeIn(2000);
					$(".next-msg").show(1000);
					$("#loading").show();
				}
			});

			loader.start();
		     var vid1 = document.getElementById("vid1");
			 if (browser.versions.ios) {
                   
				$(".next-msg").click(function () {
					$("#loading").fadeOut();
					$(".next-msg,.hand").hide();
					$(".vid-wrappper").show();
					vid1.play();
				});
				vid1.onended = function() {
					$(".vid-wrappper").fadeOut();
					$(".page").fadeIn();
					
				}
				vid1.ontimeupdate = function() {
					 if(vid1.currentTime>95){
						 $("#vid1").hide();
						window.location = "http://h5.wesogou.com/video/android";
					 }
				};
            } else {
                
				$(".next-msg").click(function () {
					$("#loading").fadeOut();
					$(".vid-wrappper").show();
					vid1.play();
					$(".next-msg,.hand").hide();
				});
				
				vid1.onended = function() {
					$(".vid-wrappper").fadeOut();
					$(".lastP").fadeIn();
					window.location = "http://h5.wesogou.com/video/android";
				}
				
				$("#vid1").on('timeupdate', function () {
					console.log(this.currentTime);
					if (this.currentTime > 94) {
						$("#vid1").hide();
						window.location = "http://h5.wesogou.com/video/android";
                    }
				});
                
            
        };
		
    </script>
<?php $this->load->view('common/share_common.php')?>
	</body>
</html>
