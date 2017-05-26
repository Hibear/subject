<!-- 加载公用css -->
<?php $this->load->view('common/header');?>
<link href="<?php echo css_js_url('chosen.css', 'admin');?>" rel="stylesheet" />

<!-- 头部 -->
<?php $this->load->view('common/top');?>

<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <!-- 左边导航菜单 -->
        <?php //$this->load->view('common/left');?>

        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="/">首页</a>
                    </li>
                </ul>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS  enctype="multipart/form-data"-->
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类： </label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="id" value="<?php echo $info['id']?>" />
                                    <select class="col-xs-10 col-sm-5" name="cate_id">
                                        <?php if($cate):?>
                                        <?php foreach ($cate as $k => $v):?>
                                            <option <?php if($info['cate_id'] == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 物件名称： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="<?php echo $info['name']?>" placeholder="名物件称" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 编号： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="number" value="<?php echo $info['number']?>" placeholder="编号" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 数量： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="num" value="<?php echo $info['num']?>" placeholder="数量" class="col-xs-10 col-sm-5">
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

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
