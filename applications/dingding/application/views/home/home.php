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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 物件名称： </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" value="<?php if(isset($name)){ echo $name;}?>"  class="col-xs-10 col-sm-12" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                              <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类 </label>
                                              <div class="col-sm-9">
                                                    <select class="col-xs-9" name="cate_id">
                                                        <?php if($cate):?>
                                                        <?php foreach ($cate as $k => $v):?>
                                                            <option <?php if(isset($cate_id) && $cate_id == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                                        <?php endforeach;?>
                                                        <?php endif;?>
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
                                                <a class="btn" href="/home/add">
                                                    <i class="icon-plus smaller-75"></i>
                                                    添加物件
                                                </a>
                                                                                                <a class="btn" href="/home/cate">
                                                    <i class="ace-icon fa fa-wrench icon-only smaller-75"></i>
                                                    分类管理
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
                                            <th>编号</th>
                                            <th>物件名称</th>
                                            <th>分类</th>
                                            <th>总数</th>
                                            <th>借出数</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($lists)):?>
                                        <?php foreach ($lists as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $value['id'];?></td>
                                                <td><?php echo $value['number']?></td>
                                                <td><?php echo $value['name'];?></td>
                                                <td>
                                                    <?php
                                                       if($cate){
                                                           foreach ($cate as $k => $v){
                                                               if($v['id'] == $value['cate_id']){
                                                                   echo $v['name'];
                                                                   break;
                                                               }
                                                           }
                                                       }
                                                    ?>
                                                 </td>
                                                <td id="t_<?php echo $value['id']?>"><?php echo $value['num']?></td>
                                                <td id="o_<?php echo $value['id']?>"><?php echo $value['out_num']?></td>
                                                <td>
                                                    <p onclick="edit(<?php echo $value['id']?>)" class="btn btn-minier btn-purple">编辑</p>
                                                    <p onclick="del(<?php echo $value['id']?>)" class="btn btn-minier btn-purple">删除</p>
                                                    <p data="<?php echo $value['id']?>" class="btn btn-minier btn-purple borrow">借出</p>
                                                    <p onclick="borrow(<?php echo $value['id']?>)" class="btn btn-minier btn-purple">查看记录</p>
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
    function del(id){
        window.location.href = "/home/del?id="+id;
    }
    function edit(id){
        window.location.href = "/home/edit?id="+id;
    }
    function borrow(id){
        window.location.href = "/borrow/index?id="+id;
    }
</script>
<script src="https://g.alicdn.com/dingding/dingtalk-pc-api/2.7.0/index.js"></script>
    <script type="text/javascript">
    DingTalkPC.config({
        agentId: "<?php echo $config['agentid']?>", // 必填，微应用ID
        corpId: "<?php echo $config['corpid']?>",   //必填，企业ID
        timeStamp: "<?php echo $config['timestamp']?>", // 必填，生成签名的时间戳
        nonceStr: "<?php echo $config['nonce']?>", // 必填，生成签名的随机串
        signature: "<?php echo $config['signature']?>", // 必填，签名
        jsApiList: [
            'device.notification.alert',
            'device.notification.confirm',
            'biz.contact.choose'
        ] // 必填，需要使用的jsapi列表
    });

    DingTalkPC.ready(function(res){
    	//选人
    	$('.borrow').on('click', function(){
    	    var id = $(this).attr('data');
    	    var _num = parseInt($('#t_'+id).text());
    	    var _out_num = parseInt($('#o_'+id).text());
    	    if( _num == _out_num){
    	    	alert('已借完，请先等待其他同事归还');return false;
        	}
    	    DingTalkPC.biz.contact.choose({
        	    multiple: false, //是否多选： true多选 false单选； 默认true
        	    users: [], //默认选中的用户列表，员工userid；成功回调中应包含该信息
        	    corpId: '<?php echo $config['corpid']?>', //企业id
        	    max: 10, //人数限制，当multiple为true才生效，可选范围1-1500
        	    onSuccess: function(data) {
        	        var emplId = data[0]['emplId'];
        	        var name = data[0]['name'];
        	        $.post('/borrow/out', {'borrow_id':id, 'userid':emplId, 'name':name}, function(data){
        	            if(data){
        	                if(data.code == 0){
        	                    alert(data.msg);return;
            	            }
            	            //获取当前物件借出的数量
            	            var num = parseInt($('#o_'+id).text()) +1;
            	            $('#o_'+id).text(num);
        	                alert(data.msg);
            	        }else{
            	            alert('网络错误');
                	    }
            	    })          	
        	    },
        	    onFail : function(err) {}
        	});
        })
    	
    });

    

    DingTalkPC.error(function(error){
  	});

  	function alert(msg){
  		DingTalkPC.device.notification.alert({
    	    message: msg,
    	    title: "提示",//可传空
    	    buttonName: "确定",
    	    onSuccess : function() {
    	        /*回调*/
    	    },
    	    onFail : function(err) {}
    	});
  	}
    </script>
<!-- 底部 -->
<?php $this->load->view("common/bottom");?>
