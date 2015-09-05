        <div id="background" class="dn"></div>	    
        <!--头部公共 引用开始-->
        <div id="header">
            <div class="head"> 
                <div><a href="/"><img src="/assets/img/logo.png"  id="logo"></a></div>
                <ul>
                    <li><a href="/">首页</a></li>
                    <li>|</li>
                    <li><a href="{{ url("courses/lists") }} ">视频课</a></li>
                    <li>|</li>
                    <li><a href="{{ url("courses/lists") }}">直播课</a></li>
                    <li>|</li>
                    <li><a href="{{ url("courses/lists") }}">公开课</a></li>
                    <li>|</li>
                    <li><a href="{{ url("books/lists") }} ">教材</a></li>
                    <li>|</li>
                    <li><a href="{{ url("books/lists") }}">题库</a></li>
                    <li>|</li>
                    <li><a href="{{ url("books/lists") }}">考讯</a></li>
                    <li>|</li>
                    <li><a href="{{ url("books/lists") }}">师资</a></li>
                    <li>|</li>
                    <li><a onmouseover="ydd()" onmouseout="ydd_out()" class="hand">移动端</a></li>
                </ul>
                <img src="/assets/img/header_pic_smxz.png" id="smxz" alt="扫码下载" class="dn"/>
                <!--  <div id="reg"><a href="{{ url("auth/login") }}">登陆</a><span style="color:#fff;"> &nbsp;|&nbsp; </span><a href="{{ url("auth/register") }}">注册</a></div> -->
                <div id="reg">
                 @if (Auth::guest())
                    <a class="hand" onclick="login()">登录</a><span style="color:#fff;"> &nbsp;|&nbsp; </span><a class="hand" onclick="reg()">注册</a>
                  @else
                    
				    <div id="online"><span> &nbsp;&nbsp; </span><a class="hand" href="{{ url('/my/profile') }}">{{ Auth::user()->name }}</a><span style="color:#fff;"> &nbsp;|&nbsp; </span><a href="{{ url('/ablesky/redirect') }}">学习课程</a><span style="color:#fff;"> &nbsp;|&nbsp; </span><a href="{{ url('order') }}">购物车</a><span style="color:#fff;"> &nbsp;|&nbsp; </span><a class="hand" href="{{ url('auth/logout') }}">退出</a></div>
                @endif
                 </div>
            </div>
        </div>
		<div id="header2"></div>
		<!--头部公共 引用结束-->
	
		<!--登录、注册部分 引用开始-->		
		<div id="register">

				<div class="reg dn">
					<div class="left">
						<form id="register_form" action="{{ url('/auth/ajax_register') }}" method="post"> <input type="hidden" name="_token" id="_token"  value="{{ csrf_token() }}"/> 
								<ul class="ul_one">
										<li><b style="color:red;">*</b><span class="c666">手机号</span></li>
										<li><b style="color:red;">*</b><span class="c666">验证码</span></li>
										<li>&nbsp;</li>										
										<li><b style="color:red;">*</b><span class="c666">用户名</span></li>
										<li><b style="color:red;">*</b><span class="c666">密码</span></li>
										<li><b style="color:red;">*</b><span class="c666">确认密码</span></li>
										<li><b style="color:red;">*</b><span class="c666">邮箱</span></li>
								</ul>
								<ul class="ul_two" id="ul_two">
										<li><input type="text" id="phone" name="phone" placeholder="请输入有效的手机号码" class="input"/><span id="phone_span" class="cff3e3e dn">× 已被注册</span></li>
										<li><input type="text" id="phonecode" name="phonecode" placeholder="请输入手机验证码" class="input"/><span class="cff3e3e dn">× 验证码输入错误</span></li>
										<li><input type="button" onclick="javascript:sendverifycode()" id="telcode" value="免费获取手机验证码"/>
										<li><input type="text" id="name" name="name" placeholder="6-20位(字母、数字、'_'的组合)" class="input"/><span class="cff3e3e dn">× 已被注册</span></li>
										<li><input type="password" id="password" name="password" placeholder="请输入6-20位密码" class="input"/><span class="cff3e3e dn">× 格式错误</span></li>
										<li><input type="password" id="password_confirmation" name="password_confirmation" placeholder="请再次输入密码" class="input"/><span class="cff3e3e dn">× 两次密码不匹配</span></li>
										<li><input type="email" id="email" name="email" placeholder="请填写有效邮箱" class="input"/><span class="cff3e3e dn">× 已被注册</span></li>
								</ul>
								<div class="clear"></div>
								<p><input type="checkbox" name="agree" id="iagree" /><label for="iagree" class="c8c8c8c">&nbsp;我阅读并同意</label><a href="#"><span class="c2693ff">《园师网服务条款》</span></a></p>
								<p><input type="submit" id="register_submit" value="确认注册" class="submit"/> <span id="register_form_hint" class="cff3e3e dn">× 注册失败，请重试</span></p>
								
						</form>
					</div>
					<div class="right">
						<h4>已有园师课堂账号？</h4>
						<a class="hand"><div class="in" id="quicklogin">立即登陆</div></a>
						<a class="hand"><div id="forget1">忘记密码</div></a>
					</div>
					<img src="/assets/img/reg_close_ico.png" id="close1" />
				</div>
				<div class="login dn">
						<div class="banner"></div>
						<div class="message">
								<form id="login_form" action="{{ url("auth/login") }}" method="post"> 
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/> 
								<input type="hidden" class="form-control" name="url" value="{{ Request::url() }}"/>
										<h3>登录学习精彩课程</h3>
										<span id="login_form_hint" class="cff3e3e dn">× 用户名/密码错误</span>
										<p><span class="font_st fs14 c666">账号</span> <input type="text" id="login_phone" placeholder="请输入用户名/手机号" name="phone" alt="请输入用户名/手机号" class="username"/></p>
										<p><span class="font_st fs14 c666">密码</span> <input type="password" id="login_password" placeholder="请输入密码" name="password" alt="请输入密码" class="password"/></p>
										<p class="ml37">
												<input type="checkbox" name="checkbox" class="checkbox"/>
												<span class="font_st fs12 c999">保存密码</span>
												&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="hand"><span class="font_st fs12 c0790fe" id="forget2">忘记密码？</span></a>
										</p>										
										<p class="ml37"><input id="login_submit" type="submit" value="登录" class="submit"/></p>
										<p class="ml37"><a href="#"><span class="font_st fs12 c999">没有园师课堂账号？</span></a>&nbsp;&nbsp;<a class="hand"><span id="quickreg" class="font_st fs12 c0790fe">快速注册</span></a></p>
								</form>
						</div>
						<img src="/assets/img/reg_close_ico.png" id="close2" />
				</div>
				<div class="remember dn">
					<p>忘记密码请拨打 <span class="ccc0202">010-62053248</span><br/>
工作人员会协助您找回密码</p>
					<a class="hand"><div>返回登录</div></a>
					<img src="/assets/img/reg_close_ico.png" id="close3" onclikc="alert(3)" />
				</div>

		
		</div>

		