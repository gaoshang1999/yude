@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $books ? '编辑' : '创建新' }}教材</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/books/' . ($books ? 'edit/'.$books->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="level" class="col-sm-2 control-label">级别</label>
      <div class="col-sm-9"><?php $level = old('level', $books ? $books->level : 'zhongxue'); ?>
        <select class="form-control" id="level" name="level">
          <option value="zhongxue" {{ $level==='zhongxue' ? 'selected' : '' }}>中学</option>
          <option value="xiaoxue" {{ $level==='xiaoxue' ? 'selected' : '' }}>小学</option>
          <option value="youer" {{ $level==='youer' ? 'selected' : '' }}>幼儿</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="kind" class="col-sm-2 control-label">类别</label>
      <div class="col-sm-9"><?php $kind = old('kind', $books ? $books->kind : 'bishi'); ?>
        <select class="form-control" id="kind" name="kind">
          <option value="bishi" {{ $kind==='bishi' ? 'selected' : '' }}>笔试</option>
          <option value="mianshi" {{ $kind==='mianshi' ? 'selected' : '' }}>面试</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="教材名称" value="{{ old('name', $books ? $books->name : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="price" class="col-sm-2 control-label">定价</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="price" id="price" placeholder="定价" value="{{ old('price', $books ? $books->price : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="discount" class="col-sm-2 control-label">折扣</label>
      <div class="col-sm-9">
        <input type="number" step="1" min="0" max="100" class="form-control" name="discount" id="discount" placeholder="折扣" value="{{ old('discount', $books ? $books->discount : 0) }}"  >
      </div>
    </div>
    <div class="form-group">
      <label for="discount_price" class="col-sm-2 control-label">折扣价</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="折扣价" value="{{ old('discount_price', $books ? $books->discount_price : 0) }}" readonly="true">
      </div>
    </div>
    <div class="form-group">
      <label for="inventory" class="col-sm-2 control-label">库存</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" name="inventory" placeholder="库存" min="0" value="{{ old('inventory', $books ? $books->inventory : 0) }}">
      </div>
    </div>
    <div class="form-group">
      <label for="buytimes" class="col-sm-2 control-label">已售数量</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="buytimes" placeholder="购买次数" min="0" value="{{ old('buytimes', $books ? $books->buytimes : 0) }}">
      </div>
    </div>

    <div class="form-group">
      <label for="author" class="col-sm-2 control-label">作者</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="author" placeholder="作者" min="0" value="{{ old('author', $books ? $books->author : '') }}">
      </div>
    </div>

    <div class="form-group">
      <label for="cover" class="col-sm-2 control-label">教材封面图片</label>
      <div class="col-sm-9">
        <input type="file" class="form-control" name="cover" placeholder="教材封面图片">
        <img src="<?= $books ? $books->cover : '' ?>" style="max-width:100%; max-height:100px;">
      </div>
    </div>

    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label">教材介绍</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="教材介绍">{{ old('summary', $books ? $books->summary : '') }}</textarea>
      </div>
    </div>
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
@endsection