<!-- 加载公用css -->
<?php $this->load->view('common/header2');?>

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
                        <a href="#">微活动</a>
                    </li>
                    <li>
                        <a href="#">活动管理</a>
                    </li>
                    <li class="active">微活动添加</li>
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
                        <!-- PAGE CONTENT BEGINS  enctype="multipart/form-data"-->
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 活动类型： </label>
                                <div class="col-sm-9">
                                    <select class="col-xs-3" name="type">
                                        <?php foreach (C('active_type') as $k => $v):?>
                                        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 活动名称： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" placeholder="活动名称" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 封面图： </label>
                                <div class="col-sm-9">
                                    <ul id="uploader_img_url">
    	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none; list-style-type:none">
    	                                   <a href="javascript:;" class="up-img"  id="btn_img_url"><span>+</span><br>添加照片</a>
    	                               </li>
	                               </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 开始时间： </label>
                                <div class="col-sm-9">
                                	<input name="start_time" placeholder="<?php echo date('Y-m-d H:i:s');?>" class="datainp col-xs-10 col-sm-5" id="start_time" type="text" placeholder="请选择"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 结束时间： </label>
                                <div class="col-sm-9">
                                    <input name="end_time" placeholder="<?php echo date('Y-m-d H:i:s');?>" class="datainp col-xs-10 col-sm-5" id="end_time" type="text" placeholder="请选择"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 未开始提示： </label>
                                <div class="col-sm-9">
                                	<input name="no_start_msg" value="活动未开始！"  class="datainp col-xs-10 col-sm-5"  type="text" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 已结束提示： </label>
                                <div class="col-sm-9">
                                    <input name="end_msg" value="活动已结束！" class="datainp col-xs-10 col-sm-5" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 人/每天/次： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="count" value="3" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 设置奖项（数量不限，请填 -1）： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="prize[prize_name][]" placeholder="奖项名称" title="奖项（如一等奖、二等奖、三等奖、谢谢参与）" class="col-xs-10 col-sm-1">
                                    <input type="text" name="prize[prize][]" placeholder="奖品" title="奖品" class="col-xs-10 col-sm-1">
                                    <input type="number" name="prize[v][]" placeholder="概率(0~1000)" title="概率，必须是整数， 概率总合（100或1000）" class="col-xs-10 col-sm-1">
                                    <input type="number" name="prize[num][]" placeholder="数量" title="数量（必须为整数，填-1时，表示数量不限）" class="col-xs-10 col-sm-1">
                                    <input type="number"  nam="prize[is_lottery][]" value="" placeholder="是中奖项填1，不是填0" title="是否是中奖选项（填1是，填0不是）" class="col-xs-10 col-sm-2">
                                    <button id="adds" style="width:50px;height:28px;margin-left: 5px;">+</button>
                                </div>
                            </div>
                            <div id="add_rows"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 简介： </label>
                                <div class="col-sm-4">
                                    <textarea class="form-control limited" name="desc" style="margin-top: 0px; margin-bottom: 0px; height: 171px;"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 图片形式简介： </label>
                                <div class="col-sm-9">
                                    <ul id="uploader_img_desc">
    	                               <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none; list-style-type:none">
    	                                   <a href="javascript:;" class="up-img"  id="btn_img_desc"><span>+</span><br>添加照片</a>
    	                               </li>
	                               </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 只能中奖一次(针对抽奖类)： </label>
                                <label class="col-sm-4">
                                    <label><input type="radio" name="is_one"  value="1">是</label>
                                    <label><input type="radio" name="is_one"  value="0">否</label>
                                </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否单页（针对投票类）： </label>
                                <label class="col-sm-4">
                                <label><input type="radio" name="singlepage"  value="0">非单页</label>
                                <label><input type="radio" name="singlepage"  value="1">单页</label>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否需要个人真实姓名、电话： </label>
                                <label class="col-sm-4">
                                <label><input type="radio" name="is_renzheng"  value="0">非必须</label>
                                <label><input type="radio" name="is_renzheng"  value="1">必须</label>
                            </div>
                            
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="submit">
                                        <i class="icon-ok bigger-110"></i>
                                        保存
                                    </button>
                                </div>
                            </div>
                            </from>
                    </div><!-- PAGE CONTENT ENDS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>
<script src="<?php echo get_css_js_url('jedate.js', 'common')?>"></script>
<script type="text/javascript">

    jeDate({
    	dateCell:"#start_time",
    	format:"YYYY-MM-DD hh:mm:ss",
    	isinitVal:true,
    	isTime:true, //isClear:false,
    	minDate:"2014-09-19 00:00:00",
    	okfun:function(val){}
    })
    jeDate({
    	dateCell:"#end_time",
    	format:"YYYY-MM-DD hh:mm:ss",
    	isinitVal:true,
    	isTime:true, //isClear:false,
    	minDate:"2014-09-19 00:00:00",
    	okfun:function(val){}
    })



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

    $('#adds').on('click', function(e){
        e.preventDefault();
    	var html  ='<div class="form-group">';
 	        html +='<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>';
    		html +='<div class="col-sm-9" id="add_rows">';
    	    html +='<input type="text" name="prize[prize_name][]" placeholder="奖项名称" title="奖项（如一等奖、二等奖、三等奖、谢谢参与）" class="col-xs-10 col-sm-1">';
            html +='<input type="text" name="prize[prize][]" placeholder="奖品" title="奖品" class="col-xs-10 col-sm-1">';
            html +='<input type="number" name="prize[v][]" placeholder="概率(0~1000)" title="概率，必须是整数， 概率总合（100或1000）" class="col-xs-10 col-sm-1">';
            html +='<input type="number" name="prize[num][]" placeholder="数量" title="数量（必须为整数，填-1时，表示数量不限）" class="col-xs-10 col-sm-1">';
            html +='<input type="number"  nam="prize[is_lottery][]" value="" placeholder="是中奖项填1，不是填0" title="是否是中奖选项（填1是，填0不是）" class="col-xs-10 col-sm-2">';
            html +='</div></div>';
    	$('#add_rows').append(html);
    });

    
</script>

<!-- 上传 -->
<?php $this->load->view("common/sea_footer");?>
<script type="text/javascript">
    var object = [
          {"obj": "#uploader_img_url", "btn": "#btn_img_url"},
          {"obj": "#uploader_img_desc", "btn": "#btn_img_desc"}
    ];
    
    seajs.use(['admin_uploader','jqueryswf','swfupload'], function(swfupload) {
    	swfupload.swfupload(object);
    });
    

</script>
<!-- 上传 -->

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
