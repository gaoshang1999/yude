@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $courses ? '编辑' : '创建新' }}课程</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/courses/' . ($courses ? 'edit/'.$courses->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="level" class="col-sm-2 control-label">级别</label>
      <div class="col-sm-9"><?php $level = old('level', $courses ? $courses->level : 'zhongxue'); ?>
        <select class="form-control" id="level" name="level">
          <option value="zhongxue" {{ $level==='zhongxue' ? 'selected' : '' }}>中学</option>
          <option value="xiaoxue" {{ $level==='xiaoxue' ? 'selected' : '' }}>小学</option>
          <option value="youer" {{ $level==='youer' ? 'selected' : '' }}>幼儿</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="kind" class="col-sm-2 control-label">类别</label>
      <div class="col-sm-9"><?php $kind = old('kind', $courses ? $courses->kind : 'bishi'); ?>
        <select class="form-control" id="kind" name="kind">
          <option value="bishi" {{ $kind==='bishi' ? 'selected' : '' }}>笔试</option>
          <option value="mianshi" {{ $kind==='mianshi' ? 'selected' : '' }}>面试</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="课程名称" value="{{ old('name', $courses ? $courses->name : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="enable" class="col-sm-2 control-label">状态</label>
      <div class="col-sm-9"><?php $enable = old('enable', $courses ? $courses->enable : true); ?>
        <label class="radio-inline"><input type="radio" name="enable" value="1" {{ $enable ? 'checked' : '' }}> 上架</label>
        <label class="radio-inline"><input type="radio" name="enable" value="0" {{ $enable ? '' : 'checked' }}> 下架</label>
      </div>
    </div>
    <div class="form-group">
      <label for="buytimes" class="col-sm-2 control-label">购买次数</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="buytimes" placeholder="购买次数" min="0" value="{{ old('buytimes', $courses ? $courses->buytimes : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="hours" class="col-sm-2 control-label">课时</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="hours" placeholder="课时" min="0" value="{{ old('hours', $courses ? $courses->hours : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="totalprice" class="col-sm-2 control-label">总价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="totalprice" placeholder="总价格" min="0" value="{{ old('totalprice', $courses ? $courses->totalprice : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="subprice" class="col-sm-2 control-label">子科价格</label>
      <div class="col-sm-3">
        <input type="hidden" name="subname" id="subname">
        <label class="control-label" id="subnamelabel">教育知识与能力</label>
      </div>
      <div class="col-sm-6">
        <input type="number" class="form-control" name="subprice" placeholder="子科价格" min="0" value="{{ old('subprice', $courses ? $courses->subprice : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="zongheprice" class="col-sm-2 control-label">综合素质价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="zongheprice" placeholder="综合素质价格" min="0" value="{{ old('zongheprice', $courses ? $courses->zongheprice : 0) }}">
      </div>
    </div>
    <div class="form-group" id="nengli">
      <label for="nengliprice" class="col-sm-2 control-label">学科知识与能力价格</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="nengliprice" placeholder="学科知识与能力价格" min="0" value="{{ old('nengliprice', $courses ? $courses->nengliprice : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="cover" class="col-sm-2 control-label">课程封面图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover" placeholder="课程封面图片">
        <img src="<?= $courses ? $courses->cover : '' ?>" style="max-width:100%; max-height:100px;">
      </div>
    </div>
    <div class="form-group">
      <label for="video" class="col-sm-2 control-label">课程视频接入链接</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="video" placeholder="课程视频接入链接，可多个视频链接，一个回车算一个视频">{{ old('video', $courses ? $courses->video : '') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="trialvideo" class="col-sm-2 control-label">试听视频接入链接</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="trialvideo" placeholder="试听视频接入链接" value="{{ old('trialvideo', $courses ? $courses->trialvideo : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label">课程介绍</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="课程介绍">{{ old('summary', $courses ? $courses->summary : '') }}</textarea>
      </div>
    </div>
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
        <button type="submit" class="btn btn-primary">保存</button>
      </div>
    </div>
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
@endsection