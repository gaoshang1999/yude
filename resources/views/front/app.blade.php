<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') {{ config('app.title', 'AppTitle') }} @show</title>
    @section('meta_keywords')
    <meta name="keywords" content="your, awesome, keywords, here"/>
    @show @section('meta_author')
    <meta name="author" content="YQ"/>
    @show @section('meta_description')
    <meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei."/>
    @show
    <link href="/assets/css/yude.css" rel="stylesheet">
    <link href="/assets/css/header.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet" type="text/css" /> 

    @yield('styles')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!--头部公共 引用开始-->
@include('front.header')
<!--头部公共 引用结束-->


<div class="container">
@yield('content')
</div>

<!--尾部公共 引用开始-->
@include('front.footer')
<!--尾部公共 引用结束-->
<script src="/assets/js/jquery-2.1.4.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<!-- Scripts -->
<script type="text/javascript" src="/assets/js/footer.js"></script>
<script type="text/javascript" src="/assets/js/login.js"></script>
<script type="text/javascript" src="/assets/js/personal.js"></script>
<script type="text/javascript">

    var login_form = $('#login_form');
    login_form.submit(function (ev) {
    	var phone = $("#login_phone").val();
    	var password = $("#login_password").val();
    	var span = $("#login_form_hint");
        if(phone.length == 0 && password.length ==0){
            span.html("× 请输入用户名和密码");
            span.removeClass("dn");
            ev.preventDefault();
            return ;
        }else if(password.length ==0){
            span.html("× 请输入密码");
            span.removeClass("dn");
            ev.preventDefault();
            return ;
        }else if(phone.length ==0){
            span.html("× 请输入用户名");
            span.removeClass("dn");
            ev.preventDefault();
            return ;
        }    	
        $("#login_submit").val("正在登录...");
        $.ajax({
            type: login_form.attr('method'),
            url: login_form.attr('action'),
            data: login_form.serialize(),
            dataType: "json",
            success: function (data) {
            	$("#login_submit").val("登录");
            	var ret = eval(data);            	
                if(ret['success'] ){
                	location.reload();
                }else{
                    span.html("× 用户名或密码错误");
                    span.removeClass("dn");
                }
            },
            error: function(){
            	$("#login_submit").val("登录");
            	span.removeClass("dn");
            	span.html("后台服务忙，请稍后重试");
            }
        });
    
        ev.preventDefault();
    });


    var fun1 = function(){
    	var span = $(this).parent().find('span'); 
        var value = $(this).val();  

        var reg=/^1\d{10}$/;       
        if(value.length ==0){
        	span.removeClass("dn");
        	span.html("× 请输入手机号");
        	return false;
        }else if (!reg.test(value)) {
        	span.removeClass("dn");
        	span.html("× 手机号格式错误");
        	return false;
        }        

		$.post('auth/phonecheck/'+value, {'_token': '{{ csrf_token() }}'}, function(data, textStatus){
            var ret = eval(data);
            if(ret && ret['success'] ){
                span.addClass("dn");
                return true;
             }else {
            	span.html("× "+ret['message']);
                span.removeClass("dn");
                return false;
             }
        }, 'json');
	};
	
    $('#phone').blur(fun1);

    var fun2 = function(){
    	var span = $(this).parent().find('span');
        var value = $(this).val();  
          
        if(value.length ==0){
        	span.removeClass("dn");
        	span.html("× 请输入用户名");
        	return false;
        }else if (value.length<6 || value.length > 18) {
        	span.removeClass("dn");
        	span.html("×请输入6-18位用户名");
        	return false;
        }
        
		$.post('/ablesky/usercheck/'+value, {'_token': '{{ csrf_token() }}'}, function(data, textStatus){
            var ret = eval(data);
            if(ret && ret['success']){
                span.addClass("dn");
                return true;
             }else {
              	span.html("× "+ret['message']);
                span.removeClass("dn");
                return false;
             }
        }, 'json');
	};
    $('#name').blur(fun2);
    
    var fun3 = function(){
    	var span = $(this).parent().find('span');
        var value = $(this).val();  

        var reg =  new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");   
        if(value.length ==0){
        	span.removeClass("dn");
        	span.html("× 请输入邮箱");
        	return false;
        }else if (!reg.test(value)) {
        	span.removeClass("dn");
        	span.html("× 请填写有效邮箱");
        	return false;
        }
        
		$.post('/ablesky/emailcheck/'+value, {'_token': '{{ csrf_token() }}'}, function(data, textStatus){
            var ret = eval(data);
            if(ret && ret['success']){
                span.addClass("dn");
                return true;
             }else {
             	span.html("× "+ret['message']);
                span.removeClass("dn");
                return false;
             }
        }, 'json');
	};	
    $('#email').blur(fun3);

	var fun4 = function(){
    	var span = $(this).parent().find('span');
        var value = $(this).val();  
          
        if (value.length != 6 ) {
        	span.removeClass("dn");
        	span.html("× 请输入6位验证码");
        	return false;
        }else{
        	span.addClass("dn");
        	return true;
        }    

	};	
    $('#phonecode').blur(fun4);

	var fun5 = function(){
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

        if($('#password_confirmation').val().length > 0) { $('#password_confirmation').blur();}
	};	
    $('#password').blur(fun5);

	var fun6 = function(){
    	var span = $(this).parent().find('span');
        var value = $(this).val();  
          
        if (value !== $('#password').val() ) {
        	span.removeClass("dn");
        	return false;
        }else{
        	span.addClass("dn");
        	return true;
        }       

	};	
    $('#password_confirmation').blur(fun6);

    function timer(elem, seconds, btnContent){
        if(seconds >= 0){
            elem.prop('disabled', true);
            setTimeout(function(){
                //显示倒计时
                elem.val(seconds + ' 秒后再次发送');
                //递归
                seconds -= 1;
                timer(elem, seconds, btnContent);
            }, 1000);
        }else{
            elem.val(btnContent);
            elem.prop('disabled', false);
        }
    }
    
	 function sendverifycode(){
            $('#phone').blur();
		    if(!$('#phone_span').hasClass("dn")){
			    return false;
		    }
		    timer($('#telcode'), 60, $('#telcode').val());
            $.post('/auth/sendverifycode', {_token: '{{ csrf_token() }}', mobile: $('#phone').val()}, function(data, textStatus){
                console.log(data);
//                 alert( data.deadline );
//                 timer($('#telcode'), data.deadline, $('#telcode').val());
            }, 'json');
     }



	var register_form = $('#register_form');
    register_form.submit( function (ev) {
        var validate = true;
        $("#ul_two").find("span").each(function(){
       	     if(!$(this).hasClass("dn")){
       	    	validate = false;
       	     }
        });
    	if(!validate){
            ev.preventDefault();
            return;
        }
//         $('#phone').blur();
//         $('#phonecode').blur();
//         $('#name').blur();
//         $('#password').blur();
//         $('#password_confirmation').blur();
//         $('#email').blur();

//         var validate = true;
//         $("#ul_two").find("span").each(function(){
//        	     if(!$(this).hasClass("dn")){
//        	    	validate = false;
//        	     }
//         });
    	if(!validate){
            ev.preventDefault();
            return;
        }
        
    	$("#register_submit").val("正在注册...");
        $.ajax({
            type: register_form.attr('method'),
            url: register_form.attr('action'),
            data: register_form.serialize(),
            dataType: "json",
            success: function (data) {
            	var ret = eval(data);
            	$("#register_submit").val("确认注册");
            	
                if(ret['success'] ){                	
					$(".reg").addClass("dn");
					$(".login").removeClass("dn");
					$("#background").removeClass("dn");
                }else{
                	$("#register_form_hint").removeClass("dn");
                	$("#register_form_hint").html( ret['message'] );
                }
            },
            error: function(){
            	$("#register_submit").val("确认注册");
            	$("#register_form_hint").removeClass("dn");
            	$("#register_form_hint").html("后台服务忙，请稍后重试");
            }
        });

        ev.preventDefault();
    });


</script>					
@yield('scripts')

</body>
</html>
