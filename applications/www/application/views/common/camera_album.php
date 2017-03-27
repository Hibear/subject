<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20160823054653"></script>
<script>
    wx.config({
        debug:true,
        appId: "<?php echo $signPackage['appId'];?>",
        timestamp:"<?php echo $signPackage['timestamp'];?>",
        nonceStr: "<?php echo $signPackage['nonceStr'];?>",
        signature: "<?php echo $signPackage['signature'];?>",
        jsApiList: [
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'chooseImage',
            'uploadImage'
        ]
    });

    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: "<?php echo $title;?>",
            link: "<?php echo $link;?>",
            imgUrl: "<?php echo $imgUrl;?>",
            desc: "<?php echo $desc;?>",
            success: function () {
                //   alert("分享成功");
            },
            cancel: function () {
                //alert("取消分享");
            }
        });

        $("#add_pic").click(function () {
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
              		wx.uploadImage(
           			 localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
           			 isShowProgressTips: 1, // 默认为1，显示进度提示
            			 success: function (res) {
                		 var serverId = res.serverId; // 返回图片的服务器端ID
				console.log(serverId);
            }
        });


		  }
            });
        });

      

        //wx.onMenuShareAppMessage({
          //  title: "<?php echo $title;?>",
            //link: "<?php echo $link;?>",
            //imgUrl: "<?php echo $imgUrl;?>",
            //desc: "<?php echo $desc;?>",
            //trigger: function (res) {
            //},
            //success: function (res) {
                // alert("分享成功");
            //},
           // cancel: function (res) {
                //	alert('已取消');
           // },
           // fail: function (res) {
           //     alert(JSON.stringify(res));
           // }

//        });
    });

    wx.error(function(res){
        //alert(res.errMsg);
    });

</script>
