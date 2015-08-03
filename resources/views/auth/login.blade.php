@extends('app')

{{-- Web site Title --}}
@section('title') 登录 :: @parent @stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="page-header">
            <h2>登录</h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            @include('errors.list')

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">手机号</label>

                    <div class="col-md-6">
                        <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">密码</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                            登录
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
