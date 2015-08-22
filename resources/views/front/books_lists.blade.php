<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>园师课堂-教材列表页</title>
        <link href="/assets/css/header.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/jclby.css" rel="stylesheet" type="text/css" /> 
		<script src="/assets/js/jquery-2.1.4.min.js"></script>
    </head>
            
    <body>
        <!--头部公共 引用开始-->
         @include('front.header')
        <!--头部公共 引用结束-->

        <div id="banner">
            <div class="content"><a href="#"><img src="/assets/img/jclby_djck.jpg" alt="查看视频课程" /></a></div>
        </div>
        <div id="content">
            <div class="jclby_zx">
                <h3></h3>
                <ul>
                    @foreach ($books_1 ->all() as $v)
                    <li>
                    <div><img src="{{ url("$v->cover") }} " width="132" height="205" /></div>
                        <p>{{ $v->name }}<br><span style="color:#f60;">{{  $v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="#" style="color:#a1a1a1;">详情</a> <a href="{{ url("order") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                    
                </ul>
            </div>
            <div class="jclby_xx">
                <h3></h3>
                <ul>
                    @foreach ($books_2 ->all() as $v)
                    <li>
                    <div><img src="{{ url("$v->cover") }} " width="132" height="205" /></div>
                        <p>{{ $v->name }}<br><span style="color:#f60;">{{$v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="#" style="color:#a1a1a1;">详情</a> <a href="{{ url("order") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                </ul>
            </div>
            <div class="jclby_ye">
                <h3></h3>
                <ul>
                    @foreach ($books_3 ->all() as $v)
                    <li>
                    <div><img src="{{ url("$v->cover") }} " width="132" height="205" /></div>
                        <p>{{ $v->name }}<br><span style="color:#f60;">{{$v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="#" style="color:#a1a1a1;">详情</a> <a href="{{ url("order") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                </ul>
            </div>
        </div>
        <!--尾部公共 引用开始-->
        @include('front.footer')
        <!--尾部公共 引用结束-->
    </body>

</html>
