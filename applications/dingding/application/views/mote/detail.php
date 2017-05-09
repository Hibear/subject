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
                        <a href="#">报名管理</a>
                    </li>
                    <li>
                        <a href="/moteusers">报名列表</a>
                    </li>
                    <li class="active">报名详情</li>
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
                <div class="page-header">
                    <h1>模特报名人员详情</h1>
                </div>

                <div class="row">
                   <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                        <li class="active">
                                            <a data-toggle="tab" href="#basic">基本信息</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#points">报名图片</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="basic" class="tab-pane in active">
                                            <div class="profile-user-info profile-user-info-striped">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 中文姓名 </div>
                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click" id="user_name"><?php echo $info['user_name'];?></span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 姓名拼音 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['py_name'];?></span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 年龄 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['age'];?></span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 身高 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['height'];?>cm</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 胸围 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['bust'];?>cm</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 腰围 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['waistline'];?>cm</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 臀围 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['hipline'];?></span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 国籍 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['nationality'];?></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 出生年月 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['birth_date'];?></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 海选城市 </div>

                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click"><?php echo $info['city'];?></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 审核状态</div>

                                                    <div class="profile-info-value">
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
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 操作 </div>
                                                    <div class="profile-info-value">
                                                        <a href="/moteusers/set_auth/<?php echo $info['id'];?>/1">审核通过</a>
                                                        <a href="/moteusers/set_auth/<?php echo $info['id'];?>/2">审核未通过</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="points" class="tab-pane">
                                            <?php if(count($info['cover_img']) > 0):?>
                                                <?php foreach ($info['cover_img'] as $value) : ?>
                                                    <a href="<?php echo $value;?>" target="_blank">
                                                        <img src="<?php echo $value;?>" style="width:300px; height:200px" />
                                                    </a>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </div>
                                    </div>
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
