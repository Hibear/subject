<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta name="viewport"-->
          <!--content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
    <title>外滩商业街评分</title>

    <script type="text/javascript" src="/comment/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/comment/js/jquery.imagesloaded.js"></script>
    <script type="text/javascript" src="/comment/js/jquery.wookmark.js"></script>
    <script type="text/javascript">


        jQuery(function ($) {
            $(window).load(function () {//需要等页面加载完之后才能获取到图片的高度，否则在google中会重叠
                $('#tiles li').wookmark({
                    align: 'center',
                    autoResize: true,
                    comparator: null,
                    container: $('#container'),
                    direction: undefined,
                    ignoreInactiveItems: true,
                    itemWidth: 330,
                    fillEmptySpace: false,
                    flexibleWidth: 100,
                    offset: 70,
                    onLayoutChanged: undefined,
                    outerOffset: 0,
                    resizeDelay: 50,
                    possibleFilters: []
                });
            });
        });


    </script>
    <style type="text/css">
        #tiles li {
            border: 1px solid #000;
            list-style: none;
            height: auto;
            text-align: center;
            margin-top: 200px;
        }

        .pic {
            width: 300px;
            margin-bottom: 50px;

        }

        .dianping {
            width: 70%;

        }


    </style>

</head>
<body>

<!--style="position: relative; margin-top: 200px -->
<div id="container" style="position: relative ; margin-top: 180px"></div>

<div id="main">
    <ul id="tiles">
        <?php foreach ($com_info as $v): ?>
            <?php  $id = $v['id']  ?>
            <?php $com_name =  $v['company_name']?>

        <a href=<?php echo '/comment/contnt'.'?id='.$id; ?>>
            <li><img style="height: 650px" class="pic lazy" data-original=<?php  echo "/comment/image/".$id.'.jpg' ?>><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
       <?php endforeach; ?>
    </ul>
</div>
<script type="text/javascript" src="/comment/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
        placeholder : "/comment/image/load.png",
        threshold: 1000,
        failurelimit : 10
    });
});
</script>
</body>
</html>