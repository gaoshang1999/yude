@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂-教材列表页 @stop

@section('styles') 
<link href="/assets/css/jclby.css" rel="stylesheet" type="text/css" />  
@stop


{{-- Content --}}
@section('content')

        <div id="banner">
            <div class="content"><a href="#"><img src="/assets/img/jclby_djck.jpg" alt="查看视频课程" /></a></div>
        </div>
        <div id="content">
            <div class="jclby_zx">
                <h3></h3>
                <ul>
                    @foreach ($books_1 ->all() as $v)
                    <li>
                    <div><a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }} " width="132" height="205" /></a></div>
                        <p><a href="{{ url("books/$v->id") }}">{{ $v->name }}</a><br><span style="color:#f60;">{{  $v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="{{ url("books/$v->id") }}" style="color:#a1a1a1;">详情</a> <a href="{{  url("cart/books/add/$v->id") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                    
                </ul>
            </div>
            <div class="jclby_xx">
                <h3></h3>
                <ul>
                    @foreach ($books_2 ->all() as $v)
                    <li>
                    <div><a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }} " width="132" height="205" /></a></div>
                        <p><a href="{{ url("books/$v->id") }}">{{ $v->name }}</a><br><span style="color:#f60;">{{$v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="{{ url("books/$v->id") }}" style="color:#a1a1a1;">详情</a> <a href="{{  url("cart/books/add/$v->id") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                </ul>
            </div>
            <div class="jclby_ye">
                <h3></h3>
                <ul>
                    @foreach ($books_3 ->all() as $v)
                    <li>
                    <div><a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }} " width="132" height="205" /></a></div>
                        <p><a href="{{ url("books/$v->id") }}">{{ $v->name }}</a><br><span style="color:#f60;">{{$v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="{{ url("books/$v->id") }}" style="color:#a1a1a1;">详情</a> <a href="{{ url("cart/books/add/$v->id") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>

                   @endforeach
                </ul>
            </div>
        </div>
@endsection
