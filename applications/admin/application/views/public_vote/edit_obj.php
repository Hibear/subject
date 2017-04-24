<!-- 加载公用css -->
<?php $this->load->view('common/header2');?>

<!-- 头部 -->
<?php $this->load->view('common/top');?>

<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <!-- 左边导航菜单 -->
        <?php $this->load->view('common/left');?>

        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="#">首页</a>
                    </li>
                    <li>
                        <a href="#">活动管理</a>
                    </li>
                    <li class="active">添加公共参选对象</li>
                </ul>

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                            <i class="icon-search nav-search-icon"></i>
                        </span>
                    </form>
                </div>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS  enctype="multipart/form-data"-->
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 对象名称： </label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="active_id" value="<?php echo $active_id?>" />
                                    <input type="hidden" name="id" value="<?php echo $info['id']?>" />
                                    <input type="text" name="vote_obj" placeholder="参选对象" value="<?php echo $info['vote_obj']?>" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 参赛标题： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" placeholder="参赛标题" value="<?php echo $info['title']?>" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 封面图： </label>
                                <div class="col-sm-9">
                                    <ul id="uploader_img_url">
                                        <?php if($info['cover_img']):?>
    				                    <li class="pic pro_gre" style="margin-right: 20px; clear: none">
        				                    <a class="close del-pic" href="javascript:;"></a>
        				                    <img src="<?php echo get_img_url($info['cover_img'])?>" style="width: 100%; height: 100%">
        				                    <input type="hidden" name="img_url" value="<?php echo $info['cover_img']?>">
    				                    </li>
    				                    <?php endif;?>
    	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none; list-style-type:none">
    	                                   <a href="javascript:;" class="up-img"  id="btn_img_url"><span>+</span><br>添加照片</a>
    	                               </li>
	                               </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 参选图集： </label>
                                <div class="col-sm-9">
                                    <ul id="uploaders_images">
                                       <?php if($info['images']):?>
                                       <?php foreach (explode(';', $info['images']) as $key => $val) :?>
        				                    <li class="pic pro_gre" style="margin-right: 20px; clear: none">
            				                    <a class="close del-pic" href="javascript:;"></a>
            				                    <img src="<?php echo get_img_url($val)?>" style="width: 100%; height: 100%">
            				                    <input type="hidden" name="images[]" value="<?php echo $val?>">
        				                    </li>
        				                <?php endforeach;?>
    				                    <?php endif;?>
    	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none; list-style-type:none">
    	                                   <a href="javascript:;" class="up-img"  id="btn_images"><span>+</span><br>添加照片</a>
    	                               </li>
	                               </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 简介： </label>
                                <div class="col-sm-4">
                                    <textarea class="form-control limited" name="desc" style="margin-top: 0px; margin-bottom: 0px; height: 171px;"><?php echo $info['desc']?></textarea>
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="submit">
                                        <i class="icon-ok bigger-110"></i>
                                        保存
                                    </button>
                                </div>
                            </div>
                            </from>
                    </div><!-- PAGE CONTENT ENDS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>

<!-- 上传 -->
<?php $this->load->view("common/sea_footer");?>
<script type="text/javascript">
    var object = [
          {"obj": "#uploader_img_url", "btn": "#btn_img_url"},
          {"obj": "#uploaders_images", "btn": "#btn_images"}
    ];
    
    seajs.use(['admin_uploader','jqueryswf','swfupload'], function(swfupload) {
    	swfupload.swfupload(object);
    });
    

</script>
<!-- 上传 -->

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>

