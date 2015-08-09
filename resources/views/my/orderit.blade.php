@extends('app')

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <div class="stepbar clearfix">
    <div class="col-sm-3">
      <div class="bar active"><span>1</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>2</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>3</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>4</span></div>
    </div>
  </div>
  <div class="orderblock">
    <div class="steplabel">我的购课车</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th><label><input type="checkbox" class="checkall">全选</label></th>
            <th>课程信息</th>
            <th>金额（元）</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="headerbar">
            <td colspan="4"><label><input type="checkbox" class="checkvideo">视频课程</label></td>
          </tr>
          <tr>
            <td><label><input type="checkbox" class="video"><img src="{{ $course->cover }}"></label></td>
            <td>{{ $course->name }}</td>
            <td><label class="price">{{ number_format($course->totalprice,2) }}</label></td>
            <td style="width:50px;">
              <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-minus" aria-hidden="true"></span>
                <input type="text" class="form-control" style="width:40px; top:1px;" aria-label="Amount (to the nearest dollar)" value="1">
                <span class="input-group-addon glyphicon glyphicon-plus" aria-hidden="true"></span>
              </div>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="footerbar">
            <td colspan="4" style="padding: 0">
              <label style="margin-left: 8px; margin-top:10px;"><input type="checkbox" class="checkall">全选</label>
              <div class="pull-right">
                合计：<label class="price">{{ number_format($course->totalprice,2) }}</label>
                <input type="button" value="去结算" class="orange-btn">
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    $('.checkall').on('change', function(){
      $('.checkvideo').prop('checked', $(this).prop('checked')).change();
      $('.checkall').prop('checked', $(this).prop('checked'));
    });
    $('.checkvideo').on('change', function(){
      $('.video').prop('checked', $(this).prop('checked'));
    });
  });
</script>
@endsection