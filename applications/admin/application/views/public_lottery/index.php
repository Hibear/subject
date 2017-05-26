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
                    <li class="active">活动列表</li>
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 活动名称 </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="title" value="<?php if(isset($title)){ echo $title;}?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                              <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 开始时间 </label>
                                              <div class="col-sm-9">
                                                <div class="input-group date datepicker">
                                                  <input class="form-control date-picker" type="text" name="start_time" value="<?php if(isset($start_time)){ echo $start_time;}?>" data-date-format="yyyy-mm-dd hh:ii">
                                                  <span class="input-group-addon">
                                                    <i class="icon-calendar bigger-110"></i>
                                                  </span>
                                                </div>
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
                                            <th>活动id</th>
                                            <th>名称</th>
                                            <th>开始时间</th>
                                            <th>结束时间</th>
                                            <th>活跃度（访问）/次</th>
                                            <th>状态</th>
                                            <th>活动链接</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['title'];?></td>
                                                <td><?php echo $value['start_time'];?></td>
                                                <td><?php echo $value['end_time'];?></td>
                                                <td><?php echo $value['visits'];?></td>
                                                <td><?php if($value['is_del'] == 1){echo '删除';}else{echo '正常';}?></td>
                                                <td>
                                                    <?php if($value['type'] == C('active_type.zjd.id')):?>
                                                        <?php echo $domain['h5']['url']?>/goldegg/index?active_id=<?php echo $value['id']?>
                                                    <?php elseif($value['type'] == C('active_type.ggk.id')):?>
                                                        <?php echo $domain['h5']['url']?>/guaguaka/index?active_id=<?php echo $value['id']?>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <a class="green tooltip-info" href="/public_lottery/lists?active_id=<?php echo $value['id'];?>"  data-rel="tooltip" data-placement="top" title="" data-original-title="投票对象列表">
                                                        <i class="ace-icon glyphicon glyphicon-user">中奖名单</i>
                                                    </a>
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
