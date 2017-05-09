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
                        <a href="#">资源管理</a>
                    </li>
                    <li class="active">规格管理</li>
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 审核状态 </label>
                                                <div class="col-sm-3">
                                                    <select class="col-xs-12" name="is_auth">
                                                        <option value="">全部</option>
                                                        <option value="0" <?php if($is_auth != '' && $is_auth == 0) { echo "selected"; } ?>>未审核</option>
                                                        <option value="1" <?php if($is_auth != '' && $is_auth == 1) { echo "selected"; } ?>>审核通过</option>
                                                        <option value="2" <?php if($is_auth != '' && $is_auth == 2) { echo "selected"; } ?>>审核未通过</option>
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
                                                <th>中文姓名</th>
                                                <th>姓名拼音</th>
                                                <th>年龄</th>
                                                <th>邮箱</th>
                                                <th>手机</th>
                                                <th>国籍</th>
                                                <th>出生年月</th>
                                                <th>海选城市</th>
                                                <th>报名时间</th>
                                                <th>审核状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['user_name'];?></td>
                                                <td><?php echo $value['py_name'];?></td>
                                                <td><?php echo $value['age'];?></td>
                                                <td><?php echo $value['email'];?></td>
                                                <td><?php echo $value['phone_number'];?></td>
                                                <td><?php echo $value['nationality'];?></td>
                                                <td><?php echo $value['birth_date'];?></td>
                                                <td><?php echo $value['city'];?></td>
                                                <td><?php echo $value['create_time'];?></td>
                                                <td>
                                                    <?php 
                                                        switch ($value['is_auth']) {
                                                            case '1':
                                                                $str = "审核通过";
                                                                $class = 'badge-success';
                                                                break;
                                                            case '2':
                                                                $str = "审核未通过";
                                                                $class = 'badge-warning';
                                                                break;
                                                            default:
                                                                $str = "未审核";
                                                                $class = 'badge-yellow';
                                                                break;
                                                        }
                                                    ?>
                                                    <span class="badge <?php echo $class; ?>">
                                                        <?php echo $str;?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="green tooltip-info" href="/moteusers/detail/<?php echo $value['id'];?>"  data-rel="tooltip" data-placement="top" title="" data-original-title="详情">
                                                        <i class="icon-eye-open bigger-130"></i>
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

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
