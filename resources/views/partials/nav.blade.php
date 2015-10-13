<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('index') }}">{{ config('app.title', 'AppTitle') }}</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if(Auth::check())
                @if(Auth::user()->isAdmin())
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/admin/user') }}">用户管理</a></li>
                    <li><a href="{{ url('/admin/courses') }}">课程管理</a></li>
                    <li><a href="{{ url('/admin/groups') }}">课程组管理</a></li>
                    <li><a href="{{ url('/admin/books') }}">教材管理</a></li>
                    <li><a href="{{ url('/admin/orders') }}">订单管理</a></li>
                    <li><a href="{{ url('/admin/images') }}">图片管理</a></li>
                </ul>
               @elseif(Auth::user()->iskefu())
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/admin/orders') }}">订单管理</a></li>
                </ul>
                @endif
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li class="{{ (Request::is('auth/login') ? 'active' : '') }}">
                        <a href="{{ url('auth/login') }}"><i class="fa fa-sign-in"></i> 登录</a>
                    </li>
                    <li class="{{ (Request::is('auth/register') ? 'active' : '') }}">
                        <a href="{{ url('auth/register') }}">注册</a>
                    </li>
                @else
                    <li class="{{ (Request::is('password/email') ? 'active' : '') }}">
                        <a href="{{ url('/my/profile') }}"><i class="fa fa-sign-in"></i> {{ Auth::user()->name }}</a>
                    </li>
                    <li><a href="{{ url('auth/logout') }}">退出</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>