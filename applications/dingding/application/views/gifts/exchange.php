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
                        <a href="#">H5后台数据</a>
                    </li>
                    <li class="active"><a href="/gifts">礼品列表</a></li>
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户： </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="realname" value="<?php if(isset($realname)){echo $realname;}?>"  class="col-xs-10 col-sm-12" />
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
                                            <th>用户</th>
                                            <th>电话</th>
                                            <th>地址</th>
                                            <th>兑换商品</th>
                                            <th>数量</th>
                                            <th>兑换时间</th>
                                            <th>发放时间</th>
                                            <th>领取状态</th>
                                            <th>状态</th>
                                            <th>领取时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($list)):?>
                                        <?php foreach ($list as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['user_info']['realname'];?></td>
                                                <td><?php echo $value['user_info']['tel'];?></td>
                                                <td><?php echo $value['user_info']['addr'];?></td>
                                                <td><?php echo $value['title'];?></td>
                                                <td><?php echo $value['num'];?></td>
                                                <td><?php echo $value['create_time'];?></td>
                                                <td><?php if($value['post_time'] != '0000-00-00 00:00:00'){echo $value['post_time'];}?></td>
                                                <td><?php if($value['status'] == 2){echo '已领取';}elseif($value['status'] == 1){echo '已发放';}else{echo '未发放';}?>
                                                </td>
                                                <td><?php if($value['is_del'] == 1){echo '删除';}else{echo '正常';}?></td>
                                                <td><?php if($value['get_time'] != '0000-00-00 00:00:00'){echo $value['get_time'];}?></td>
                                                <td>
                                                    <?php if($value['status'] == 0):?>
                                                        <p status="get" data="<?php echo $value['id']?>" data-info=" <?php echo $value['user_info']['realname']?> 用户发放 <?php echo $value['title'];?>" class="btn btn-app btn-green btn-xs btn-info">发放</p>
                                                    <?php elseif($value['status'] == 1):?>
                                                        <p status="power" data="<?php echo $value['id']?>" data-info=" <?php echo $value['user_info']['realname']?> 用户强制领取 <?php echo $value['title'];?>" class="btn btn-app btn-green btn-xs btn-info">强制领取</p>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif;?>
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

    $('[status = "get"]').on('click', function(){
        var _obj = $(this);
        var id = _obj.attr('data');
        var info = _obj.attr('data-info');
        var d = dialog({
            title: "提示",
            content: '确定要给'+info+' 吗？',
            okValue: '确定',
            ok: function () {
                window.location.href = '/gifts/get?id=' + id;
            },
            cancelValue: '取消',
            cancel: function () {}
        });
        d.width(320);
        d.showModal();
    });

    $('[status = "power"]').on('click', function(){
        var _obj = $(this);
        var id = _obj.attr('data');
        var info = _obj.attr('data-info');
        var d = dialog({
            title: "提示",
            content: '确定要给'+info+' 吗？',
            okValue: '确定',
            ok: function () {
                window.location.href = '/gifts/power?id=' + id;
            },
            cancelValue: '取消',
            cancel: function () {}
        });
        d.width(320);
        d.showModal();
    })
</script>

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
