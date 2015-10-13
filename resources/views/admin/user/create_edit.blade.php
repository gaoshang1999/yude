@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $user ? '编辑' : '创建新' }}用户</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/user/' . ($user ? 'edit/'.$user->id : 'add')) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="username" class="col-sm-2 control-label"><span style="color: red">*</span>用户名</label>
      <div class="col-sm-9">
        <input type="input" class="form-control" name="username" placeholder="用户名" value="{{ old('username', $user ? $user->name : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="userphone" class="col-sm-2 control-label"><span style="color: red">*</span>手机号</label>
      <div class="col-sm-9">
        <input type="phone" class="form-control" name="userphone" placeholder="手机号" value="{{ old('userphone', $user ? $user->phone : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="useremail" class="col-sm-2 control-label"><span style="color: red">*</span>邮箱</label>
      <div class="col-sm-9">
        <input type="email" class="form-control" name="useremail" placeholder="邮箱" value="{{ old('useremail', $user ? $user->email : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="userrole" class="col-sm-2 control-label"><span style="color: red">*</span>权限</label>
      <div class="col-sm-9"><?php $role = old('role', $user ? $user->role : 'user'); ?>
        <select class="form-control" id="userrole" name="userrole">
          <option value="user" {{ $role==='user' ? 'selected' : '' }}>学员</option>
          <option value="kefu" {{ $role==='kefu' ? 'selected' : '' }}>客服</option>
          <option value="admin" {{ $role==='admin' ? 'selected' : '' }}>管理员</option>
        </select>
      </div>
    </div>
    @if (!$user)
    <div class="form-group">
        <label class="col-sm-2 control-label">密码</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">确认密码</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>
    @endif
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">保存</button> <button type="button" class="btn btn-primary" onclick="javascript :history.back(-1)">返回</button>
      </div>
    </div>
    <input type="hidden"  name="referer" value="{{ Request::header('referer') }}" />
  </form>
</div>
@endsection