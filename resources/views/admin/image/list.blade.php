@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  
  <h2 class="sub-header">图片列表
   <a class="btn btn-primary pull-right" href="{{ url('/admin/images/upload') }}" tabindex="4">上传新图片</a>   
   
 </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>

          <th>图片</th>
          <th>名称</th>
          <th>路径</th>
          <th>创建时间</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($files  as $v)
        <tr>
          <td><a href="{{url('upload/'.$v->name) }}" target="_blank"><img src="/upload/{{$v->name }}"  width="200px" height="100px"/></a></td>
          <td> {{$v->name }} </td>
          <td> <a href="{{url('upload/'.$v->name) }}"  target="_blank"> /upload/{{$v->name }} </a></td>          
          <td> {{$v->ctime }}</td>          
   
          <td>
            <form action="{{ url('/admin/images/remove') }}" method="post"> 
              <input type="hidden" name="_token" value="{{ csrf_token() }}" >
              <input type="hidden" name="file" value="{{$v->name }}" >
              <button type="submit" onclick="return del();" class="btn btn-primary" >删除</button> 
            </form>  
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div></div>
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