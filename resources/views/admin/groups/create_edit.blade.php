@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $groups ? '编辑' : '创建新' }}课程组</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/groups/' . ($groups ? 'edit/'.$groups->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label"><span style="color: red">*</span>名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="名称" value="{{ old('name', $groups ? $groups->name : '') }}">
      </div>
    </div>

    <div class="form-group">
      <label for="rank" class="col-sm-2 control-label"><span style="color: red">*</span>显示顺序</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="rank" placeholder="显示顺序" min="1"  step="1" value="{{ old('rank', $groups ? $groups->rank : 0) }}">
      </div>
    </div>

    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label">课程组简介</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="课程组">{{ old('summary', $groups ? $groups->summary : '') }}</textarea>
      </div>
    </div>
    

<hr/>
    <div class="form-group">
      <label for="zx_course" class="col-sm-2 control-label">中学课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="zx_course" placeholder="中学课程" value="{{ old('zx_course', $groups ? $groups->zx_course : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="xx_course" class="col-sm-2 control-label">小学课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="xx_course" placeholder="小学课程" value="{{ old('xx_course', $groups ? $groups->xx_course : '') }}">
      </div>
    </div>
    <div class="form-group">
      <label for="yr_course" class="col-sm-2 control-label">幼儿课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="yr_course" placeholder="幼儿课程" value="{{ old('yr_course', $groups ? $groups->yr_course : '') }}">
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

