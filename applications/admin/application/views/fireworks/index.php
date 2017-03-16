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
                        <a href="#">用户管理</a>
                    </li>
                    <li class="active">中奖人员列表</li>
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
                                    <form  id="form1" class="form-horizontal" role="form" action="">
                                        <div class="form-group">
											<div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 奖项名称： </label>
                                                <div class="col-sm-9">
                                                    <select id="pid" name="pid"  class="select2" data-placeholder="Click to Choose...">
                                                        <?php foreach($active_name as $key=>$val){ ?>
                                                            <option value="<?php echo $key;?>" <?php if($key == $pid) { echo "selected"; }?>><?php echo $val;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 姓名 </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" value="<?php echo $name;?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机号 </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="tel" value="<?php echo $tel;?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>

                                           
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
											   <a href="/registerusers?name=1" class="btn btn-primary">
											      <i class="fa fa-user" aria-hidden="true"></i>
											      报名人员
											   </a>
                                                <button class="btn btn-info" type="submit">
                                                    <i class="fa fa-search"></i>
                                                    查询
                                                </button>
                                                <button class="btn btn-primary btn-export" type="button">
                                                    <i class="fa fa-download out-excel" aria-hidden="true"></i>
                                                    导出
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
                                                <th>姓名</th>
                                                <th>手机号</th>
                                                <th>等级</th>
                                                <th>奖品</th>
                                                <th>兑奖编号</th>
                                                <th>参与时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['name'];?></td>
                                                <td><?php if($value['tel']) { echo $value['tel']; } ?></td>
                                                <td><?php echo $value['level'];?>等奖</td>
                                                <td><?php echo $value['level_name'];?></td>
                                                <td><?php echo $value['number'];?></td>
                                                <td><?php echo date('Y-m-d H:i:s',strtotime($value['create_time']));?></td>
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
<script src="<?php echo css_js_url('select2.min.js','admin');?>"></script>
<script type="text/javascript">
	$(".select2").css('width','230px').select2({allowClear:true});
    $('[data-rel=tooltip]').tooltip();

    $('.btn-export').click(function(){
        $('#form1').attr('action', '/fireworks/export');
        $('#form1').submit();
        $('#form1').attr('action', '');
    });
</script>

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
