<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>申请半价补贴-<?php echo $seo['title']?></title>
    <meta name="keywords" content="<?php echo $seo['keywords']?>">
    <meta name="description" content="<?php echo $seo['description']?>">
    <!-- 引入项目css资源文件,并配置构建地址演示 -->

    <link rel="stylesheet" href="<?php echo css_js_url('public.css', 'www');?>">
    <link rel="stylesheet" href="<?php echo css_js_url('subsidy.css', 'www');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo css_js_url('ui-dialog.css', 'common');?>" />
</head>

<body>
<!-- 头部 -->
<?php $this->load->view('common/header.php')?>

<!-- main start -->
<div class="container">
    <div class="page-main">
        <p class="title">半价购房申请</p>
        <div class="sub-cont">
            <p class="text">申请流程：</p>
            <div class="step">
                <p class="step1 act"><i></i>第一步：填写申请资料</p>
                <p class="step2"><i></i>第二部：审核申请资料</p>
                <p class="step3"><i></i>第三步：审核通过</p>
                <p class="step4"><i></i>第四步：查看回执单</p>
            </div>
        </div>
        <form action="#" method="post" id="form">
        <div class="sub-cont">
            <p class="text">手机号：</p>
            <input type="text" name="phone_number" id="phone_number" required="required" value="<?php echo $user['phone_number'];?>" readonly="readonly">
           <label></label>
        </div>
        <div class="sub-cont">
            <p class="text">性别：</p>
            <div class="con">
                <label><input type="radio" value="1"  name="sex" checked="checked">男</label>
                <label><input type="radio" value="2" <?php if(isset($userinfo)){if($userinfo['sex'] == 2){ echo 'checked="checked"';}};?>  name="sex">女</label>

            </div>
        </div>
        <div class="sub-cont">
            <p class="text">家庭住址：</p>
            <input type="text" name="home_addr" id="home_addr" value="<?php echo isset($userinfo) ? $userinfo['home_addr'] : "";?>">
        </div>
        <div class="sub-cont">
            <p class="text">现居住地址：</p>
            <input type="text" name="now_addr" id="now_addr" value="<?php echo isset($userinfo) ? $userinfo['now_addr'] : "";?>" />
        </div>
        <div class="sub-cont">
            <p class="text">邮箱：</p>
            <input type="text" name="email" id="email" value="<?php echo isset($userinfo) ? $userinfo['email'] : "";?>" >
            <label></label>
        </div>
        <div class="sub-cont">
            <p class="text">教育程度：</p>
            <select name="education" required="required">
                <option value="">请选择</option>
                <?php foreach ($education as $key => $val): ?>
                    <option  <?php if(isset($userinfo)){ if($val['id']==$userinfo['education']){echo "selected"; }}?>  value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="sub-cont">
            <p class="text">职业：</p>
            <select name="occupation" required="required">
                <option value="">请选择</option>
                <?php foreach ($occupation as $key => $val): ?>
                    <option <?php if(isset($userinfo)){ if($val['id']==$userinfo['occupation']){echo "selected"; }}?>   value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="sub-cont">
            <p class="text"><span>*</span>真实姓名：</p>
            <input type="text"  required="required" <?php echo $user['auth_status']==2 ? "readonly" : "";?> placeholder="真实姓名" name="real_name" id="real_name" value="<?php echo isset($userinfo) ? $userinfo['real_name'] : "";?>">
            <label></label>
        </div>
        <div class="sub-cont">
            <p class="text"><span>*</span>身份证号码：</p>
            <input type="text" required="required" <?php echo $user['auth_status']==2 ? "readonly" : "";?>  name="card_number" id="card_number" value="<?php echo isset($userinfo) ? substr_replace($userinfo['card_number'],"******",5,6) : "";?>"  placeholder="身份证号码">
            <label></label>
        </div>
        <?php if($user['auth_status'] != 2){?>

        <div class="sub-cont">
            <p class="text"><span>*</span>手持身份证正面照：</p>
            <div class="con">
                <a href="javascript:;" class="up-img" id="up-img"><span>+</span><br>添加照片</a>
                <div class="img-con">
                  <?php
                    if($userinfo['card_front']){
                    ?>
                        <img src="<?php echo get_full_img_url($userinfo['card_front']);?>"  id="index1" data-src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" class="index-img">
                     <?php }else{?>
                        <img src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" data-src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" id="index1" class="index-img">

                    <?php }?>
                    <a href="javascript:;" id="index1-del"></a>
                    <input type="hidden" required="required" name="card_front" id="card_front" value="<?php echo isset($userinfo) ? $userinfo['card_front'] : "";?>">
                </div>
                <p class="text1">示例：</p>
                <p class="con-text">
                    1、请上传本人<span>手持</span>身份证面头部照片和上半身照片。<br>
                    2、招聘为免冠，未化妆的数码招聘原始图片，<span>请勿用任何软件编辑修改。</span><br>
                    3、必须看清证件信息，且证件信息不能被遮挡，持证人五官清晰可见。<br>
                    4、仅支持jpg、bmp、png、gif格式的图片，<span>建议图片大小不超过3M。</span><br>
                    5、您提供的照片信息惠民安居将予以保护，不会用于其他用途。
                </p>
            </div>
        </div>

        <div class="sub-cont">
            <p class="text"><span>*</span>身份证反面照：</p>
            <div class="con">
                <a href="javascript:;" class="up-img"><span>+</span><br>添加照片</a>
                <div class="img-con">
                    <?php
                    if($userinfo['card_back']){
                        ?>
                        <img src="<?php echo get_full_img_url($userinfo['card_back']);?>"  id="index2" data-src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" class="index-img">
                    <?php }else{?>
                        <img src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" data-src="<?php echo $domain['static']['url']?>/www/images/subsidy.jpg" id="index2" class="index-img">

                    <?php }?>

                    <a href="javascript:;" id="index2-del"></a>
                    <input type="hidden" required="required" name="card_back" id="card_back" value="<?php echo isset($userinfo) ? $userinfo['card_back'] : "";?>">
                </div>
                <p class="text1">示例：</p>
                <p class="con-text">
                    1、必须看清证件信息，且证件信息不能被遮挡。<br>
                    2、仅支持jpg、bmp、png、gif格式的图片，<span>建议图片大小不超过3M。</span><br>
                    3、您提供的照片信息惠民安居将予以保护，不会用于其他用途。
                </p>
            </div>
        </div>
         <?php }?>
        <div class="sub-cont">
            <p class="text"><span>*</span>身份证到期时间：</p>
            <input type="text" <?php echo $user['auth_status']==2 ? "readonly" : "";?>  placeholder="身份证到期时间" required="required" name="card_expiration" id="card_expiration" value="<?php echo isset($userinfo) ? $userinfo['card_expiration'] : "";?>">
            <label>填写格式:2017.06.08</label>
        </div>
        <div class="sub-cont">
            <p class="text">申请楼盘：</p>
            <select name="house_id" required="required" class="house_id">
                <option value="">----请选择楼盘----</option>
                <?php foreach ($houses as $key => $val): ?>
                    <option <?php if(isset($house_id)){if($val['id'] == $house_id){ echo "selected";}}  ?>  value="<?php echo $val['id'];?>"><?php echo $val['house_name'];?></option>
                <?php endforeach;?>
            </select>
            <label></label>
        </div>
        <div class="sub-cont">
            <p class="text">申请户型：</p>
            <select required="required" name="model_id" class="model_id">
                <option value="">----请选择户型----</option>
                <?php foreach ($model as $key => $val): ?>
                    <option <?php if(isset($model_id)){if($val['id'] == $model_id){ echo "selected";}}  ?>  value="<?php echo $val['id'];?>"><?php echo $val['model_name'];?></option>
                <?php endforeach;?>
            </select>
            <label></label>
        </div>
        <input type="hidden" value="<?php echo $user['auth_status'];?>"  id="auth_status" name="is_type">
       <input type="button" class="submit" value="提交审核" />
        </form>

    </div>
