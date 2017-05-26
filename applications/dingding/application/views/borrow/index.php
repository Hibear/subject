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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 借用人： </label>
                                                <div class="col-sm-9">
                                                    <input type="hidden" name="id" value="<?php echo $id?>"/>
                                                    <input type="text" name="name" value="<?php if(isset($name)){ echo $name;}?>"  class="col-xs-10 col-sm-12" />
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
                                            <th>编号id</th>
                                            <th>物件id</th>
                                            <th>物件名称</th>
                                            <th>借用人</th>
                                            <th>借出时间</th>
                                            <th>借出操作员</th>
                                            <th>归还时间</th>
                                            <th>归还操作员</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($lists)):?>
                                        <?php foreach ($lists as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['borrow_id']?></td>
                                                <td><?php echo $obj_name?></td>
                                                <td><?php echo $value['name']?></td>
                                                <td><?php echo $value['start_time']?></td>
                                                <td><?php echo $value['admin_name']?></td>
                                                <td><?php if($value['end_time'] !='0000-00-00'){echo $value['end_time'];}?></td>
                                                <td><?php echo $value['in_admin_name']?></td>
                                                <td>
                                                    <?php if($value['status'] == 1){echo '已归还';}else{echo '未归还';}?>
                                                </td>
                                                <td>
                                                    <?php if($value['status'] == 0):?>
                                                    <p onclick="back(<?php echo $value['id']?>, <?php echo $value['borrow_id']?>)" class="btn btn-minier btn-purple">归还</p>
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

<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>
<script type="text/javascript">
    function back(id, borrow_id){
        window.location.href = "/borrow/back?id="+id+'&borrow_id='+borrow_id;
    }
</script>
<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
