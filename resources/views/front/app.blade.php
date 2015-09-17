<!DOCTYPE html>
<html>
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

<script src="/assets/js/jquery.js"></script>

<!-- Scripts -->
<script type="text/javascript" src="/assets/js/footer.js"></script>
<script type="text/javascript" src="/assets/js/login.js"></script>
<script type="text/javascript" src="/assets/js/personal.js"></script>
<script type="text/javascript">
</script>					
@yield('scripts')

</body>
</html>
