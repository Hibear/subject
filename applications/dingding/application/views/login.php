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
    <script type="text/javascript">
    DingTalkPC.config({
        agentId: '', // 必填，微应用ID
        corpId: '',//必填，企业ID
        timeStamp: '', // 必填，生成签名的时间戳
        nonceStr: '', // 必填，生成签名的随机串
        signature: '', // 必填，签名
        jsApiList: ['device.notification.alert', 'device.notification.confirm'] // 必填，需要使用的jsapi列表
    });

    DingTalkPC.ready(function(res){

    });

    DingTalkPC.error(function(error){
  	  /*{
  	      errorCode: 1001, //错误码
  	      errorMessage: '', //错误信息
  	  }*/
  	});
    </script>
</body>
</html>
