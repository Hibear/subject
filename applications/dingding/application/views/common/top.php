<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                    仓库管理系统
                </small>
            </a>
        </div>

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="<?php if($userInfo['headimg']){echo $userInfo['headimg'];}else{ echo $domain['static']['url'].'/admin/images/default.png';} ?>" alt="Jason's Photo" />
							<span class="user-info">
								<small>欢迎,</small>
								<?php echo $userInfo['name'];?>
							</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>