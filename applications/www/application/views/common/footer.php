<div class="footer">
    <div class="foot-nav">
        <div class="nav-lists">
            <ul>
                <li><a href="<?php echo $domain['news']['url'];?>/guide/about">关于惠民安居</a></li>
                <li><a href="<?php echo $domain['news']['url'];?>/guide/contact">联系我们</a></li>
                <li><a href="javascript:;">加入我们</a></li>
                <li><a href="javascript:;">隐私声明</a></li>
                <li><a href="javascript:;">网站地图</a></li>
                <li><a href="javascript:;">友情链接</a></li>
            </ul>
            <p class="blue-text">惠民安居：有承诺，有保障  服务热线：<?php echo $site_config['tel_400'];?></p>
        </div>
        <div class="copy-right">贵州惠民安居网络科技有限公司 |  <?php echo $site_config['ICP'];?><br>Copyright ©2015-2020惠民安居huiminanju.com版权所有
        </div>
        <div class="hot">合作单位﹀</div>
        <div class="company-con">
            <ul>
            <?php if($img):?>
            <?php foreach ($img as $k=>$v):?>
                <li><a href="<?php echo $v['url']?>" target="_blank"><img src="<?php echo $domain['admin']['url'].$v['img_url']?>"></a></li>
            <?php endforeach;?>
            <?php endif;?>
            </ul>
        </div>
    </div>
</div>

<div class="right-nav">
    <div class="tell">
        <div class="tell-cont"><?php echo $site_config['tel_400'];?><i></i></div>
    </div>
    <div class="file"></div>
    <div class="qq"></div>
    <div class="top" id="backtotop"></div>
</div>   
<script type="text/javascript">
    var baseUrl = "<?php echo $domain['base']['url'];?>";
    var newsUrl = "<?php echo $domain['news']['url'];?>";
    var loupanUrl = "<?php echo $domain['loupan']['url']?>";
</script>