<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>仓库管理系统</title>
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://g.alicdn.com/dingding/dingtalk-pc-api/2.7.0/index.js"></script>
</head>

<body class="login-layout">
<script src="<?php echo get_css_js_url('guaguaka/jquery-1.9.1.js', 'h5')?>"></script>
    <script type="text/javascript">
    DingTalkPC.config({
        agentId: "<?php echo $config['agentid']?>", // 必填，微应用ID
        corpId: "<?php echo $config['corpid']?>",   //必填，企业ID
        timeStamp: "<?php echo $config['timestamp']?>", // 必填，生成签名的时间戳
        nonceStr: "<?php echo $config['nonce']?>", // 必填，生成签名的随机串
        signature: "<?php echo $config['signature']?>", // 必填，签名
        jsApiList: [
            'device.notification.alert',
            'device.notification.confirm',
            'biz.user.get',
            'runtime.permission.requestAuthCode'
        ] // 必填，需要使用的jsapi列表
    });

    DingTalkPC.ready(function(res){
    	//获取code,获取管理员信息
    	DingTalkPC.runtime.permission.requestAuthCode({
    	    corpId: "<?php echo $config['corpid']?>", //企业ID
    	    onSuccess: function(result) {
    	        var code = result.code
    	        //获取用户信息
    	        var nickname;
    	        var headimg;
    	        DingTalkPC.biz.user.get({
	                onSuccess: function (info) {
	                    nickname = info.nickName;
	                    headimg = info.avatar;
	                },
	                onFail: function (err) {
	                	alert('获取用户信息失败');
	                }
	            });
    	        DingTalkPC.device.notification.alert({
    	            message: "授权登陆",
    	            title: "提示",//可传空
    	            buttonName: "确定",
    	            onSuccess : function() {
    	            	$.post('/login/login', {'code':code, 'name':nickname, 'headimg':headimg}, function(data){
    	    	            if(data){
    	    	                if(data.code == 0){
    	    	                	alert(data.msg);return;
    	        	            }
    	        	            console.log(data.msg);
    	        	            window.location.href = "<?php echo $domain['ding']['url']?>"
    	        	        }else{
    	        	            alert('网络错误');
    	                	}
    	        	    })
    	            },
    	            onFail : function(err) {
    	            	alert('系统错误');
        	        }
    	        });
    	    },
    	    onFail : function(err) {}
    	 
    	})
    });

    

    DingTalkPC.error(function(error){
    	alert('配置信息不正确')
  	});

  	function alert(msg){
  		DingTalkPC.device.notification.alert({
    	    message: msg,
    	    title: "提示",//可传空
    	    buttonName: "确定",
    	    onSuccess : function() {
    	        /*回调*/
    	    },
    	    onFail : function(err) {}
    	});
  	}
    </script>
</body>
</html>
