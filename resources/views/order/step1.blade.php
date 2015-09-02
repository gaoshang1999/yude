@extends('front.app')

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
            <th>数量</th>
            <th>小计</th>         
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="headerbar">
            <td colspan="6"><label><input type="checkbox" class="checkvideo">视频课程</label></td>
          </tr>
          @foreach ($courses ->all() as $v)
          <tr class="choose">
            <td><label><input type="checkbox" class="video" name="check_c_{{ $v->id }}"><img src="{{ $v->cover }}"></label></td>
            <td>{{ $v->name }}</td>
            <td><label class="price">{{ number_format($v->totalprice, 2) }}</label></td>
            <td style="width:50px;">
              <div class="input-group">

                <input type="hidden" class="form-control" style="width:40px; top:1px;" name="count_c_{{ $v->id }}" readonly value="1" data-key="c_{{ $v->id }}" data-value="{{ $v->totalprice }}"/>
     
                1
              </div>
            </td>
             <td><label class="price" id="c_{{ $v->id }}">{{ number_format($v->totalprice, 2) }}</label></td>
            <td><a href="{{ url("cart/courses/remove/$v->id") }}">移除</a></td>         
          </tr>
          @endforeach
          
          <tr class="headerbar">
            <td colspan="6"><label><input type="checkbox" class="checkbook">教材</label></td>
          </tr>
          @foreach ($books ->all() as $v)
          <tr class="choose">
            <td><label><input type="checkbox" class="book" name="check_b_{{ $v->id }}"><img src="{{ $v->cover }}"></label></td>
            <td>{{ $v->name }}</td>
            <td><label class="price">{{ number_format($v->discount_price, 2) }}</label></td>
            <td style="width:50px;">
              <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-minus counter min" aria-hidden="true"></span>
                <input type="text" class="form-control" style="width:40px; top:1px;" name="count_b_{{ $v->id }}" readonly value="1" data-key="b_{{ $v->id }}" data-value="{{ $v->discount_price }}"/>
                <span class="input-group-addon glyphicon glyphicon-plus counter plus" aria-hidden="true"></span>
              </div>
            </td>
             <td><label class="price" id="b_{{ $v->id }}">{{ number_format($v->discount_price, 2) }}</label></td>
            <td><a href="{{ url("cart/books/remove/$v->id") }}">移除</a></td>    
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="footerbar">
            <td colspan="6" style="padding: 0">
              <label style="margin-left: 8px; margin-top:10px;"><input type="checkbox" class="checkall">全选</label>
              <div class="pull-right">
                合计：<label class="price" id ="total"> {{  number_format($total, 2) }}</label>
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
<script src="/assets/js/jquery.formatCurrency-1.4.0.js"></script>
<script type="text/javascript">
  $(function(){
    $('.checkvideo').on('change', function(){
      $('.video').prop('checked', $(this).prop('checked'));
    });
    $('.checkbook').on('change', function(){
        $('.book').prop('checked', $(this).prop('checked'));
      });
    $('.checkall').on('change', function(){
      $('.checkvideo').prop('checked', $(this).prop('checked')).change();
      $('.checkbook').prop('checked', $(this).prop('checked')).change();
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

      $('#'+input.data('key')).html((input.data('value') * val));
      $('#'+input.data('key')).formatCurrency() 
      
      var total = 0;
      $('.form-control').each(function(){
    	 total += $(this).data('value') * $(this).val();
      });

      $('#total').html(total);
      $('#total').formatCurrency()
    });
    
  });
</script>
@endsection