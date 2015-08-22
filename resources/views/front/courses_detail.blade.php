<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>园师课堂-课程详情页</title>
        <link href="/assets/css/header.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/spxqy.css" rel="stylesheet" type="text/css" /> 
		<script src="/assets/js/jquery-2.1.4.min.js"></script>
		<script src="/assets/js/spxqy.js"></script>
    </head>
            
    <body>
        <!--头部公共 引用开始-->
        @include('front.header')
        <!--头部公共 引用结束-->
		
		<!--视频简介-->
		<div id="content_jianjie">
				<!--图片简介-->
				<div class="spjj">
						<div class="pic"><img src="{{ url("$v->cover") }}" /></div>
				
						<!--文字简介-->
						<div class="wenzi">
								<h1>{{ $v->name }}</h1>
								<p>{{ $v->summary }}</p>
								<form action="{{ url("order") }}" method="get">
								<p><input type="submit" title="立即购买" value="立即购买 ￥{{ $v->totalprice }}"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="fz24 gray">原价&nbsp;<del>￥{{ $v->totalprice }}</del></span> </p>
								<p class="p3">可选单科&nbsp;&nbsp;&nbsp;&nbsp;
								@if($v->level == "zhongxue")
										<label><input type="checkbox" name="buy" value="" />&nbsp;教育知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value=""/>&nbsp;学科知识与能力</label>
								@elseif($v->level == "xiaoxue")
										<label><input type="checkbox" name="buy" value="" />&nbsp;教育教学知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;
								@elseif($v->level == "youer")
										<label><input type="checkbox" name="buy" value="" />&nbsp;保教知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;								
								@endif
								</p>
								<p class="p4">已有{{ $v->buytimes }}人购买该课程</p>
								</form>
						</div>
				</div>
		</div>		
		<!--课程详情-->
		<div id="content_xiangqing">
				<div class="left">
						<!--左侧标题-->
						<div class="title">
							<ul>
									<li class="title1 active">课程优势</li>
									<li class="title2">免费试听</li>
									<li class="title3">课程简介</li>
									<li class="title4">相关推荐</li>
							</ul>
						</div>
				<script>
					$("#content_xiangqing .title1").mouseover(function(){
							$(this).addClass("active").siblings().removeClass("active");
				   	  	    $("#content_xiangqing .content_kcys").removeClass("dn");
							$("#content_xiangqing .content_mfst").addClass("dn");
							$("#content_xiangqing .content_kcjj").addClass("dn");
							$("#content_xiangqing .content_xgtj").addClass("dn");
					});
					$("#content_xiangqing .title2").mouseover(function(){
							$(this).addClass("active").siblings().removeClass("active");
							$("#content_xiangqing .content_kcys").addClass("dn");
							$("#content_xiangqing .content_mfst").removeClass("dn");
							$("#content_xiangqing .content_kcjj").addClass("dn");
							$("#content_xiangqing .content_xgtj").addClass("dn");
					});
					$("#content_xiangqing .title3").mouseover(function(){
							$(this).addClass("active").siblings().removeClass("active");
							$("#content_xiangqing .content_kcys").addClass("dn");
							$("#content_xiangqing .content_mfst").addClass("dn");
							$("#content_xiangqing .content_kcjj").removeClass("dn");
							$("#content_xiangqing .content_xgtj").addClass("dn");					
					});
					$("#content_xiangqing .title4").mouseover(function(){
							$(this).addClass("active").siblings().removeClass("active");
							$("#content_xiangqing .content_kcys").addClass("dn");
							$("#content_xiangqing .content_mfst").addClass("dn");
							$("#content_xiangqing .content_kcjj").addClass("dn");
							$("#content_xiangqing .content_xgtj").removeClass("dn");					
					});	
				</script>
						<!--课程优势  内容部分-->
						<div class="content_kcys">
								<img src="/assets/img/spxqy_kcys.jpg" alt="课程优势" />
						</div>

						<!--免费试听  内容部分-->
						<div class="content_mfst dn">
								<div>
										<h3>中学协议金牌保过班</h3>
										<img src="/assets/img/spxqy_kechengshiting.jpg" alt="课程试听" />
								</div>
						</div>
						<!--课程简介  内容部分-->
						<div class="content_kcjj dn">
								<p><span class="red"><b>开课时间</b></span><br/>
每月周末新班<br/>
<span class="red"><b>课程属性</b></span><br/>
此课程面授、远程均有；学员在购买远程课程后立刻可在线观看学习；此课程支持购买单科<br/>
<span class="red">(一)学习课程</span><br/>
《教育学》或《教育心理学》，赠送试讲理论班<br/>
<span class="red">(一)学习课程</span><br/>
《教育学》或《教育心理学》，赠送试讲理论班<br/>
<span class="red"><b>课程说明</b></span><br/>
育德独家的课程体系，专业教学服务，赠送同步网校课程<br/>
注：签过关协议，面授不过退1200元，单科不过退600元；远程不过退500元，单科不过退300元或下期免费学<br/>
<span class="red"><b>赠送教材</b></span><br/>
育德教师资格考点解析+考试大纲+考试指定教材+教材习题答案+历年真题+考试独家密押卷+考题预测保密资料+海量模拟卷+课堂讲义+教学能<br/>
力测试提高班全套资料<br/>
<span class="red"><b>课程说明</b></span><br/>
育德独家的课程体系，专业教学服务，赠送同步网校课程<br/>
注：签过关协议，面授不过退1200元，单科不过退600元；远程不过退500元，单科不过退300元或下期免费学<br/>
<span class="red"><b>赠送教材</b></span><br/>
育德教师资格考点解析+考试大纲+考试指定教材+教材习题答案+历年真题+考试独家密押卷+考题预测保密资料+海量模拟卷+课堂讲义+教学<br/>
能力测试提高班全套资料</p>
						</div>
						<!--相关推荐  内容部分-->
						<div class="content_xgtj dn">
								<h2 class="jpkc ml14">精品课程推荐</h2>
								<!--答题技巧-->
								<ul class="dtjq ml14">
										<li class="mr16"><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
										<li class="mr16"><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
										<li><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
								</ul>
								<h2 class="ptjc ml14">配套教材推荐</h2>
								<ul class="ptjctj ml14">
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li>
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
								</ul>
						</div>
				</div>

				<div class="right1">
							<h3>中学协议金牌保过班金牌</h3>
							<p><b>总课时：</b>103课时<br/>
<b>内  容：</b>免费赠送配套教材、讲义、考试大纲、真题模
考试卷、冲刺讲义、面试讲义全套资料</p>
				</div>
				<div class="right2">
						<div><img src="/assets/img/spxqy_teacher.png" alt="老师" /></div>
						<h3 class="orange fontyh">主讲老师：董老师</h3>
						<p>育德独家金牌讲师,某高校教师,主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验考试政策,丰富的实战培训经验</p>
				</div>
				<div class="right3">
						<a href="#"><img src="/assets/img/spxqy_right3_banner.png" alt="" /></a>
				</div>
		</div>
		
		
		
		
		
		
		
		
        <!--尾部公共 引用开始-->
		@include('front.footer')
        <!--尾部公共 引用结束-->
    </body>

</html>
