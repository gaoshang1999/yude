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
							<a href="{{ url('order') }}"><li><span class="s1"></span>购物车</li></a>
							<a href="#"><li><span class="s2"></span>学习课程</li></a>
							<a href="{{ url("courses/lists") }}"><li><span class="s3"></span>课程购买</li></a>
							<a href="{{ url("books/lists") }}"><li><span class="s4"></span>教材购买</li></a>
							<a href="#"><li><span class="s5"></span>在线咨询</li></a>
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
					<!--我的订单  有订单--> <?php $count = count($orders->all()); ?>
					<div class="order @if($count==0) dn @endif"> 
							<table>
						@foreach ($orders->all() as $k=>$v)   <?php $rows = count($v->orderItems); ?>
									<tr class="tr_o_h">
											<td class="wddd">{{ $v->created_at }}</td>
											<td class="ddxq border_r">订单编号：{{ $v->orderno }}</td>
											<td class="je border_r">&nbsp;</td>
											<td class="ddzt border_r">&nbsp;</td>
											<td class="cz">&nbsp;</td>
									</tr>
									<tr class="tr_c_h"> <?php $p = json_decode($v->orderItems[0]->snapshot); ?>
											<td><div><img src="{{ $p -> cover }}" width="138" height="80"/></div></td>
											<td class="border_r">
													<p>
															{{ $p->name }}<br/>
@if($v->orderItems[0]->type=='course')															
{{ $p->summary }}<br/>
课程总课时：{{ $p->hours }}课时
@elseif($v->orderItems[0]->type=='book')	
出版社：{{ $p->press }}<br/>
购买数量：{{ $p->buytimes }}    
@endif
													</p>
											</td>
											<td rowspan="{{ $rows }}" class="border_r">
																								<span>
															<b>￥{{ number_format($v->totalprice, 2) }}</b><br/>
支付宝支付
													</span>
											</td>
											<td rowspan="{{ $rows }}" class="border_r"><a>{{ $v->paytime ? '已支付' : '待付款' }}</a></td>
											<td rowspan="{{ $rows }}">
											<span> @if($v->paytime) 如需修改订单信息或收件人信息<br/>请拨打4000-607-107 @else  <a href="{{ url("order/payonline/$v->orderno") }}">去付款</a> @endif</span>
											</td>
									</tr> 
@for($i=1; $i<$rows; $i++)   <?php $p = json_decode($v->orderItems[$i]->snapshot); ?>
                                     <tr class="tr_c_h"> 
                                        <td><div><img src="{{ $p -> cover }}" width="138" height="80"/></div></td>
                                        <td class="border_r">
                                         <p>
                                              {{ $p->name }}<br/>
@if($v->orderItems[$i]->type=='course')															
{{ $p->summary }}<br/>
课程总课时：{{ $p->hours }}课时
@elseif($v->orderItems[$i]->type=='book')	
出版社：{{ $p->press }}<br/>
购买数量：{{ $p->buytimes }}    
@endif
                                           </p>
                                           </td>
                                            <td>&nbsp;</td>                                                                                        
                                                                                        
                                      </tr>        
                                      @endfor
					   @endforeach								

						
								
							</table>
					</div>
					<!--我的订单  无订单-->
					<div class="no_order @if($count>0) dn @endif" style="height:340px;">
						<p>你还没有任何订单，赶紧去看看吧O(∩_∩)O~</p>
						<div><a href="{{ url("courses/lists") }}" class="bgr mr22">查看课程</a><a href="{{ url("books/lists") }}" class="bgb">查看教材</a></div>
					</div>
			</div>
	</div>
	<div id="personal_xgmm" class="dn" >
			<form action="{{ url("auth/reset") }}" method="post" id="reset_form"> <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<h2>登录密码修改</h2>
					<label>已绑定手机号：{{ substr(Auth::user()->phone, 0, 3) }}****{{ substr(Auth::user()->phone, 7) }}</label><br/> <input type="hidden" id="hidden_phone"  name="phone" value="{{ Auth::user()->phone }}" />
					<div  id="input_element">
					<p>验证码<input type="text" name="phonecode" id="phonecode_reset" class="ml10" placeholder="请填写手机验证码" /><input type="button" onclick="javascript:sendverifycode2()" id="get_code" value="免费获取手机验证码"/><br/>
					<span class="dn">验证码错误</span></p>
					<p>填写新密码<input type="password" name="password" id="password_reset"  class="ml10"/><br/>
					<span class="dn">密码格式错误</span></p>
					<p>确认新密码<input type="password" name="password_confirmation" id="password_confirmation_reset" class="ml10" /><br/>
					<span class="dn">两次密码输入不一致</span></p>
					</div>
					<input type="submit" id="reset_submit"  value="确认修改" class="submit"/><span id="reset_form_hint" class="cff3e3e dn">× 注册失败，请重试</span>
			</form>
	<img src="/assets/img/reg_close_ico.png" id="xgmm_close" />		
	</div>
	
