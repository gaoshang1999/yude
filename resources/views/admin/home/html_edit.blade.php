@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">编辑首页HTML</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/home/edit' ) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    

    <div class="form-group">
      <label for="open" class="col-sm-2 control-label">免费畅学课程</label>
      <div class="col-sm-9">
        <textarea id="free_editor" type="text/plain" name="free" style="width:650px;height:400px;">{{ old("free", $free ) }}</textarea>
      </div>
    </div>
      
    
    <div class="form-group">
      <label for="hours_description_editor" class="col-sm-2 control-label">权威名师团队</label>
      <div class="col-sm-9">
        <textarea id="teacher_editor" type="text/plain" name="teacher" style="width:650px;height:400px;">{{ old("teacher", $teacher ) }}</textarea>
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

