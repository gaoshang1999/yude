@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <h2 class="sub-header">课程列表
   <a class="btn btn-primary pull-right" href="{{ url('/admin/courses/add') }}">创建新课程</a> 
     
   <form class="search_form pull-right" role="form" method="get" action="{{ url('/admin/courses/search') }}" >    
    <button class="btn btn-primary pull-right" type="submit">搜索</button>
    <input class="pull-right" type="text" placeholder="课程名称" name ="q" value="{{ isset($q) ? $q : "" }}"/>    
  </form>
  </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>课程名称</th>
          <th>级别</th>
          <th>类别</th>
          <th>总价格</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>状态</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($courses->all() as $v)
        <tr>
          <td>{{ $v->id }}</td>
          <td><a href="{{ url("/admin/courses/edit/{$v->id}") }}">{{ $v->name }}</a></td>
          <td>{{ $v->level }}</td>
          <td>{{ $v->kind }}</td>
          <td>{{ $v->totalprice }}</td>
          <td>{{ $v->created_at }}</td>
          <td>{{ $v->updated_at }}</td>
          <td>{{ $v->enable ? '上架' : '下架' }}<br/><a href="/order/step1?cid={{ $v->id }}">购买该课程</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{!! $courses->render() !!}</div>
  </div>
</div>
@endsection