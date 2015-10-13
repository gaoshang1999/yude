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
  .paymode {
    display: table;
    width: 100%;
  }
  .paymode .payradio {
    display: table-cell;
    margin: 10px 30px;
  }
  .paymode .payfee {
    display: none;
  }
  .paymode.active {
    border: 1px solid #728ec9;
  }
  .paymode.active .payfee{
    display: table-cell;
    width: 10%;
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
      <div class="bar"><span>2</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar active"><span>3</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>4</span></div>
    </div>
  </div>
  <form id="nextform" action="/order/topay/{{ $order->orderno }}" method="get" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="orderblock clearfix">
    <div class="steplabel">订单信息</div>
    <hr/>
    <div style="border:1px solid #c9c9c9; margin: 10px auto 50px; padding: 10px 30px;">
      <label style="margin-bottom: 0">订单编号：<span>{{ $order->orderno }}</span></label>
      <label style="margin-bottom: 0" class="pull-right">金额：<span>{{ number_format($order->totalprice, 2) }}</span></label>
    </div>
    <div class="steplabel">选择在线支付工具</div>
    <hr/>
    <div>
      <label class="paymode">
        <input type="radio" class="payradio" name="paymode" value="bank">
        <img alt="" src="/assets/img/bank_online.png"><span>&nbsp;&nbsp;网银在线支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
      <label class="paymode">
        <input type="radio" class="payradio" name="paymode" value="alipay">
        <img alt="" src="/assets/img/alipay.png"><span>&nbsp;&nbsp;支付宝支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
      <label class="paymode">
        <input type="radio" class="payradio" name="paymode" value="wxpay">
        <img alt="" src="/assets/img/wxpay.png"><span>&nbsp;&nbsp;微信支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
    </div>
    <input id="btnSubmit" class="pull-right" style="background-color: #f35a01; padding: 10px 20px; border:none; color: white; font-size:16px; margin: 20px auto;" type="button" value="去付款">
  </div>
  </form>
  <input type="hidden" id="pmhidden">
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    $('.payradio').click(function(){
      $('.paymode').removeClass('active');
      $(this).parent().addClass('active');

      $('#pmhidden').val($(this).val());
    });

    $('#btnSubmit').click(function(){
      if ($('#pmhidden').val()) {
        $('#nextform').submit();
      }
    });
  });
</script>
@endsection