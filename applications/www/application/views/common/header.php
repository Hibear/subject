<div class="header">
    <div class="nav">
        <a href="javascript:;" class="logo"></a>
        <ul class="menu">
            <li><a href="<?php echo $domain['base']['url'];?>"  <?php if($action == 'index') { echo 'class="act"'; }?>>首页</a></li>
            <li><a href="<?php echo $domain['loupan']['url'];?>" <?php if($action == 'buy') { echo 'class="act"'; }?>>半价房</a></li>
            <li><a href="<?php echo $domain['base']['url'];?>/decorate" <?php if($action == 'decorate') { echo 'class="act"'; }?>>装修</a></li>
            <li><a href="<?php echo $domain['news']['url'];?>" <?php if($action == 'news') { echo 'class="act"'; }?>>安居资讯</a></li>
            <li><a href="<?php echo $domain['news']['url'];?>/guide" <?php if($action == 'guide') { echo 'class="act"'; }?>>安居指南</a></li>
        </ul>
        <div class="top-search">
            <input placeholder="请输入关键字" name="keywords" value="<?php if(isset($keywords)) { echo $keywords; } ?>" />
            <div class="list">
                <?php 
                    if(isset($cur_sel)){
                        switch ($cur_sel) {
                            case '2':
                                $cur_text = '装修';
                                break;
                            case '3':
                                $cur_text = '资讯';
                                break;
                            default:
                                $cur_text = "楼盘";
                                break;
                        }
                    } else {
                        $cur_sel = "1";
                        $cur_text = "楼盘";
                    }
                ?>
                <span class="cur-sel" data-val="<?php echo $cur_sel;?>"><?php echo $cur_text;?></span>
                <span class="r">▼</span>
                <ul>
                    <li data-val="1">楼盘</li>
                    <li data-val="2">装修</li>
                    <li data-val="3">资讯</li>
                </ul>
            </div>
            <a href="javascript:;"></a>
        </div>
        <div class="right-link">
            <?php if(empty($user_info)){?>
            <a href="<?php echo $domain['base']['url'];?>/passport/login" class="login">登录</a>
            <a href="<?php echo $domain['base']['url'];?>/passport/register" class="reg">注册</a>
            <?php }else{?>
            <a href="<?php echo $domain['base']['url'];?>/usercenter" class="user"><?php echo $user_info['user_name']?></a>
            <a href="<?php echo $domain['base']['url'];?>/passport/logout" class="logout">退出</a>
            <?php }?>
        </div>
    </div>
</div>