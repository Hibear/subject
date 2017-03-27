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
                        <a href="#">报名管理</a>
                    </li>
                    <li class="active">方舟戏台演员</li>
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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 姓名： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="fullname" placeholder="演员姓名" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机号： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="tel" placeholder="手机号" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 参赛标题： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" placeholder="参赛标题" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 封面图： </label>
                                <div class="col-sm-9">
                                    <ul id="uploader_img_url">
    	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none; list-style-type:none">
    	                                   <a href="javascript:;" class="up-img"  id="btn_img_url"><span>+</span><br>添加照片</a>
    	                               </li>
	                               </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 简介： </label>
                                <div class="col-sm-4">
                                    <textarea class="form-control limited" name="desc" style="margin-top: 0px; margin-bottom: 0px; height: 171px;"></textarea>
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

<script type="text/javascript">
    $('[data-rel=tooltip]').tooltip();
    $('.del-spa').click(function(){
        var _self = $(this);
        var d = dialog({
            title: "提示",
            content: '确定删除该规格吗？',
            okValue: '确定',
            ok: function () {
                window.location.href = '/specification/del/' + _self.attr('data-id') + '/' + _self.attr('data-del');
            },
            cancelValue: '取消',
            cancel: function () {}
        });
        d.width(320);
        d.showModal();
    });
</script>
<!-- 上传 -->
<?php $this->load->view("common/sea_footer");?>
<script type="text/javascript">
    var object = [
          {"obj": "#uploader_img_url", "btn": "#btn_img_url"}
    ];
    
    seajs.use(['admin_uploader','jqueryswf','swfupload'], function(swfupload) {
    	swfupload.swfupload(object);
    });
    

</script>
<!-- 上传 -->

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>