</div>
<form name="uploadFrom" id="uploadFrom" action="/file/upload?type=1" method="post"  target="tarframe" enctype="multipart/form-data">
    <input type="file" id="upload_file" name="Filedata" style="display: none">
</form>
<iframe src=""  width="0" height="0" style="display:none;" name="tarframe"></iframe>
<!-- main end -->
<div class="page-bg"></div>
<div class="message-cont">
    <div class="close"></div>
    <img src="<?php echo $domain['static']['url']?>/www/images/subsidy_icon.png" data-src="<?php echo $domain['static']['url']?>/www/images/subsidy_icon.png">
    <p class="box-title">提交申请资料成功</p>
    <p class="box-text">我们的工作人员会在1-3个工作日内对您的个人资料进行审核，然后和您联系，请耐心等待！</p>
    <p class="box-text" style="color: #F49B03">
        <a href="javascript:history.go(-1);">
             <i style="font-style: normal;" id="time">3</i>秒后返回上一页！
        </a>
    </p>
</div>

<!-- 底部 -->
<!-- 引入项目js资源文件,并配置构建地址演示 -->
<?php $this->load->view('common/footer.php')?>
<!-- 引入项目js资源文件,并配置构建地址演示 -->
<script src="<?php echo css_js_url('jquery.min.js', 'admin');?>"></script>
<script src="<?php echo css_js_url('public.js', 'www');?>"></script>
<script src="<?php echo css_js_url('dialog.js', 'common');?>"></script>
<script src="<?php echo css_js_url('public-data.js', 'www');?>"></script>
<script>
    var staticUrl = "<?php echo $domain['static']['url']?>";
    var imgUrl = "<?php echo $domain['img']['url']?>";
</script>
<script type="text/javascript">

    var _self = "";
    $(function(){
   $(".up-img").click(function(){
            _self= $(this);
            $('#upload_file').trigger('click');
        });

        $("#upload_file").change(function(){
            $("#uploadFrom").submit();
        });


    });
    function stopSend(str){
        _self.next().find("img").attr("src",imgUrl+"/"+str);
        _self.next().find("input").val("/uploads/"+str);

    }
</script>
</body>
</html>
