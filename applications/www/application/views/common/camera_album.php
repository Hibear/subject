<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20160823054653"></script>
<script>
    wx.config({
        debug:false,
        appId: "<?php echo $signPackage['appId'];?>",
        timestamp:"<?php echo $signPackage['timestamp'];?>",
        nonceStr: "<?php echo $signPackage['nonceStr'];?>",
        signature: "<?php echo $signPackage['signature'];?>",
        jsApiList: [
            'chooseImage',
            'uploadImage'
        ]
    });

    wx.ready(function () {
        
        $("body").on('click', '#upload', function () {
        	var len = parseInt($(this).attr('data'));
        	if(len == 4){
            	alert('最多可以上传4张照片哦！');
        	    return false;
            }
        	wx.chooseImage({
        	    count: 1, // 默认9
        	    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
        	    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        	    success: function (res) {
        	        var localIds = res.localIds[0]; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
        	        wx.uploadImage({
        	            localId: localIds, // 需要上传的图片的本地ID，由chooseImage接口获得
        	            isShowProgressTips: 1, // 默认为1，显示进度提示
        	            success: function (res) {
        	                var serverId = res.serverId; // 返回图片的服务器端ID
        	                $.get('/comment/download', {'media_id':serverId}, function(data){
        	                    if(data){
            	                    var num = len+1;
            	                    var html = '<img style="width:25%;height:100%" src="'+localIds+'">';
            	                    html +='<input class="img_num" type="hidden" name="imgs_'+num+'" value="'+data+'">';
            	                    $('#camara_all').append(html);
            	                    $('#upload').attr('data', num);
            	                }
            	            });
        	            }
        	        });
            	}
        	});
        });
    });

    wx.error(function(res){
        //alert(res.errMsg);
    });

</script>
