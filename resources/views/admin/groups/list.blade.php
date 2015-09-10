@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  
  <h2 class="sub-header">课程组列表 
   <a class="btn btn-primary pull-right" href="{{ url('/admin/groups/add') }}" tabindex="4">创建新课程组</a>
   
   <form class="search_form pull-right form-inline" role="form" method="get" action="{{ url('/admin/groups/search') }}" >    
    <button class="btn btn-primary pull-right" type="submit" tabindex="3">搜索</button>
    <input class="form-control pull-right" type="text" placeholder="" name ="q" value="{{ isset($q) ? $q : "" }}" tabindex="2"/>  
    <select class="form-control pull-right" id="field" name="field" tabindex="1"> <?php $field = isset($field) ? $field : ""; ?>
      <option value="name" {{ $field==='name' ? 'selected' : '' }}>课程组名称</option>
      <option value="rank" {{ $field==='rank' ? 'selected' : '' }}>显示顺序</option>
      <option value="zx_course" {{ $field==='zx_course' ? 'selected' : '' }}>中学课程</option>
      <option value="xx_course" {{ $field==='xx_course' ? 'selected' : '' }}>小学课程</option>
      <option value="yr_course" {{ $field==='yr_course' ? 'selected' : '' }}>幼儿课程</option>
    </select>
    
  </form>
 </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>课程组名称</th>
          <th>显示顺序</th>
          <th>中学课程</th>
          <th>小学课程</th>
          <th>幼儿课程</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($groups->all() as $v)
        <tr>
          <td>{{ $v->id }}</td>
          <td><a href="{{ url("/admin/groups/edit/{$v->id}") }}">{{ $v->name }}</a></td>
          <td>{{ $v->rank }}</td>          
          <td>{{ $v->zx ->name }}</td>          
          <td>{{ $v->xx ->name }}</td>
          <td>{{ $v->yr ->name }}</td>
          <td>{{ $v->created_at }}</td>
          <td>{{ $v->updated_at }}</td>
          <td><form action="{{ url("/admin/groups/delete/{$v->id}") }}" method="post"> <input type="hidden" name="_token" value="{{ csrf_token() }}" ><button type="submit" onclick="return del();" class="btn btn-primary" >删除</button> </form>  </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>{!! $groups->render() !!}</div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
function del() {  
    if(window.confirm('你确定要删除该记录吗？')){
        //alert("确定");
        return true;
     }else{
        //alert("取消");
        return false;
    }
 }//del end

</script>
@endsection