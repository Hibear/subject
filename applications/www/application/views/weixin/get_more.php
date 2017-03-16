
<?php  foreach ($info as $v):   ?>
    <ul id="user-list">
        <volist name="userlist" id="vo">

            <!--            <a href="{:U('Index/user',array('id'=>$vo['id'],'vid'=>$info['id'],'token'=>$token))}">-->

            <a href="<?php  echo site_url().'/Weixin/detail?id='.$v['id'] ?>">

                <li class="post">
                    <div class="border-item">
                        <p style="background: url(<?php echo "/uploads/images/".$v['cover_img']?>);"></p>
                        <p class="bh"><i>编号:<?php echo $v['id']?></i><i>演员:<?php echo $v['fullname']?></i></p>
                        <p><i style="width:100%;">名称:<?php echo $v['title']?></i></p>
                        <p style="color:#ebad2a;padding-bottom:10px;"><i class="dps">得票数:<?php echo $v['vote_num']?></i></p>
                        <div class="ttp">
                            <div class="tp" align="center" alt="{$vo.id}">投票</div>
                        </div>
                    </div>
                </li>
            </a>
        </volist>
    </ul>
<?php  endforeach;  ?>
