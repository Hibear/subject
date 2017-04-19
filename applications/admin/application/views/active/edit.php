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
                    <li class="active">方舟戏台演员</li>
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
                        <!-- PAGE CONTENT BEGINS -->
                        <form class="form-horizontal" role="form" method="post" >
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 活动名称： </label>
                                <div class="col-sm-9">
                                	<input type="hidden" name="id" value="<?php echo $info['id']?>">
                                    <input type="text" name="title" value="<?php echo $info['title']?>" placeholder="活动名称" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 开始时间： </label>
                                <div class="col-sm-9">
                                	<input name="start_time" value="<?php echo $info['start_time'];?>" class="datainp col-xs-10 col-sm-5" id="start_time" type="text" placeholder="请选择"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 结束时间： </label>
                                <div class="col-sm-9">
                                    <input name="end_time" value="<?php echo $info['end_time'];?>" class="datainp col-xs-10 col-sm-5" id="end_time" type="text" placeholder="请选择"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 未开始提示： </label>
                                <div class="col-sm-9">
                                	<input name="no_start_msg" value="<?php echo $info['no_start_msg']?>"  class="datainp col-xs-10 col-sm-5"  type="text" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 已结束提示： </label>
                                <div class="col-sm-9">
                                    <input name="end_msg" value="<?php echo $info['end_msg']?>" class="datainp col-xs-10 col-sm-5" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 人/每天/次： </label>
                                <div class="col-sm-9">
                                    <input type="number" name="count" value="<?php echo $info['count']?>" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 设置奖项（数量不限，请填 -1）： </label>
                                <div class="col-sm-9">
                                    <button id="adds" style="width:50px;height:28px;margin-left: 5px;">+</button>
                                </div>
                            </div>
                            <div id="add_rows">
                                <?php if(isset($prize_lists)):?>
                                <?php foreach ($prize_lists as $k => $v):?>
                                <div id="rows_<?php echo $v['id']?>" class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 奖项（<?php echo $k+1?>）： </label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="active_id_<?php echo $v['id']?>" value="<?php echo $v['active_id']?>" />
                                    <input type="text" id="prize_name_<?php echo $v['id']?>" title="奖项（如一等奖、二等奖、三等奖、谢谢参与）" value="<?php echo $v['prize_name']?>" placeholder="奖项名称" class="col-xs-10 col-sm-1">
                                    <input type="text" id="prize_<?php echo $v['id']?>" title="奖品"  value="<?php echo $v['prize']?>" placeholder="奖品" class="col-xs-10 col-sm-1">
                                    <input type="number" id="v_<?php echo $v['id']?>" title="概率，必须是整数， 概率总合（100或1000）"  value="<?php echo $v['v']?>" placeholder="概率(0~100)" class="col-xs-10 col-sm-1">
                                    <input type="number"  id="num_<?php echo $v['id']?>" title="数量（必须为整数，填-1时，表示数量不限）" value="<?php echo $v['num']?>" placeholder="数量" class="col-xs-10 col-sm-1">
                                    <input type="number"  id="is_lottery_<?php echo $v['is_lottery']?>" title="是否是中奖选项（填1是，填0不是）" value="<?php echo $v['is_lottery']?>" placeholder="是中奖项填1，不是填0" class="col-xs-10 col-sm-2">
                                    <button class="update" data="<?php echo $v['id'];?>" style="width:50px;height:28px;margin-left: 5px;">更新</button>
                                    <button class="delete" data="<?php echo $v['id'];?>" style="width:50px;height:28px;margin-left: 5px;">-</button>
                                </div>
                                </div>
                                <?php endforeach;?>
                                <?php endif?>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 简介： </label>
                                <div class="col-sm-4">
                                    <textarea class="form-control limited" name="desc" style="margin-top: 0px; margin-bottom: 0px; height: 171px;"><?php echo $info['desc']?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 活跃度（访问）/次： </label>
                                <div class="col-sm-9">
                                    <input type="text" name="visits" value="<?php echo $info['visits']?>" class="col-xs-10 col-sm-5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 状态： </label>
                                <label class="col-sm-4">
                                    <label><input type="radio" name="is_del" <?php if(isset($info) && $info['is_del'] == 0){echo 'checked';}?> value="0">正常</label>
                                    <label><input type="radio" name="is_del" <?php if(isset($info) && $info['is_del'] == 1){echo 'checked';}?> value="1">删除</label>
                                </div>
                                
                                <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 只能中奖一次： </label>
                                <label class="col-sm-4">
                                    <label><input type="radio" name="is_one" <?php if(isset($info) && $info['is_one'] == 1){echo 'checked';}?> value="1">是</label>
                                    <label><input type="radio" name="is_one" <?php if(isset($info) && $info['is_one'] == 0){echo 'checked';}?> value="0">否</label>
                                </div>
                            </div>
                            <div class="clearfix">
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
<script src="/static/jedate/jedate.min.js"></script>
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
            html +='<input type="number"  nam="prize[is_lottery][]" placeholder="是中奖项填1，不是填0" title="是否是中奖选项（填1是，填0不是）" class="col-xs-10 col-sm-2">';
            html +='</div></div>';
    	$('#add_rows').append(html);
    });

    $('.delete').on('click', function(e){
    	e.preventDefault();
    	var _obj = $(this);
    	var id = _obj.attr('data');
    	var d = dialog({
            title: "提示",
            content: '确定删除该奖项吗？',
            okValue: '确定',
            ok: function () {
            	$.post('/active/del_prize', {'id' : id}, function(data){
            	    if(data){
            	        if(data.code == 1){
            	        	$('#rows_'+id).remove();
                	    }else{
                	        alert(data.msg)
                    	}
                	}else{
                	    alert('网络异常');
                    }
                })
            },
            cancelValue: '取消',
            cancel: function () {}
        });
        d.width(320);
        d.showModal();
    });

    $('.update').on('click', function(e){
    	e.preventDefault();
    	var _obj = $(this);
    	var id = _obj.attr('data');
    	var active_id = $('#active_id_'+id).val();
    	var prize_name = $('#prize_name_'+id).val();
    	var is_lottery = $('#is_lottery_'+id).val();
    	if(prize_name == '' || !prize_name){
    	    alert('奖项名称不能为空！');
    	    return false;
        }
    	var prize = $('#prize_'+id).val();
    	var v = $('#v_'+id).val();
    	var num = $('#num_'+id).val();
    	$.post('/active/update_prize', {'id' : id, 'active_id':active_id, 'prize_name':prize_name, 'prize':prize, 'v':v, 'num':num, 'is_lottery':is_lottery}, function(data){
    	    if(data){
    	        if(data.code == 1){
    	        	alert(data.msg)
        	    }else{
        	        alert(data.msg)
            	}
        	}else{
        	    alert('网络异常');
            }
        })
    });

    function alert(info){
    	var d = dialog({
    		content: info
    	});
    	d.show();
    	setTimeout(function () {
    		d.close().remove();
    	}, 2000);
    }
</script>

<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
