@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂  @stop

@section('styles') 
        <link href="/assets/css/personal.css" rel="stylesheet" type="text/css" /> 
@stop

{{-- Content --}}
@section('content')	
		<!--登录、注册部分 引用结束-->	
<div class="clearfloat"></div>		

<!--个人中心-->
<div id="personal">

	<div class="content">
			<div class="left">
					<ul>
							<a href=""><li><span class="s1"></span>购物车</li></a>
							<a href=""><li><span class="s2"></span>学习课程</li></a>
							<a href=""><li><span class="s3"></span>课程购买</li></a>
							<a href=""><li><span class="s4"></span>教材购买</li></a>
							<a href=""><li><span class="s5"></span>在线咨询</li></a>
							<a href="javascript:xgmm();"><li><span class="s6"></span>修改密码</li></a>
					</ul>
			</div>
			<div class="right">
					<div class="title">
							<span class="c434343 fs14 ffst fwb mr214">我的定单</span>
							<span class="c5a5a5a fs14 ffst mr214">定单详情</span>
							<span class="c5a5a5a fs14 ffst mr93">金额</span>
							<span class="c5a5a5a fs14 ffst mr123">定单状态</span>
							<span class="c5a5a5a fs14 ffst">操作</span>
					</div>
					<!--我的订单  有订单-->
					<div class="order dn">
							<table>
									<tr class="tr_o_h">
											<td class="wddd">2015-08-09  13:07:28</td>
											<td class="ddxq border_r">订单编号：100065853</td>
											<td class="je border_r">&nbsp;</td>
											<td class="ddzt border_r">&nbsp;</td>
											<td class="cz">&nbsp;</td>
									</tr>
									<tr class="tr_c_h">
											<td><div><img src="./Images/personal_ico_kecheng1.png" /></div></td>
											<td class="border_r">
													<p>
															中学金牌保过班<br/>
包含子科：教育知识与能力  综合素质  学科知识与能力<br/>
课程总课时：103课时
													</p>
											</td>
											<td rowspan="2" class="border_r">
																								<span>
															<b>￥1680.00</b><br/>
支付宝支付
													</span>
											</td>
											<td rowspan="2" class="border_r"><a>待付款</a></td>
											<td rowspan="2"><span>去付款 | <a href="#">修改订单</a> | 删除订单</span></td>
									</tr>
									<tr class="tr_c_h">
											<td><div><img src="./Images/personal_ico_book1.png" /></div></td>
											<td class="border_r">
													<p>
															教育知识与能力<br/>
出版社：清华大学出版社<br/>
购买数量：2
													</p>
											</td>
											<td>&nbsp;</td>
											
											
									</tr>									
									<tr class="tr_o_h">
											<td>2015-08-09  13:07:28</td>
											<td class="border_r">订单编号：100065853</td>
											<td class="border_r">&nbsp;</td>
											<td class="border_r">&nbsp;</td>
											<td>&nbsp;</td>
									</tr>
									<tr class="tr_c_h">
											<td><div><img src="./Images/personal_ico_kecheng1.png" /></div></td>
											<td class="border_r">
													<p>
															中学金牌保过班<br/>
包含子科：教育知识与能力  综合素质  学科知识与能力<br/>
课程总课时：103课时
													</p>
											</td>
											<td class="border_r">
													<span>
															<b>￥480.00</b><br/>
银行汇款
													</span>
											</td>
											<td class="border_r"><a>待确认</a></td>
											<td><span>汇款成功后请致电<br/>
4000-607-107确认<br/>
确认后完成订单</span></td>
									</tr>
									<tr class="tr_o_h">
											<td>2015-08-09  13:07:28</td>
											<td class="border_r">订单编号：100065853</td>
											<td class="border_r">&nbsp;</td>
											<td class="border_r">&nbsp;</td>
											<td>&nbsp;</td>
									</tr>
									<tr class="tr_c_h">
											<td><div><img src="./Images/personal_ico_book1.png" /></div></td>
											<td class="border_r">
													<p>
															教育知识与能力<br/>
出版社：清华大学出版社<br/>
购买数量：1
													</p>
											</td>
											<td class="border_r">
													<span>
															<b>￥39.00</b><br/>
网银支付
													</span>
											</td>
											<td class="border_r"><a>已完成</a></td>
											<td><span>如需修改订单信息或收件人信息<br/>
请拨打4000-607-107</span></td>
									</tr>							
								
							</table>
					</div>
					<!--我的订单  无订单-->
					<div class="no_order">
						<p>你还没有任何订单，赶紧去看看吧O(∩_∩)O~</p>
						<div><a href="#" class="bgr mr22">查看课程</a><a href="#" class="bgb">查看教材</a></div>
					</div>
			</div>
	</div>
	<div id="personal_xgmm" class="dn">
			<form action="" type="post">
					<h2>登录密码修改</h2>
					<label>已绑定手机号：158****3344</label><br/>
					<p><input type="text" name="tel" class="tel mr10" placeholder="  请填写手机验证码" /><a href="">免费获取</a><br/>
					<span class="dn">验证码错误</span></p>
					<p>填写新密码<input type="password" name="pwd" class="ml10"/><br/>
					<span class="dn">密码格式错误</span></p>
					<p>确认新密码<input type="password" name="repwd" class="ml10" /><br/>
					<span class="dn">两次密码输入不一致</span></p>
					<input type="submit" value="确认修改" class="submit"/>
			</form>
	<img src="/assets/img/reg_close_ico.png" id="xgmm_close" />		
	</div>
	
</div>



<div class="clear h20"></div>

@endsection

@section('scripts')

	<script type="text/javascript" src="/assets/js/personal.js"></script>
@endsection
