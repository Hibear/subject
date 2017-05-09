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
                        <a href="#">微活动</a>
                    </li>
                    
                </ul>
            </div>

            <div class="page-content">
               

                <div class="row">
                    <div class="col-xs-12">
                        <form  action="/yanhua/index" method="post" class="form-horizontal" id="add_form" role="form">
                           

						   <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  活动名称： </label>
								<div class="col-sm-6">
                                    <input type="text" name="name" required="required" value="<?php echo $lottery['name'];?>"   placeholder="请输入活动名称" class="col-xs-12 col-sm-5">
                                     <span class="help-inline col-xs-12 col-sm-7 form-field-description-block">
                                       <span class="middle"> <i id="price_msg" style="font-style: normal"></i></span>
									</span>
                                </div> 
                            </div>
							<!--
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  一等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="fist" required="required" value="<?php echo $lottery['fist'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="fistnums" required="required" value="<?php echo $lottery['fistnums'];?>"   placeholder="输入数字" class="col-xs-6">
								  </div> 
								
                            </div>  
								
							
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  二等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="second"  value="<?php echo $lottery['second'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="secondnums"  value="<?php echo $lottery['secondnums'];?>"   placeholder="输入数字" class="col-xs-6">
                                 </div> 
                            </div>  
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  三等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="third"  value="<?php echo $lottery['third'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="thirdnums"  value="<?php echo $lottery['thirdnums'];?>"   placeholder="输入数字" class="col-xs-6">
                                 </div> 
                            </div>  
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  四等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="four"  value="<?php echo $lottery['four'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="fournums"  value="<?php echo $lottery['fournums'];?>"   placeholder="输入数字" class="col-xs-6">
                                 </div> 
                            </div>  
							
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  五等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="five"  value="<?php echo $lottery['five'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="fivenums"  value="<?php echo $lottery['fivenums'];?>"   placeholder="输入数字" class="col-xs-6">
                                 </div> 
                            </div>  
							
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  六等奖： </label>
								<div class="col-sm-2">
                                    <input type="text" name="six"  value="<?php echo $lottery['six'];?>"   placeholder="请输入奖品名称" class="col-xs-12">
                                 </div> 
								 <label class="col-sm-1 control-label" for="form-field-1" style="width:70px;">  概率： </label>
								 <div class="col-sm-2">
								  <input type="text" name="sixnums"  value="<?php echo $lottery['sixnums'];?>"   placeholder="输入数字" class="col-xs-6">
                                 </div> 
                            </div>  
							-->
							
							
							 <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  活动说明： </label>

                                <div class="col-sm-9">
                                    <textarea id="form-field-11" name="info" placeholder="活动说明。最多300字。" class="autosize-transition col-xs-12 col-sm-6" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php echo $lottery['info'];?></textarea>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> </label>

                                <div class="col-sm-9">
									<label>
										<input name="switch" type="radio" <?php if($lottery['switch'] == 1){?> checked="checked"<?php } ?> value="1" class="ace">
										<span class="lbl"> 开启</span>
									</label>
									<label>
										<input name="switch" type="radio" <?php if($lottery['switch'] == 0){?> checked="checked"<?php } ?>  value="0" class="ace">
										<span class="lbl"> 关闭</span>
									</label>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  地址 </label>
								<div class="col-sm-4">
                                    http://h5.wesogou.com/fireworks/index
									
                                </div>
                            </div>

                           

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="submit" id="subbtn">
                                        <i class="icon-ok bigger-110"></i>
                                        确定
                                    </button>
								</div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
</div>



<!-- 加载尾部公用js -->
<?php $this->load->view("common/footer");?>
<script src="<?php echo css_js_url('select2.min.js','admin');?>"></script>

    <script type="text/javascript">
        $(function(){
         
        });
    </script>
<!-- 底部 -->
<?php $this->load->view("common/bottom");?>


