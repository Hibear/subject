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
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/1.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/2.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/3.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/4.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/5.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/6.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/7.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/8.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/9.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>
        <a href="content_f.html">
            <li><img class="pic" src="/comment/image/10.jpg"><img class="dianping" src="/comment/image/dianping.png"></li>
        </a>


    </ul>
</div>


<!--<div id="container">-->
<!--<header>-->
<!--<h1>jQuery Wookmark Plug-in Example</h1>-->
<!--<p>Resize the browser window or click a grid item to trigger layout updates.</p>-->
<!--</header>-->
<!--<div id="main" role="main">-->

<!--<ul id="tiles">-->
<!--&lt;!&ndash; These are our grid blocks &ndash;&gt;-->
<!--<li><img src="image/1.jpg" width="200" height="283"><p>1</p></li>-->
<!--<li><img src="image/2.jpg" width="200" height="300"><p>2</p></li>-->
<!--<li><img src="image/3.jpg" width="200" height="252"><p>3</p></li>-->
<!--<li><img src="image/4.jpg" width="200" height="158"><p>4</p></li>-->
<!--<li><img src="image/5.jpg" width="200" height="300"><p>5</p></li>-->
<!--<li><img src="image/6.jpg" width="200" height="297"><p>6</p></li>-->
<!--<li><img src="image/7.jpg" width="200" height="200"><p>7</p></li>-->
<!--<li><img src="image/8.jpg" width="200" height="200"><p>8</p></li>-->
<!--<li><img src="image/9.jpg" width="200" height="398"><p>9</p></li>-->
<!--<li><img src="image/10.jpg" width="200" height="267"><p>10</p></li>-->
<!--<li><img src="image/11.jpg" width="200" height="283"><p>11</p></li>-->
<!--<li><img src="image/12.jpg" width="200" height="300"><p>12</p></li>-->
<!--<li><img src="image/13.jpg" width="200" height="252"><p>13</p></li>-->
<!--<li><img src="image/14.jpg" width="200" height="158"><p>14</p></li>-->
<!--<li><img src="image/15.jpg" width="200" height="300"><p>15</p></li>-->
<!--<li><img src="image/16.jpg" width="200" height="297"><p>16</p></li>-->
<!--<li><img src="image/17.jpg" width="200" height="200"><p>17</p></li>-->
<!--<li><img src="image/18.jpg" width="200" height="200"><p>18</p></li>-->
<!--<li><img src="image/19.jpg" width="200" height="398"><p>19</p></li>-->
<!--<li><img src="image/20.jpg" width="200" height="267"><p>20</p></li>-->
<!--<li><img src="image/21.jpg" width="200" height="283"><p>21</p></li>-->
<!--&lt;!&ndash; End of grid blocks &ndash;&gt;-->
<!--</ul>-->

<!--</div>-->
<!--</div>-->


</body>
</html>