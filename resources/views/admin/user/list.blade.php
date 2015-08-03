@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <h2 class="sub-header">用户列表<a class="btn btn-primary pull-right" href="{{ url('/admin/user/add') }}">创建新用户</a></h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>姓名</th>
          <th>手机号</th>
          <th>邮箱</th>
          <th>类型</th>
          <th>创建时间</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users->all() as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td><a href="{{ url("/admin/user/edit/{$user->id}") }}">{{ $user->name }}</a></td>
          <td>{{ $user->phone }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role === 'admin' ? '管理员' : '学员' }}</td>
          <td>{{ $user->created_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{{{ $users->render() }}}</div>
  </div>
</div>
@endsection