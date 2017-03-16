
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>国宾府业主调查问卷</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="">
    <meta name="keywords" content="">
	<link href="/static/questionnaire/risk_test.css" rel="stylesheet" />
	<link href="/static/layui/css/layui.css" rel="stylesheet" />
</head>

<body style="background-color:#B3B3B3">
    <div class="success">
		<p style="padding-top:100px;"><i class="layui-icon">&#xe60c;</i> 	</p>
		<p>提交成功</p>
	</div>
    <div class="ping">
	
		<div class="main">
			<div class="title-head">填写用户信息</div>
			<div class="bankcardadd-item">
			<div class="left">
				姓名
				</div>
				<div class="right">
					<input type="text" name="name" id="name" value="" autofocus="autofocus" placeholder="请输入姓名">
				</div>
					
			</div>
			<div class="bankcardadd-item">
				<div class="left">
					电话
				</div>
				<div class="right">
					<input type="text" name="tel" id="tel" value="" placeholder="请输入电话">
				</div>
					
			</div>
			<div class="bankcardadd-item" style="border:0px; width:80%;">
				<input type="submit" class="btn" value="保存" style="margin-left:20%;">
			</div>
		</div>
	
	</div>
	<div class="wrapper">
    	<div id="answer" class="card_wrap">
        	<!--Q1-->
       	  	<div class="card_cont card1">
            	<div class="card">
					<p class="question"><span>Q1、</span>您的年龄是？</p>
                    <ul class="select">
					    <input type="hidden" value="您的年龄是？" class="question">
					    <input type="hidden" value="1" class="pid">
                        <li>
                            <input id="q1_1" type="radio" name="r-group-1" >
                            <label for="q1_1" >20岁以下</label>
                        </li>
						<li>
                            <input id="q1_2" type="radio" name="r-group-1">
                            <label for="q1_2">20-30岁</label>
                        </li>
                        <li>
                            <input id="q1_3" type="radio" name="r-group-1">
                            <label for="q1_3" >30-40岁</label>
                        </li>
                        <li>
                            <input id="q1_4" type="radio" name="r-group-1">
                            <label for="q1_4">40岁以上</label>
                        </li>
                       
                    </ul>
                    <div class="card_bottom"><span><b>1</b>/10</span></div>
                </div>
            </div>
            <!--Q2-->
          	<div class="card_cont card2" >
            	<div class="card">
                	<p class="question"><span>Q2、</span>您是如何知道国宾府项目的？(多选)</p>
					<ul class="select">
					    <input type="hidden" value="您购买的是我们美的国宾府的什么产品？" class="question">
					    <input type="hidden" value="2" class="pid">
                        <li>
                            <input id="q2_1" type="checkbox" name="r-group-2" >
                            <label for="q2_1" data-type="1">户外广告</label>
                        </li>
                        <li>
                            <input id="q2_2" type="checkbox" name="r-group-2">
                            <label for="q2_2" data-type="1">网络广告</label>
                        </li>
                        <li>
                            <input id="q2_3" type="checkbox" name="r-group-2">
                            <label for="q2_3" data-type="1">电台广告</label>
                        </li>
                        <li>
                            <input id="q2_4" type="checkbox" name="r-group-2">
                            <label for="q2_4" data-type="1">宣传单页</label>
                        </li>
						<li>
                            <input id="q2_5" type="checkbox" name="r-group-2">
                            <label for="q2_5" data-type="1">朋友介绍</label>
                        </li>
						<li>
                            <input id="q2_6" type="checkbox" name="r-group-2">
                            <label for="q2_6" data-type="1">外展点</label>
                        </li>
                        <li>
                            <input id="q2_7" type="checkbox" name="r-group-2">
                            <label for="q2_7" data-type="1">路过项目</label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a>&nbsp;&nbsp;<a class="next">下一题</a><span><b>2</b>/10</span></div>
                </div>
            </div>
            <!--Q3-->
          	<div class="card_cont card3">
            	<div class="card">
                	<p class="question"><span>Q3、</span>您的居住区域为？</p>
                	<ul class="select">
					    <input type="hidden" value="您的居住区域为？" class="question">
					    <input type="hidden" value="3" class="pid">
                     <li>
                            <input id="q3_1" type="radio" name="r-group-3" >
                            <label for="q3_1" >花溪区</label>
                        </li>
                        <li>
                            <input id="q3_2" type="radio" name="r-group-3">
                            <label for="q3_2" >小河区</label>
                        </li>
                        <li>
                            <input id="q3_3" type="radio" name="r-group-3">
                            <label for="q3_3" >南明区</label>
                        </li>
                        <li>
                            <input id="q3_4" type="radio" name="r-group-3">
                            <label for="q3_4" >云岩区</label>
                        </li>
                        <li>
                            <input id="q3_5" type="radio" name="r-group-3">
                            <label for="q3_5" >观山湖区</label>
                        </li>
						<li>
                            <input id="q3_6" type="radio" name="r-group-3">
                            <label for="q3_6" >白云区</label>
                        </li>
						<li>
                            <input id="q3_7" type="radio" name="r-group-3">
                            <label for="q3_7" >乌当区</label>
                        </li>
						<li>
                            <input id="q3_8" type="radio" name="r-group-3">
                            <label for="q3_8" >三县一市</label>
                        </li>
						<li>
                            <input id="q3_9" type="radio" name="r-group-3">
                            <label for="q3_9" >地州</label>
                        </li>
						<li>
                            <input id="q3_10" type="radio" name="r-group-3">
                            <label for="q3_10" >外省</label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a><span><b>3</b>/10</span></div>
                </div>
            </div>
            <!--Q4-->
          	<div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q4、</span>您的工作区域为？</p>
               	  <ul class="select">
						<input type="hidden" value="您的工作区域为？" class="question">
					    <input type="hidden" value="4" class="pid">
                        <li>
                            <input id="q4_1" type="radio" name="r-group-4" >
                            <label for="q4_1">花溪区</label>
                        </li>
                        <li>
                            <input id="q4_2" type="radio" name="r-group-4">
                            <label for="q4_2">小河区</label>
                        </li>
                        <li>
                            <input id="q4_3" type="radio" name="r-group-4">
                            <label for="q4_3">南明区</label>
                        </li>
                        <li>
                            <input id="q4_4" type="radio" name="r-group-4">
                            <label for="q4_4">云岩区</label>
                        </li>
						<li>
                            <input id="q4_5" type="radio" name="r-group-4">
                            <label for="q4_5">观山湖区</label>
                        </li>
						<li>
                            <input id="q4_6" type="radio" name="r-group-4">
                            <label for="q4_6">白云区</label>
                        </li>
						<li>
                            <input id="q4_7" type="radio" name="r-group-4">
                            <label for="q4_7">乌当区</label>
                        </li>
						<li>
                            <input id="q4_8" type="radio" name="r-group-4">
                            <label for="q4_8">三县一市</label>
                        </li>
						<li>
                            <input id="q4_9" type="radio" name="r-group-4">
                            <label for="q4_9">地州</label>
                        </li>
						<li>
                            <input id="q4_10" type="radio" name="r-group-4">
                            <label for="q4_10">外省</label>
                        </li>
                      
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a><span><b>4</b>/10</span></div>
                </div>
            </div>
            <!--Q5-->
            <div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q5、</span>您购买的是我们美的国宾府的什么产品？（多选）</p>
                	<ul class="select">
						<input type="hidden" value="您购买的是我们美的国宾府的什么产品？" class="question">
					    <input type="hidden" value="5" class="pid">
                         <li>
                            <input id="q5_1" type="checkbox" name="r-group-5">
                            <label for="q5_1" data-type='1'>洋房</label>
                        </li>
                        <li>
                            <input id="q5_2" type="checkbox" name="r-group-5">
                            <label for="q5_2" data-type='1'>高层</label>
                        </li>
                        <li>
                            <input id="q5_3" type="checkbox" name="r-group-5">
                            <label for="q5_3" data-type='1'>商铺</label>
                        </li>
						<li>
                            <input id="q5_4" type="checkbox" name="r-group-5">
                            <label for="q5_4" data-type='1'>公寓</label>
                        </li>
                      
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a>&nbsp;&nbsp;<a class="next">下一题</a><span><b>5</b>/10</span></div>
                </div>
            </div>
            <!--Q6-->
            <div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q6、</span>您是因为什么原因选择美的国宾府？（多选）</p>
                	<ul class="select">
						<input type="hidden" value="您是因为什么原因选择美的国宾府？" class="question">
					    <input type="hidden" value="6" class="pid">
                        <li>
                            <input id="q6_1" type="checkbox" name="r-group-6" >
                            <label for="q6_1" data-type='1'>区位优势突出</label>
                        </li>
                        <li>
                            <input id="q6_2" type="checkbox" name="r-group-6">
                            <label for="q6_2" data-type='1'>生活环境优美</label>
                        </li>
                        <li>
                            <input id="q6_3" type="checkbox" name="r-group-6">
                            <label for="q6_3" data-type='1'>商业配套齐全</label>
                        </li>
                        <li>
                            <input id="q6_4" type="checkbox" name="r-group-6">
                            <label for="q6_4" data-type='1'>教育资源齐备 </label>
                        </li>
                        <li>
                            <input id="q6_5" type="checkbox" name="r-group-6">
                            <label for="q6_5" data-type='1'>物业服务良好</label>
                        </li>
						<li>
                            <input id="q6_6" type="checkbox" name="r-group-6">
                            <label for="q6_6" data-type='1'>交通出行便利</label>
                        </li>
						<li>
                            <input id="q6_7" type="checkbox" name="r-group-6">
                            <label for="q6_7" data-type='1'>美的地产品牌</label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a>&nbsp;&nbsp;<a class="next">下一题</a><span><b>6</b>/10</span></div>
                </div>
            </div>
            <!--Q7-->
          	<div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q7、</span>您家拥有的汽车数量为？</p>
                	<ul class="select select7">
						<input type="hidden" value="您家拥有的汽车数量为？" class="question">
					    <input type="hidden" value="7" class="pid">
						<li>
                            <input id="q7_1" type="radio" name="r-group-7" >
                            <label for="q7_1" >没有</label>
                        </li>
						<li>
                            <input id="q7_2" type="radio" name="r-group-7">
                            <label for="q7_2">1辆</label>
                        </li>
                        <li>
                            <input id="q7_3" type="radio" name="r-group-7">
                            <label for="q7_3" >2辆</label>
                        </li>
                        <li>
                            <input id="q7_4" type="radio" name="r-group-7">
                            <label for="q7_4">3辆以上</label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a><span><b>7</b>/10</span></div>
                </div>
            </div>
            <!--Q8-->
          	<div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q8、</span>您可以接受的车位价格为？</p>
                	<ul class="select">
						<input type="hidden" value="您可以接受的车位价格为？" class="question">
					    <input type="hidden" value="8" class="pid">
                        <li>
                            <input id="q8_1" type="radio" name="r-group-9">
                            <label for="q8_1">70000-80000元/个</label>
                        </li>
                        <li>
                            <input id="q8_2" type="radio" name="r-group-9">
                            <label for="q8_2">80000-90000元/个</label>
                        </li>
                        <li>
                            <input id="q8_3" type="radio" name="r-group-9">
                            <label for="q8_3">90000-100000元/个</label>
                        </li>
                        <li>
                            <input id="q8_4" type="radio" name="r-group-9">
                            <label for="q8_4">100000元/个以上 </label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a><span><b>8</b>/10</span></div>
                </div>
            </div>
            
			<!--Q9-->
          	<div class="card_cont">
            	<div class="card">
                	<p class="question"><span>Q9、</span>您对这次业主活动满意吗？</p>
                	<ul class="select">
						<input type="hidden" value="您对这次业主活动满意吗？" class="question">
					    <input type="hidden" value="9" class="pid">
                        <li>
                            <input id="q9_1" type="radio" name="r-group-9">
                            <label for="q9_1">非常满意</label>
                        </li>
                        <li>
                            <input id="q9_2" type="radio" name="r-group-9">
                            <label for="q9_2">比较满意</label>
                        </li>
                        <li>
                            <input id="q9_3" type="radio" name="r-group-9">
                            <label for="q9_3">一般</label>
                        </li>
                        <li>
                            <input id="q9_4" type="radio" name="r-group-9">
                            <label for="q9_4">不满意</label>
                        </li>
                    </ul>
                    <div class="card_bottom"><a class="prev">上一题</a><span><b>9</b>/10</span></div>
                </div>
            </div>
			<!--Q10-->
			
			
          	<div class="card_cont">
            	<div class="card">
					<input type="hidden" value="您对这次活动或以后的活动组织有什么意见与建议(1-3条)?" class="question">
                	<p class="question"><span>10、</span>您对这次活动或以后的活动组织有什么意见与建议(1-3条)?</p>
                	 <p  style="padding-top:15px;">
						<textarea id="tips" autofocus="autofocus" placeholder="请输入意见与建议"></textarea>
					</p>
				
					<p style="color: #F77514;padding-top: 10px;font-size: 16px; text-align: center;">约30㎡起临街金铺 认筹盛启</p>
					<p style="color: #F77514;padding-top: 6px;font-size: 16px; text-align: center;">130-200㎡湖居墅质洋房置业98折</p>
					<p style="color: #F77514;padding-top: 6px;font-size: 16px; text-align: center;">约99-143㎡高层景观华宅 新品加推</p>
					<div class="card_bottom"><a class="prev">上一题</a>&nbsp;&nbsp; <a class="sub">提交</a><span><b>10</b>/10</span></div>
                </div>
            </div>
    	</div><!--/card_wrap-->

	</div>

    <script src="/static/questionnaire/jquery-1.8.3.min.js"></script>
    <script src="/static/questionnaire/answer.js"></script>
    <script src="/static/layui/layui.js"></script>
    <script>
	var name = "";
	var tel = "";
	var layer = '';
	layui.use(['layer'], function(){
		layer = layui.layer
	});

	$(function(){
		$("#answer").answerSheet({});
		
		$(".btn").click(function(){
			var username = $("#name").val();
			var usertel = $("#tel").val();
			
			if(username == ""){
			   layer.msg('姓名不能为空');
				return ;
		    }
		   
			if(usertel == ""){
			   layer.msg('电话不能为空');
				return ;
		   }
		   
		   if(!(/^1(3|4|5|7|8)\d{9}$/.test(usertel))){ 
				
				layer.msg('手机号码有误，请重填');				
				return false; 
			} 
			
			window.name = 	username;
			window.tel = 	usertel;
			layer.msg('保存成功,请开始答题!');		
			$(".ping").hide();
		  
		   
		});
	})
	
	
    </script>
</body>

</html>
