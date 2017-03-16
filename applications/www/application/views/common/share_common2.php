<div id="data" title="315 买房上当傻瓜指数大测试 80%的人都说准！" desc="“房子延期交房”、“说好的学区房怎么又上不了”、“精装房质量问题多”、“‘电梯惊魂’频上演“……多少人在买房的过程中傻傻的被开发商蒙蔽了眼睛，为此，小编特地制作了“315购房防上当小测试”，快来点击参与吧！"></div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20160823054653"></script>
<script>
	$(document).ready(function() {
		wx.config({
				debug:false,
				appId: "<?php echo $signPackage['appId'];?>",
				timestamp:"<?php echo $signPackage['timestamp'];?>",
				nonceStr: "<?php echo $signPackage['nonceStr'];?>",
				signature: "<?php echo $signPackage['signature'];?>",
				jsApiList: [
					'onMenuShareAppMessage',
					'onMenuShareTimeline'
				]
			});
			
			wx.ready(function () {
				//点击按钮的分享
				param = {
					title: '',
					link: "<?php echo $link;?>",
					imgUrl: "<?php echo $imgUrl;?>",
					desc: '',
					success: function () {
                     //   alert("分享成功");
                     },
					cancel: function () { 
						//alert("取消分享");
					}
				};
				param.title = $('#data').attr('title');
				param.desc = $('#data').attr('desc');
                                //console.log(param);
				wx.onMenuShareTimeline(param);
				params = {
					title: '',
					link: "<?php echo $link;?>",
					imgUrl: "<?php echo $imgUrl;?>",
					desc: '',
					trigger: function (res) {
					},
					success: function (res) {
					// alert("分享成功");
					},
					cancel: function (res) {
					//	alert('已取消');
					},
					fail: function (res) {
						alert(JSON.stringify(res));
					}
				};
				params.title = $('#data').attr('title');
				params.desc = $('#data').attr('desc');
				wx.onMenuShareAppMessage(params);
		 });

			wx.error(function(res){
				//alert(res.errMsg);
			});
	});
</script>
