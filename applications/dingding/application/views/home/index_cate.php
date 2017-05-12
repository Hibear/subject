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
                
                <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>操作</h4>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <form class="form-horizontal" role="form">
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <a class="btn" href="/home/add_cate">
                                                    <i class="icon-plus smaller-75"></i>
                                                                                                                                       添加分类
                                                </a>
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
                                            <th>分类名称</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($lists as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['name'];?></td>
                                                <td><?php if($value['is_del'] == 1){echo '已删除';}else{echo '正常';}?></td>
                                                <td>
                                                    <p onclick="edit(<?php echo $value['id']?>)" class="btn btn-minier btn-purple">编辑</p>
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

<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>
<script type="text/javascript">
    function edit(id){
        window.location.href = "/home/edit_cate?id="+id;
    }
</script>
<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
