@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">编辑首页HTML</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/home/edit' ) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    

    <div class="form-group">
      <label for="open" class="col-sm-2 control-label">公开课</label>
      <div class="col-sm-9">
        <textarea id="open_editor" type="text/plain" name="open" style="width:650px;height:400px;">{{ old("open", $open ) }}</textarea>
      </div>
    </div>
        <div class="form-group">
      <label for="live" class="col-sm-2 control-label">直播课</label>
      <div class="col-sm-9">
        <textarea id="live_editor" type="text/plain" name="live" style="width:650px;height:400px;">{{ old("live", $live ) }}</textarea>
      </div>
    </div>
        <div class="form-group">
      <label for="forecast" class="col-sm-2 control-label">直播预告</label>
      <div class="col-sm-9">
        <textarea id="forecast_editor" type="text/plain" name="forecast" style="width:650px;height:400px;">{{ old("forecast", $forecast ) }}</textarea>
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

@section('scripts')

    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8">
        window.UEDITOR_HOME_URL = location.protocol + '//'+ document.domain + (location.port ? (":" + location.port):"") + "/ueditor/";

        var ue = UE.getEditor('open_editor');
        var ue = UE.getEditor('live_editor');
        var ue = UE.getEditor('forecast_editor');
        var ue = UE.getEditor('teacher_editor');
    </script>
@endsection