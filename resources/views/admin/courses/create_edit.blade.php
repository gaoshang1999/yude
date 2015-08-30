@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $courses ? '编辑' : '创建新' }}课程</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/courses/' . ($courses ? 'edit/'.$courses->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="ablesky_category" class="col-sm-2 control-label"><span style="color: red">*</span>Ablesky目录课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="ablesky_category" placeholder="Ablesky目录课程选择" value="{{ old('ablesky_category', $courses ? $courses->ablesky_category : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="level" class="col-sm-2 control-label"><span style="color: red">*</span>级别</label>
      <div class="col-sm-9"><?php $level = old('level', $courses ? $courses->level : 'zhongxue'); ?>
        <select class="form-control" id="level" name="level">
          <option value="zhongxue" {{ $level==='zhongxue' ? 'selected' : '' }}>中学</option>
          <option value="xiaoxue" {{ $level==='xiaoxue' ? 'selected' : '' }}>小学</option>
          <option value="youer" {{ $level==='youer' ? 'selected' : '' }}>幼儿</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="kind" class="col-sm-2 control-label"><span style="color: red">*</span>类别</label>
      <div class="col-sm-9"><?php $kind = old('kind', $courses ? $courses->kind : 'bishi'); ?>
        <select class="form-control" id="kind" name="kind">
          <option value="bishi" {{ $kind==='bishi' ? 'selected' : '' }}>笔试</option>
          <option value="mianshi" {{ $kind==='mianshi' ? 'selected' : '' }}>面试</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label"><span style="color: red">*</span>名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="课程名称" value="{{ old('name', $courses ? $courses->name : '') }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="enable" class="col-sm-2 control-label"><span style="color: red">*</span>状态</label>
      <div class="col-sm-9"><?php $enable = old('enable', $courses ? $courses->enable : true); ?>
        <label class="radio-inline"><input type="radio" name="enable" value="1" {{ $enable ? 'checked' : '' }}> 上架</label>
        <label class="radio-inline"><input type="radio" name="enable" value="0" {{ $enable ? '' : 'checked' }}> 下架</label>
      </div>
    </div>
    <div class="form-group">
      <label for="buytimes" class="col-sm-2 control-label"><span style="color: red">*</span>购买次数</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="buytimes" placeholder="购买次数" min="0" value="{{ old('buytimes', $courses ? $courses->buytimes : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="hours" class="col-sm-2 control-label"><span style="color: red">*</span>课时</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="hours" placeholder="课时" min="0" value="{{ old('hours', $courses ? $courses->hours : 0) }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="totalprice" class="col-sm-2 control-label"><span style="color: red">*</span>总价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="totalprice" placeholder="总价格" min="0" step="0.01" value="{{ old('totalprice', $courses ? $courses->totalprice : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="discount_price" class="col-sm-2 control-label"><span style="color: red">*</span>优惠价</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="discount_price" placeholder="优惠价" min="0" step="0.01" value="{{ old('discount_price', $courses ? $courses->discount_price : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="subprice" class="col-sm-2 control-label"><span style="color: red">*</span>子科价格</label>
      <div class="col-sm-3">
        <input type="hidden" name="subname" id="subname">
        <label class="control-label" id="subnamelabel">教育知识与能力</label>
      </div>
      <div class="col-sm-6">
        <input type="number" class="form-control" name="subprice" placeholder="子科价格" min="0" step="0.01" value="{{ old('subprice', $courses ? $courses->subprice : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="zongheprice" class="col-sm-2 control-label"><span style="color: red">*</span>综合素质价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="zongheprice" placeholder="综合素质价格" min="0" step="0.01" value="{{ old('zongheprice', $courses ? $courses->zongheprice : 0) }}">
      </div>
    </div>
    <div class="form-group" id="nengli">
      <label for="nengliprice" class="col-sm-2 control-label"><span style="color: red">*</span>学科知识与能力价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="nengliprice" placeholder="学科知识与能力价格" min="0" step="0.01" value="{{ old('nengliprice', $courses ? $courses->nengliprice : 0) }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="cover" class="col-sm-2 control-label"><span style="color: red">*</span>课程封面图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover" placeholder="课程封面图片">
        @if($courses)<img src="{{ $courses->cover }}" style="max-width:100%; max-height:100px;">@endif 
      </div>
    </div>
    <div class="form-group">
      <label for="image" class="col-sm-2 control-label"><span style="color: red">*</span>课程优势图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="image" placeholder="课程优势图片">       
        @if($courses)<img src="{{ $courses->image }}" style="max-width:100%; max-height:100px;">@endif 
      </div>
    </div>
<hr/>    
    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label"><span style="color: red">*</span>课程简介</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="课程简介">{{ old('summary', $courses ? $courses->summary : '') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-sm-2 control-label"><span style="color: red">*</span>课程介绍</label>
      <div class="col-sm-9">
        <textarea id="description_editor" type="text/plain" name="description" style="width:650px;height:400px;">{{ old("description", $courses ? $courses->description : '') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="hours_description_editor" class="col-sm-2 control-label"><span style="color: red">*</span>课时说明</label>
      <div class="col-sm-9">
        <textarea id="hours_description_editor" type="text/plain" name="hours_description" style="width:650px;height:400px;">{{ old("hours_description", $courses ? $courses->hours_description : '') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-sm-2 control-label"><span style="color: red">*</span>主讲老师</label>
      <div class="col-sm-9">
        <textarea id="teacher_editor" type="text/plain" name="teacher" style="width:650px;height:400px;">{{ old("teacher", $courses ? $courses->teacher : '') }}</textarea>
      </div>
    </div>
<hr/>
     <div class="form-group">
      <label for="video" class="col-sm-2 control-label">课程视频接入链接</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="video" placeholder="课程视频接入链接，可多个视频链接，一个回车算一个视频">{{ old('video', $courses ? $courses->video : '') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="trialvideo" class="col-sm-2 control-label"><span style="color: red">*</span>试听视频接入链接</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="trialvideo" placeholder="试听视频接入链接" value="{{ old('trialvideo', $courses ? $courses->trialvideo : '') }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="pagetitle" class="col-sm-2 control-label">页面title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagetitle" placeholder="页面title" value="{{ old('pagetitle', $courses ? $courses->pagetitle : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="pagekeyword" class="col-sm-2 control-label">页面keyword</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagekeyword" placeholder="页面keyword" value="{{ old('pagekeyword', $courses ? $courses->pagekeyword : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="pagedescription" class="col-sm-2 control-label">页面description</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagedescription" placeholder="页面description" value="{{ old('pagedescription', $courses ? $courses->pagedescription : '') }}">
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
<script type="text/javascript">
  $(function(){
    $('#level').change(function(){
      var v = $(this).val();
      v == 'zhongxue' ? $('#nengli').show() : $('#nengli').hide();
      if (v == 'zhongxue') { $('#subname').val('教育知识与能力'); $('#subnamelabel').text('教育知识与能力'); }
      if (v == 'xiaoxue') { $('#subname').val('教育教学知识与能力'); $('#subnamelabel').text('教育教学知识与能力'); }
      if (v == 'youer') { $('#subname').val('保教知识与能力'); $('#subnamelabel').text('保教知识与能力'); }
    });

    $('#level').change();

  });
</script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8">
        window.UEDITOR_HOME_URL = location.protocol + '//'+ document.domain + (location.port ? (":" + location.port):"") + "/ueditor/";

        var ue = UE.getEditor('description_editor');
        var ue = UE.getEditor('hours_description_editor');
        var ue = UE.getEditor('teacher_editor');
    </script>
@endsection