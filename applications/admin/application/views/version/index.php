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
                        <a href="#">管理员管理</a>
                    </li>
                    <li class="active">资源版本号</li>
                </ul>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>版本号列表</h4>
                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="clearfix form-actions">
                                        <div style="margin-left: 0;" class="col-md-offset-3 col-md-9">
                                            <a class="btn" href="/version/add">
                                                <i class="icon-plus smaller-75"></i>
                                                添加版本号
                                            </a>
                                        </div>
                                    </div>
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
                                            <th>编号</th>
                                            <th>所属网站类型</th>
                                            <th>css版本号</th>
                                            <th>js版本号</th>
                                            <th>创建时间</th>
                                            <th>更新时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($list as $key => $val):?>
                                        <tr <?php if($key%2 !=0 ){ echo 'class="odd"';}?>>
                                            <td><?php echo $val['id']?></td>
                                            <td><?php echo $val['web_type']?></td>
                                            <td><?php echo $val['css_version_id']?></td>
                                            <td><?php echo $val['js_version_id']?></td>
                                            <td><?php echo $val['create_time']?></td>
                                            <td><?php echo $val['update_time']?></td>
                                            <td>
                                                <a href="/version/refresh/<?php echo $val['id'];?>" class="tablelink">刷新</a>   
                                                <a href="/version/del/<?php echo $val['id']?>" class="tablelink" onClick="if(confirm('你确定删除?'))return true;return false;">删除</a>
                                            </td>
                                        </tr> 
                                        <?php endforeach;?>
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
    function del(id, state) {
        window.location.href = '/news/del/'+id+'/'+state;
    }
</script>
<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
