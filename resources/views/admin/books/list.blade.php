@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  
  <h2 class="sub-header">教材列表 
   <a class="btn btn-primary pull-right" href="{{ url('/admin/books/add') }}">创建新教材</a>
   
   <form class="search_form pull-right" role="form" method="get" action="{{ url('/admin/books/search') }}" >    
    <button class="btn btn-primary pull-right" type="submit">搜索</button>
    <input class="pull-right" type="text" placeholder="教材名称" name ="q" value="{{ isset($q) ? $q : "" }}"/>    
  </form>
 </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>教材名称</th>
          <th>级别</th>
          <th>类别</th>
          <th>定价</th>
          <th>折扣</th>
          <th>折扣价</th>
          <th>库存</th>
          <th>已售数量</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($books->all() as $v)
        <tr>
          <td>{{ $v->id }}</td>
          <td><a href="{{ url("/admin/books/edit/{$v->id}") }}">{{ $v->name }}</a></td>
          <td>@if($v->level == "zhongxue") 中学  @elseif($v->level == "xiaoxue") 小学 @elseif($v->level == "youer") 幼儿  @endif</td>
          <td>@if($v->kind == "bishi") 笔试  @elseif($v->kind == "mianshi") 面试  @endif</td>
          <td>{{ $v->price }}</td>          
          <td>{{ $v->discount }}</td>          
          <td>{{ $v->discount_price }}</td>
          <td>{{ $v->inventory }}</td>
          <td>{{ $v->buytimes }}</td>
          <td>{{ $v->created_at }}</td>
          <td>{{ $v->updated_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{!! $books->render() !!}</div>
  </div>
</div>
@endsection