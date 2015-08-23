@extends('app')

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
  #payfail {
    background-color: #525252;
    color: white;
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
  <div>
    <pre id="payfail">付款遇到问题了？先看看是不是由于下面的原因。
要求开通网上银行？
建议选择银联在线支付付款，如果是信用卡还可选择快捷支付，再选择对应银行支付。
所需支付金额超过了银行支付限额？
建议登录网上银行提高上限额度，即可轻松支付。
收不到银行的短信验证码？
建议重新获取短信验证码，如果还是收不到短信，直接打各银行的客服电话获取短信验证码。
网银页面显示错误或者空白？
建议更换到IE浏览器进行支付操作，或使用银联在线支付或支付宝付款。
网上银行扣款后，订单仍显示"未付款"怎么办？
可能是由于银行的数据没有即时传输，请您不要担心，稍后刷新页面查看。如较长时间仍显示未付款，可先向银行或支付平台获取支付凭证（扣款订单号/第三
方交易号），联系育德课堂客服热线（4000-607-107）为您解决。</pre>
  </div>
  <form action="/order/topay/{{ $order->orderno }}" method="get">
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
        <span>网银在线支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
      <label class="paymode">
        <input type="radio" class="payradio" name="paymode" value="alipay">
        <span>支付宝支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
      <label class="paymode">
        <input type="radio" class="payradio" name="paymode" value="wxpay">
        <span>微信支付</span>
        <span class="payfee">支付 {{ number_format($order->totalprice, 2) }}</span>
      </label>
      <input type="hidden" id="paymode" name="paymode" value="alipay">
    </div>
    <input class="pull-right" style="background-color: #f35a01; padding: 10px 20px; border:none; color: white; font-size:16px; margin: 20px auto;" type="submit" value="去付款">
  </div>
  </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    $('.payradio').click(function(){
      $('.paymode').removeClass('active');
      $(this).parent().addClass('active');

      $('#paymode').val($(this).val());
    });
  });
</script>
@endsection