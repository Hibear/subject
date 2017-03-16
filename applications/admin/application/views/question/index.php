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
                        <a href="#">问卷调查</a>
                    </li>
                    <li class="active">调查参与人员</li>
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 姓名 </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="user_name" value="<?php echo $user_name;?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机号 </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="phone_number" value="<?php echo $phone_number;?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 参与时间 </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group date datepicker">
                                                        <input class="form-control date-picker" type="text" name="create_time" value="<?php echo $create_time; ?>" data-date-format="dd-mm-yyyy">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否中奖 </label>
                                                <div class="col-sm-9">
                                                    <select name="is_win">
                                                        <option value="">全部</option>
                                                        <option value="0" <?php if($is_win != '' && $is_win == 0) { echo "selected"; } ?>>未中奖</option>
                                                        <option value="1" <?php if($is_win != '' && $is_win == 1) { echo "selected"; } ?>>中奖</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
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
                                                <th class="col-sm-1">姓名</th>
                                                <th class="col-sm-1">手机号</th>
                                                <th class="col-sm-1">年龄</th>
                                                <th class="col-sm-2">在贵阳最烦恼的事情</th>
                                                <th class="col-sm-1">目前住址</th>
                                                <th class="col-sm-1">买房时比较看重的方面</th>
                                                <th class="col-sm-2">比较喜欢的楼盘</th>
                                                <th class="col-sm-1">奖项</th>
                                                <th class="col-sm-2">参与时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['user_name'];?></td>
                                                <td><?php echo $value['phone_number'];?></td>
                                                <td><?php echo $value['age'];?></td>
                                                <td><?php echo $value['annoyance'];?></td>
                                                <td><?php echo $value['address'];?></td>
                                                <td><?php echo $value['looksfor'];?></td>
                                                <td><?php echo $value['project'];?></td>
                                                <td>
                                                    <?php 
                                                        switch ($value['win_level']) {
                                                            case '0':
                                                                $str = "未中奖";
                                                                $class = 'badge-grey';
                                                                break;
                                                            case '1':
                                                                $str = "一等奖";
                                                                $class = 'badge-success';
                                                                break;
                                                            case '2':
                                                                $str = "二等奖";
                                                                $class = 'badge-warning';
                                                                break;
                                                            case '3':
                                                                $str = "三等奖（公仔一个）";
                                                                $class = 'badge-yellow';
                                                                break;
                                                            case '4':
                                                                $str = "三等奖（明星玩偶一个）";
                                                                $class = 'badge-yellow';
                                                                break;
                                                        }
                                                    ?>
                                                    <span class="badge <?php echo $class; ?>">
                                                        <?php echo $str;?>
                                                    </span>
                                                </td>
                                                <td><?php echo $value['create_time'];?></td>
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

    $('.btn-export').click(function(){
        $('#form1').attr('action', '/questionusers/export');
        $('#form1').submit();
        $('#form1').attr('action', '');
    });
</script>

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
