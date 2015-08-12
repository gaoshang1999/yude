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
      <form id="orderform" action="/order/step2">
      <table class="table">
        <thead>
          <tr class="choose">
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
          <tr class="choose">
            <td><label><input type="checkbox" class="video" name="check_{{ $course->id }}"><img src="{{ $course->cover }}"></label></td>
            <td>{{ $course->name }}</td>
            <td><label class="price">{{ number_format($course->totalprice, 2) }}</label></td>
            <td style="width:50px;">
              <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-minus counter min" aria-hidden="true"></span>
                <input type="text" class="form-control" style="width:40px; top:1px;" name="count_{{ $course->id }}" readonly value="1">
                <span class="input-group-addon glyphicon glyphicon-plus counter plus" aria-hidden="true"></span>
              </div>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="footerbar">
            <td colspan="4" style="padding: 0">
              <label style="margin-left: 8px; margin-top:10px;"><input type="checkbox" class="checkall">全选</label>
              <div class="pull-right">
                合计：<label class="price">{{ number_format($course->totalprice, 2) }}</label>
                <input type="submit" value="去结算" class="orange-btn">
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    $('.checkvideo').on('change', function(){
      $('.video').prop('checked', $(this).prop('checked'));
    });
    $('.checkall').on('change', function(){
      $('.checkvideo').prop('checked', $(this).prop('checked')).change();
      $('.checkall').prop('checked', $(this).prop('checked'));
    });
    $('.checkall').prop('checked', true).change();

    $('.counter').click(function(){
      var input = $(this).parent().find('input');
      var val = parseInt(input.val());
      if ($(this).hasClass('min')) { val -= 1; }
      if ($(this).hasClass('plus')) { val += 1; }
      if (val < 0) { val = 0; };
      input.val(val);
    });
  });
</script>
@endsection