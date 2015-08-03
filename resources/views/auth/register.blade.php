@extends('app')

{{-- Web site Title --}}
@section('title') 注册 :: @parent @stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="page-header">
            <h2>注册</h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            @include('errors.list')

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">手机号</label>

                    <div class="col-md-4">
                        <input type="phone" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-1">
                        <input type="button" class="btn btn-primary" id="btnSendCode" value="发送验证码">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">验证码</label>

                    <div class="col-md-4">
                        <input type="text" class="form-control" name="phonecode" value="">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label">用户名</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">邮箱</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">密码</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">确认密码</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            提交
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function(){
        $('#btnSendCode').click(function(){
            $.post('/auth/sendverifycode', {_token: '{{ csrf_token() }}', mobile: $('#phone').val()}, function(data, textStatus){
                console.log(data);
                timer($('#btnSendCode'), data.deadline, $('#btnSendCode').val());
            }, 'json');
        });

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
    });
</script>
@endsection
