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
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="orderblock clearfix">
    <div class="steplabel">订单信息</div>
    <hr/>
    <div style="border:1px solid #c9c9c9; margin: 10px auto 50px; padding: 10px 30px;">
      <label style="margin-bottom: 0">订单编号：<span>{{ $order->orderno }}</span></label>
      <label style="margin-bottom: 0" class="pull-right">金额：<span>{{ number_format($order->totalprice, 2) }}</span></label>
    </div>
    <div class="steplabel">请用微信扫描下方二维码进行支付</div>
    <hr/>
    <div style="text-align:center">
      <img src="/wxpay/qrcode/{{ $order->orderno }}/{{ $order->totalprice }}"/>
      <label id="wxscan">微信扫描</label>
    </div>
  </div>
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

    function checkorder() {
      setTimeout(function(){
        $.get('/wxpay/checkorder/{{ $order->orderno }}', function(data){
          if (data == 'ok') {
            $('#wxscan').html('支付成功！');
            setTimeout(function(){
              window.location.href = "/order/step4";
            }, 500);
          }
          else {
            checkorder();
          }
        });
      }, 1000);
    }
  });
</script>
@endsection