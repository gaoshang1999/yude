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
    <link href="/assets/css/header.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet" type="text/css" /> 
    <link href="/assets/css/yude.css" rel="stylesheet">
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
<script type="text/javascript">
    var fun = function(){
    	var span = $(this).parent().find('span');
        var value = $(this).val();  
        var key = ($(this).prop('id'));
        var array = {'_token': '{{ csrf_token() }}', key: key, value: value};

		$.post('/auth/validate', array, function(data, textStatus){
            console.log(data);
            //timer($('#btnSendCode'), data.deadline, $('#btnSendCode').val());
            var ret = eval(data);

            if(!ret['success'] ){
                span.removeClass("dn");
             }
        }, 'json');
	};
    $('#phone').blur(fun);
    $('#name').blur(fun);
    $('#email').blur(fun);

	 function sendverifycode(){
            $.post('/auth/sendverifycode', {_token: '{{ csrf_token() }}', mobile: $('#phone').val()}, function(data, textStatus){
                console.log(data);
                //timer($('#btnSendCode'), data.deadline, $('#btnSendCode').val());
            }, 'json');
     }

	var frm = $('#register_form');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
            	var ret = eval(data);
            	
                if(ret['success'] ){
                	alert('注册成功');
                }else{
                    alert(ret);
                }
            }
        });

        ev.preventDefault();
    });

//     $('#iagree').click(function () {
//     	var value = $(this).val();  
//     	var btn = $('#register_submit'); 
//     	if(value){
//     		btn.disabled = false;
//     	}else{    	
//     		btn.prop('disabled', false);
//     	}
//     });
</script>					
@yield('scripts')

</body>
</html>
