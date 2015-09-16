@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">编辑首页HTML</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/courses/html_edit' ) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    

    <div class="form-group">
      <label for="rightImage" class="col-sm-2 control-label">权威名师团队</label>
      <div class="col-sm-9">
        <textarea id="rightImage_editor" type="text/plain" name="rightImage" style="width:650px;height:400px;">{{ old("rightImage", $rightImage ) }}</textarea>
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

