@extends('admin/admin')

@section('styles')
<style type="text/css">

  .tab-content { max-height: 400px; max-width: 600px; overflow: scroll; }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">上传图片</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/images/upload') }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   
    
    
    <div class="form-group">
      <label for="image" class="col-sm-2 control-label"><span style="color: red">*</span>图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="image" placeholder="图片">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">保存</button> <button type="button" class="btn btn-primary" onclick="javascript :history.back(-1)">返回</button>
      </div>
    </div>

    <input type="hidden"  name="referer" value="{{ Request::header('referer') }}" />
  </form>
  
 
  
  
</div>
@endsection

          