</div>



<div class="clear h20"></div>

@endsection

@section('scripts')

	<script type="text/javascript" src="/assets/js/personal.js"></script>
	<script type="text/javascript" >    

		function timer2(elem, seconds, btnContent){
        if(seconds >= 0){
            elem.prop('disabled', true);
            setTimeout(function(){
                //显示倒计时
                elem.val(seconds + ' 秒后再次发送');
                //递归
                seconds -= 1;
                timer2(elem, seconds, btnContent);
            }, 1000);
        }else{
            elem.html(btnContent);
            elem.prop('disabled', false);
        }
    }
    
	 function sendverifycode2(){            
		    timer2($('#get_code'), 60, $('#get_code').html());
            $.post('/auth/sendverifycode', {_token: '{{ csrf_token() }}', mobile: $('#hidden_phone').val()}, function(data, textStatus){
                console.log(data);
            }, 'json');
     }

	 var fun11 = function(){
	    	var span = $(this).parent().find('span');
	        var value = $(this).val();  
	          
	        if (value.length < 6 || value.length > 20) {
	        	span.removeClass("dn");
	        	span.html("× 请输入6-20位密码");
	        	return false;
	        }else{
	        	span.addClass("dn");
	        	return true;
	        }       

	        if($('#password_confirmation_reset').val().length > 0) { $('#password_confirmation_reset').blur();}
		};	

		var fun12 = function(){
	    	var span = $(this).parent().find('span');
	        var value = $(this).val();  
	          
	        if (value !== $('#password_reset').val() ) {
	        	span.removeClass("dn");
	        	return false;
	        }else{
	        	span.addClass("dn");
	        	return true;
	        }       

		};	
	    $('#phonecode_reset').blur(fun4);
	    $('#password_reset').blur(fun11);
	    $('#password_confirmation_reset').blur(fun12);

		var register_form = $('#reset_form');
	    register_form.submit( function (ev) {
	        var validate = true;
	        $('#input_element').find("span").each(function(){
	       	     if(!$(this).hasClass("dn")){
	       	    	validate = false;
	       	     }
	        });
	    	if(!validate){
	            ev.preventDefault();
	            return;
	        }
	        
	    	$("#reset_submit").val("正在重置...");
	        $.ajax({
	            type: register_form.attr('method'),
	            url: register_form.attr('action'),
	            data: register_form.serialize(),
	            dataType: "json",
	            success: function (data) {
	            	var ret = eval(data);
	            	$("#reset_submit").val("确认修改");
	            	
	                if(ret['success'] ){                	
						$("#personal_xgmm").addClass("dn");
						$("#background").addClass("dn");
	                }else{
	                	$("#reset_form_hint").removeClass("dn");
	                	$("#reset_form_hint").html( ret['message'] );
	                }
	            },
	            error: function(){
	            	$("#reset_submit").val("确认修改");
	            	$("#reset_form_hint").removeClass("dn");
	            	$("#reset_form_hint").html("后台服务忙，请稍后重试");
	            }
	        });

	        ev.preventDefault();
	    });
	</script>	
@endsection
