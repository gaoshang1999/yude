@extends('front.app')

@section('styles')
<style type="text/css">
  .priceblock {
    text-align: right;
    margin-top: 30px;
  }
  .priceblock div label {
    min-width: 100px;
  }
  .checkbutton {
    border: 1px solid #c9c9c9;
    padding: 5px 8px;
    display: inline-block;
    margin: auto 20px;

  }
  .checkbutton.checked {
    border: 1px solid #e4383b;
    background-image: url(/assets/img/checkbutton.png);
    background-repeat: no-repeat;
    background-size: 25%;
    background-position: right bottom;
  }
  label {
      display: inline-block;
      max-width: 100%;
      margin-bottom: 5px;
      font-weight: 700;
  }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  <div class="stepbar clearfix">
    <div class="col-sm-3">
      <div class="bar"><span>1</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar active"><span>2</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>3</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>4</span></div>
    </div>
  </div>
  <form action="/order/step3" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="orderblock">
    <div class="steplabel">支付方式</div>
    <hr/>
    <div>
      <div class="checkbutton checked" data-value="online">在线支付</div>
      <div class="checkbutton" data-value="bank">银行汇款</div>
      <input type="hidden" id="paymode" name="paymode" value="online">
    </div>
    <div class="steplabel" style="margin-top: 50px">教材邮寄地址</div>
    <hr style="margin-bottom: 5px;"/>
    <label style="margin-left: 20px;">请确保填写信息真实有效，以保证育德园师的工作人员更好的为您服务。</label>
    <div style="margin-left: 20px;">
      <div style="margin-top:10px">
        <div>收件人：<input name="receiver"></div>
        <div>手机号：<input name="phone"></div>
        <div>邮&nbsp;&nbsp;&nbsp;编：<input name="postcode"></div>
        <div>地&nbsp;&nbsp;&nbsp;址：<input name="address"></div>
      </div>
    </div>
    <input type="hidden" name="items_c" value="{{ $items_c }}"> 
    <input type="hidden" name="items_b" value="{{ $items_b }}">
  </div>
  <div class="orderblock" style="margin-top: 10px;">
    <div class="steplabel">购课清单</div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr style="background-color: #f6f6f6;">
            <th>序号</th>
            <th>产品名称</th>
            <th>类别</th>
            <th>数量</th>
            <th>价格</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($courses as $i=>$v)
          <tr>
            <td>{{ $i }}</td>
            <td>{{ $v->name }}</td>
            <td>课程</td>
            <td>{{ $v->count }}</td>
            <td>{{ $v->count * $v->totalprice }}</td>
            <td></td>
          </tr>
          @endforeach
          @foreach ($books as $i=>$v)
          <tr>
            <td>{{ $i }}</td>
            <td>{{ $v->name }}</td>
            <td>教材</td>
            <td>{{ $v->count }}</td>
            <td>{{ $v->count * $v->discount_price }}</td>
            <td></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="priceblock">
        <div>共{{$count}}件商品，商品总金额：<label>￥{{ number_format($total, 2) }}</label></div>
        <div>运费：<label>￥20</label></div>
        <div>应付总额：<label>￥{{ number_format($total+20, 2) }}</label></div>
        <input style="background-color: #f35a01; padding: 10px 20px; border:none; color: white; font-size:16px; margin: 20px auto;" type="submit" value="提交订单">
      </div>
    </div>
  </div>
  </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    $('.checkbutton').click(function(){
      if (!$(this).hasClass('checked')) {
        $('.checkbutton').removeClass('checked');
        $(this).addClass('checked');

        $('#paymode').val($(this).data('value'));
      }
    });
  });
</script>
@endsection