<link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/0.4.3/weui.min.css"/>
<div id="toast" style="display:none;z-index:999999">
   <div class="weui_mask_transparent"></div>
   <div class="tips">
	   <i class="toast-info"></i>
   </div>
</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20160823054653"></script>
<script>
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
				wx.onMenuShareTimeline({
					title: "<?php echo $title;?>",
					link: "<?php echo $link;?>",
					imgUrl: "<?php echo $imgUrl;?>",
					desc: "<?php echo $desc;?>",
					success: function () {
                        tisp("分享成功");
                     },
					cancel: function () { 
						alert("取消分享");
					}
				});
				wx.onMenuShareAppMessage({
				 	title: "<?php echo $title;?>",
					link: "<?php echo $link;?>",
					imgUrl: "<?php echo $imgUrl;?>",
					desc: "<?php echo $desc;?>",
					trigger: function (res) {
					},
					success: function (res) {
					 tisp("分享成功");
					},
					cancel: function (res) {
						alert('已取消');
					},
					fail: function (res) {
						alert(JSON.stringify(res));
					}

				});
		 });

			wx.error(function(res){
				//alert(res.errMsg);
			});

		function tisp(info){
                $("#toast").show();
                $(".toast-info").html(info);
                setTimeout(function () {
                    $('#toast').hide();
                }, 2000);
            }
</script>