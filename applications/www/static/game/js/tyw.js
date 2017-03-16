/*
 * Version: 0.0.2
 * Author: tyw
 * Create: 2016-06-17
 * Update: 2016-09-09
 * 修改记录：
 * 2016-08-02:1、更新rem计算，2、去掉流量统计，3、去掉音乐配置，配置文件在foot添加
 */
//移动端优化
(function () {
  var docEl = document.documentElement;
  resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
  recalc = function () {
    var clientWidth = docEl.clientWidth;
    if (!clientWidth) return;
    docEl.style.fontSize = clientWidth / 6.4 + 'px';
  };
  if (!document.addEventListener) return;
  window.addEventListener(resizeEvt, recalc, false);
  document.addEventListener('DOMContentLoaded', recalc, false);
})();
function load(manifest,callback){
	for (var i = 0 ; i < manifest.length ; i++) {
		var images = [];
		var count = 0;
		images[i] = new Image();
		images[i].src = "images/"+manifest[i].src;
		images[i].classname = manifest[i].class;
		images[i].onload = function (){
			count++;
			var itemClass = this.classname;
			//进度
			var progress = parseInt(count/manifest.length*100);
			$(".jindu").text(progress+"%");
			if(itemClass){
				var w = this.width/100 + "rem";
				$("."+itemClass).width(w);
				$("."+itemClass).attr("src",this.src);
			}
			if(count>=manifest.length){
				console.log(count);
				callback();
			}
		}
	}
}
function Bgm(arguments){
	var bgm = arguments.bgm;
	var open = arguments.open;
	var close = arguments.close;
	var className = arguments.className;
	if(bgm){
		//创建一个audio
		audio = document.createElement("audio");
		audio.src = bgm;
		audio.autoplay = "autoplay";
		audio.loop = "loop";
		//添加audio到页面中
		document.body.appendChild(audio);
		if (open) {
			bgm_ico = document.createElement("img");
			bgm_ico.src = open;
			bgm_ico.className = className;
			document.body.appendChild(bgm_ico);
			t_play=true;	
			bgm_ico.onclick=function(){
				if (t_play) {
					t_play=false;
					audio.pause();
					bgm_ico.src = close;
				}else{
					t_play=true;
					audio.play();
					bgm_ico.src = open;
				}
			}
		}
		var once=true;
		function once_play(){
			if (once) {
				once=false;
				t_play=true;
				audio.play();
			}
			document.removeEventListener("touchstart",once_play,false)
		}
		document.addEventListener("touchstart",once_play,false)
	}
}