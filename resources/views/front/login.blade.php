@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂-用户登录 @stop


{{-- Content --}}
@section('content')
<div id="background" class="dn"></div>	    
    @include('errors.list')
	
		<!--登录、注册部分 引用开始-->		
		<div id="register">
						
				<div class="login">
						<div class="banner"></div>
						<div class="message">
								<form id="login_form_2" action="{{ url("auth/login") }}" method="post"> 
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/>  
								<input type="hidden" class="form-control" name="url" value="{{ isset($url) ? $url : "" }}">
										<h3>登录学习精彩课程</h3>
										<span id="login_form_hint_2" class="cff3e3e dn">× 用户名/密码错误</span>
										<p><span class="font_st fs14 c666">账号</span> <input type="text" id="login_phone_2" placeholder="请输入用户名/手机号" name="phone" alt="请输入用户名/手机号" class="username"/></p>
										<p><span class="font_st fs14 c666">密码</span> <input type="password" id="login_password_2" placeholder="请输入密码" name="password" alt="请输入密码" class="password"/></p>
										<p class="ml37">
												<input type="checkbox" name="checkbox" class="checkbox"/>
												<span class="font_st fs12 c999">保存密码</span>
												&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="hand"><span class="font_st fs12 c0790fe" id="forget2">忘记密码？</span></a>
										</p>										
										<p class="ml37"><input id="login_submit_2" type="submit" value="登录" class="submit"/></p>
										<p class="ml37"><a href="#"><span class="font_st fs12 c999">没有园师课堂账号？</span></a>&nbsp;&nbsp;<a class="hand"><span id="quickreg" class="font_st fs12 c0790fe">快速注册</span></a></p>
								</form>
						</div>
						
				</div>
				<div class="remember dn">
					<p>忘记密码请拨打 <span class="ccc0202">010-62053248</span><br/>
工作人员会协助您找回密码</p>
					<a class="hand"><div>返回登录</div></a>
					<img src="/assets/img/reg_close_ico.png" id="close3" onclikc="alert(3)" />
				</div>

		
		</div>
        <div style="height: 580px"></div>
@endsection		