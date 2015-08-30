@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $books ? '编辑' : '创建新' }}教材</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/books/' . ($books ? 'edit/'.$books->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="level" class="col-sm-2 control-label"><span style="color: red">*</span>级别</label>
      <div class="col-sm-9"><?php $level = old('level', $books ? $books->level : 'zhongxue'); ?>
        <select class="form-control" id="level" name="level">
          <option value="zhongxue" {{ $level==='zhongxue' ? 'selected' : '' }}>中学</option>
          <option value="xiaoxue" {{ $level==='xiaoxue' ? 'selected' : '' }}>小学</option>
          <option value="youer" {{ $level==='youer' ? 'selected' : '' }}>幼儿</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="kind" class="col-sm-2 control-label"><span style="color: red">*</span>类别</label>
      <div class="col-sm-9"><?php $kind = old('kind', $books ? $books->kind : 'bishi'); ?>
        <select class="form-control" id="kind" name="kind">
          <option value="bishi" {{ $kind==='bishi' ? 'selected' : '' }}>笔试</option>
          <option value="mianshi" {{ $kind==='mianshi' ? 'selected' : '' }}>面试</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label"><span style="color: red">*</span>名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="教材名称" value="{{ old('name', $books ? $books->name : '') }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="price" class="col-sm-2 control-label"><span style="color: red">*</span>定价</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="price" id="price" placeholder="定价" value="{{ old('price', $books ? $books->price : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="discount" class="col-sm-2 control-label"><span style="color: red">*</span>折扣</label>
      <div class="col-sm-9">
        <input type="number" step="1" min="0" max="100" class="form-control" name="discount" id="discount" placeholder="折扣" value="{{ old('discount', $books ? $books->discount : 0) }}"  >
      </div>
    </div>
    <div class="form-group">
      <label for="discount_price" class="col-sm-2 control-label"><span style="color: red">*</span>折扣价</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="折扣价" value="{{ old('discount_price', $books ? $books->discount_price : 0) }}" readonly="true">
      </div>
    </div>
    <div class="form-group">
      <label for="inventory" class="col-sm-2 control-label"><span style="color: red">*</span>库存</label>
        <div class="col-sm-9"><?php $enable = old('inventory', $books ? $books->inventory > 0 : true); ?>
            <label class="radio-inline"><input type="radio" name="inventory" value="1" {{ $enable ? 'checked' : '' }}> 有货</label>
        <label class="radio-inline"><input type="radio" name="inventory" value="0" {{ $enable ? '' : 'checked' }}> 无货</label>
      </div>
    </div>
    <div class="form-group">
      <label for="buytimes" class="col-sm-2 control-label"><span style="color: red">*</span>已售数量</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="buytimes" placeholder="购买次数" min="0" value="{{ old('buytimes', $books ? $books->buytimes : 0) }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="author" class="col-sm-2 control-label"><span style="color: red">*</span>作者</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="author" placeholder="作者"  value="{{ old('author', $books ? $books->author : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="press" class="col-sm-2 control-label"><span style="color: red">*</span>出版社</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="press" placeholder="出版社"  value="{{ old('author', $books ? $books->press : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="publish_date" class="col-sm-2 control-label"><span style="color: red">*</span>出版时间</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="publish_date" placeholder="出版时间"  value="{{ old('author', $books ? $books->publish_date : '') }}">
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="cover" class="col-sm-2 control-label"><span style="color: red">*</span>教材封面图片 1</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover" placeholder="教材封面图片">
        @if($books)<img src="{{ $books->cover }}" style="max-width:100%; max-height:100px;">@endif        
      </div>
    </div>
    <div class="form-group">
      <label for="cover2" class="col-sm-2 control-label"><span style="color: red">*</span>教材封面图片 2</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover2" placeholder="教材封面图片">
        @if($books)<img src="{{ $books->cover2 }}" style="max-width:100%; max-height:100px;">@endif        
      </div>
    </div>
    <div class="form-group">
      <label for="cover3" class="col-sm-2 control-label"><span style="color: red">*</span>教材封面图片 3</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover3" placeholder="教材封面图片">
        @if($books)<img src="{{ $books->cover3 }}" style="max-width:100%; max-height:100px;">@endif        
      </div>
    </div>
    <div class="form-group">
      <label for="cover4" class="col-sm-2 control-label"><span style="color: red">*</span>教材封面图片 4</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover4" placeholder="教材封面图片">
        @if($books)<img src="{{ $books->cover4 }}" style="max-width:100%; max-height:100px;">@endif        
      </div>
    </div>        
    <div class="form-group">
      <label for="image" class="col-sm-2 control-label"><span style="color: red">*</span>教材特色图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="image" placeholder="教材封面图片">
        @if($books)<img src="{{ $books->image }}" style="max-width:100%; max-height:100px;">@endif        
      </div>
    </div>       
<hr/>
    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label"><span style="color: red">*</span>教材简介</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="教材介绍">{{ old('summary', $books ? $books->summary : '') }}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="description" class="col-sm-2 control-label"><span style="color: red">*</span>教材介绍</label>
      <div class="col-sm-9">
        <textarea id="description_editor" type="text/plain" name="description" style="width:650px;height:400px;">{{ old("description", $books ? $books->description : '') }}</textarea>
      </div>
    </div>
<hr/>
    <div class="form-group">
      <label for="pagetitle" class="col-sm-2 control-label">页面title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagetitle" placeholder="页面title" value="{{ old('pagetitle', $books ? $books->pagetitle : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="pagekeyword" class="col-sm-2 control-label">页面keyword</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagekeyword" placeholder="页面keyword" value="{{ old('pagekeyword', $books ? $books->pagekeyword : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="pagedescription" class="col-sm-2 control-label">页面description</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="pagedescription" placeholder="页面description" value="{{ old('pagedescription', $books ? $books->pagedescription : '') }}">
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
    $('#price').change(function(){
      var v1 = $('#price').val();
      var v2 = $('#discount').val();
//       alert(parseFloat(v1)); alert(parseFloat(v2));
      $('#discount_price').val(parseFloat(v1)*parseFloat(v2)/100.0);
    });
    
    $('#discount').change(function(){
        var v1 = $('#price').val();
        var v2 = $('#discount').val();
        $('#discount_price').val(parseFloat(v1)*parseFloat(v2)/100.0);
      });

    $('#price').change();
    $('#discount').change();
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
    </script>
@endsection