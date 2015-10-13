@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <h2 class="sub-header">用户列表
   <a class="btn btn-primary pull-right" href="{{ url('/admin/user/add') }}" tabindex="4">创建新用户</a>
     
   <form class="search_form pull-right form-inline" role="form" method="get" action="{{ url('/admin/user/search') }}" >    
    <button class="btn btn-primary pull-right" type="submit" tabindex="3">搜索</button>
    <input class="form-control pull-right" type="text" placeholder="" name ="q" value="{{ isset($q) ? $q : "" }}" tabindex="2"/>  
    <select class="form-control pull-right" id="field" name="field" tabindex="1"> <?php $field = isset($field) ? $field : ""; ?>
      <option value="name" {{ $field==='name' ? 'selected' : '' }}>用户名</option>
      <option value="phone" {{ $field==='phone' ? 'selected' : '' }}>手机号</option>
      <option value="email" {{ $field==='email' ? 'selected' : '' }}>邮箱</option>
    </select>  
  </form>
  </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>姓名</th>
          <th>手机号</th>
          <th>邮箱</th>
          <th>类型</th>
          <th>是否在ablesky注册</th>
          <th>创建时间</th>
          <th>重置密码</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users->all() as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td><a href="{{ url("/admin/user/edit/{$user->id}") }}">{{ $user->name }}</a></td>
          <td>{{ $user->phone }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->roleDesc() }}</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->is_reged ? '是': '否' }}</td>
          <td>{{ $user->created_at }}</td>
          <td><a class="btn btn-primary" href="{{ url("/admin/user/reset/{$user->id}") }}">重置密码</a></td>
          <td><form action="{{ url("/admin/user/delete/{$user->id}") }}" method="post"> <input type="hidden" name="_token" value="{{ csrf_token() }}" ><button type="submit" onclick="return del();" class="btn btn-primary" >删除</button> </form>  </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{!! $users->render() !!}</div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
function del() {  
    if(window.confirm('你确定要删除该记录！')){
        //alert("确定");
        return true;
     }else{
        //alert("取消");
        return false;
    }
 }//del end

</script>
@endsection