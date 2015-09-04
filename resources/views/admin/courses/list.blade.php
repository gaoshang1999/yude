@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <h2 class="sub-header">课程列表
   <a class="btn btn-primary pull-right" href="{{ url('/admin/courses/add') }}" tabindex="4">创建新课程</a> 
     
   <form class="search_form pull-right form-inline" role="form" method="get" action="{{ url('/admin/courses/search') }}" >    
    <button class="btn btn-primary pull-right" type="submit" tabindex="3">搜索</button>
    <input class="form-control pull-right" type="text" placeholder="" name ="q" value="{{ isset($q) ? $q : "" }}" tabindex="2"/>  
    <select class="form-control pull-right" id="field" name="field" tabindex="1"> <?php $field = isset($field) ? $field : ""; ?>
      <option value="name" {{ $field==='name' ? 'selected' : '' }}>名称</option>
      <option value="id" {{ $field==='id' ? 'selected' : '' }}>ID编号</option>
      <option value="level" {{ $field==='level' ? 'selected' : '' }}>级别</option>
      <option value="kind" {{ $field==='kind' ? 'selected' : '' }}>类别</option>
      <option value="enable" {{ $field==='enable' ? 'selected' : '' }}>状态</option>
    </select>  
     <a class="btn btn-primary pull-right" href="javascript:updateCategory()" style="margin-right: 5px;">更新Ablesky课程目录</a>
     <a class="btn btn-primary pull-right" href="javascript:openCategoryWindow()" style="margin-right: 5px;">查看Ablesky课程目录</a>
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
          <th>折扣价</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>状态</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($courses->all() as $v)
        <tr>
          <td>{{ $v->id }}</td>
          <td><a href="{{ url("/admin/courses/edit/{$v->id}") }}">{{ $v->name }}</a></td>
          <td>@if($v->level == "zhongxue") 中学  @elseif($v->level == "xiaoxue") 小学 @elseif($v->level == "youer") 幼儿  @endif</td>
          <td>@if($v->kind == "bishi") 笔试  @elseif($v->kind == "mianshi") 面试  @endif</td>
          <td>{{ $v->totalprice }}</td>
          <td>{{ $v->discount_price }}</td>
          <td>{{ $v->created_at }}</td>
          <td>{{ $v->updated_at }}</td>
          <td>{{ $v->enable ? '上架' : '下架' }}</td>
          <td><form action="{{ url("/admin/courses/delete/{$v->id}") }}" method="post"> <input type="hidden" name="_token" value="{{ csrf_token() }}" ><button type="submit" onclick="return del();" class="btn btn-primary" >删除</button> </form>  </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{!! $courses->render() !!}</div>
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

 function openCategoryWindow(){
	  window.open("{{ url('/ablesky/category/tree') }}","_blank", 'height=800, width=400, top=100, left=800, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
 }
 function updateCategory(){
        var array = {'_token': '{{ csrf_token() }}'};

		$.post('/ablesky/category/update', array, function(data, textStatus){
         var ret = eval(data);
         if(ret['success']){
             alert("Ablesky课程目录更新成功");
             return true;
          }else {
        	 alert("Ablesky课程目录更新失败，请重试");
             return false;
          }
     }, 'json');
 }
</script>
@endsection