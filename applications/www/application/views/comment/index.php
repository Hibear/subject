<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta name="viewport"-->
          <!--content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
    <title>Title</title>

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


    <script>
        //        jQuery(function($){
        //            $('#tiles li').wookmark({ //这里是要实现瀑布流布局的对象
        //                autoResize: true, //设置成true表示当window窗口大小改变的时候，重新布局
        //                container: $('#container'), //这个是容器名称 这个容器要必须包含一个css属性"position:relative" 否则你就会看到全部挤在页面的左上角了
        //                offset: 12, //2个相邻元素之间的间距
        //                itemWidth: 222, //指定对象的宽度
        //                resizeDelay: 50 //这是延时效果 默认是50
        //            });
        //        });


    </script>

    <style type="text/css">


        #container {
            /*display: -webkit-flex;*/
            /*display: flex;*/
        }



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
<div id="container" style="position: relative ; margin-top: 200px"></div>

<div id="main">
    <ul id="tiles">
        <?php foreach ($com_info as $v): ?>
            <?php  $id = $v['id']  ?>
            <?php $com_name =  $v['company_name']  ?>

        <a href=<?php echo '/comment/contnt'.'?id='.$id; ?>>
            <li><img class="pic" src=<?php  echo "/comment/image/".$id.'.jpg' ?>><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
       <?php endforeach; ?>
    </ul>
</div>

</body>
</html>