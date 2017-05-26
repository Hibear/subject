<!-- 加载公用css -->
<?php $this->load->view('common/header');?>

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
                        <a href="#">h5后台数据</a>
                    </li>
                    <li class="active">公共中奖人员列表</li>
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

            <div class="page-content">                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>筛选条件</h4>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 微信昵称 </label>
                                                <div class="col-sm-9">
                                                    <input type="hidden" name="active_id" value="<?php echo $id?>" />
                                                    <input type="text" name="nickname" value="<?php if(isset($nickname)){ echo $nickname;}?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="btn btn-info" type="submit">
                                                    <i class="fa fa-search"></i>
                                                    查询
                                                </button>
                                                <button class="btn" type="reset">
                                                    <i class="icon-undo bigger-110"></i>
                                                    重置
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>活动id</th>
                                            <th>微信openid</th>
                                            <th>微信昵称</th>
                                            <th>中奖奖项</th>
                                            <th>奖品</th>
                                            <th>状态</th>
                                            <th>领取时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['active_id'];?></td>
                                                <td><?php echo $value['openid'];?></td>
                                                <td><?php echo $value['nickname'];?></td>
                                                <td><?php echo $value['prize_name'];?></td>
                                                <td><?php echo $value['prize'];?></td>
                                                <td><?php if($value['status'] == 1){echo '已领取';}else{echo '未领取';}?></td>
                                                <td><?php if($value['update_time'] != '0000-00-00 00:00:00'){echo $value['update_time'];}?></td>
                                                <td>
                                                    <?php if($value['status'] == 0):?>
                                                    <a class="green tooltip-info" href="/public_lottery/lingqu?active_id=<?php echo $id?>&id=<?php echo $value['id'];?>"  data-rel="tooltip" data-placement="top" title="" data-original-title="编辑">
                                                        <i class="ace-icon glyphicon glyphicon-ok">领取</i>
                                                    </a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- 分页 -->
                                    <?php $this->load->view('common/page');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
