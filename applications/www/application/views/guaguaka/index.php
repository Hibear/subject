
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>lucky-card.js DEMO</title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <style>
    html,
    body {
        margin: 0;
        padding: 0;
    }
    
    body {
        background: #FFFFFF;
    }
    
    #card {
        height: 100%;
        font-weight: bold;
        font-size: 40px;
        line-height: 100px;
        text-align: center;
        background: #FAFAFA;
    }
    
    #scratch {
        width: 300px;
        height: 100px;
        margin: 50px auto 0;
        border: 1px solid #ccc;
    }
    </style>
    <link rel="stylesheet" href="<?php echo get_css_js_url('guaguaka/lucky-card.css', 'h5')?>">
    <script src="<?php echo get_css_js_url('lucky-card.min.js', 'h5')?>"></script>
</head>

<body>
    <div id="scratch">
        <div id="card">￥5000000元</div>
    </div>
    <script>
    LuckyCard.case({
        ratio: .7
    }, function() {
        alert('至于你信不信，我反正不信！');
        this.clearCover();
    });
    </script>
</body>

</html>