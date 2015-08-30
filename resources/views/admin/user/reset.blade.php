@extends('admin/admin')

@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
                    <h2 class="page-header">重置密码</h2>
                    <div class="panel-body">

                        @include('errors.list')

                        <form class="form-horizontal" role="form" method="POST" action=" {{ url("/admin/user/reset/{$user ->id}") }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                  <label for="username" class="col-sm-2 control-label">用户名</label>
                                  <div class="col-sm-9">
                                    <input type="input" class="form-control" name="username" placeholder="用户名" value="{{ old('username', $user ? $user->name : '') }}" disabled>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="userphone" class="col-sm-2 control-label">手机号</label>
                                  <div class="col-sm-9">
                                    <input type="phone" class="form-control" name="userphone" placeholder="手机号" value="{{ old('userphone', $user ? $user->phone : '') }}" disabled>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="useremail" class="col-sm-2 control-label">邮箱</label>
                                  <div class="col-sm-9">
                                    <input type="email" class="form-control" name="useremail" placeholder="邮箱" value="{{ old('useremail', $user ? $user->email : '') }}" disabled>
                                  </div>
                                </div>

                              <div class="form-group">
                                  <label for="password" class="col-sm-2 control-label">新密码</label>
                                  <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password">
                                  </div>
                                </div>
                                
                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">重置</button> <button type="button" class="btn btn-primary" onclick="javascript :history.back(-1)">返回</button>
                              </div>
                            </div>

                            <input type="hidden"  name="referer" value="{{ Request::header("referer") }}" />
                        </form>
                    </div>
  
    </div>
@endsection
