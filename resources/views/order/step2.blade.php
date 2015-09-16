@extends('front.app')

@section('styles')
<style type="text/css">
  .priceblock {
    text-align: right !important;
    margin-top: 30px;
  }
  .priceblock div {
    text-align: right !important;
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
  <form action="/order/step3" method="post" id="order_form">
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
        <div style="margin-bottom: 5px;"><span style="color: red">*</span>收件人：<input name="receiver" id="order_receiver" data-label="收件人"><span id="receiver_hint"  class="dn" style="color: red"></span></div>
        <div style="margin-bottom: 5px;"><span style="color: red">*</span>手机号：<input name="phone" id="order_phone" data-label="手机号"><span id="phone_hint"  class="dn" style="color: red"></span></div>
        <div style="margin-bottom: 5px;"><span style="color: red">*</span>邮&nbsp;&nbsp;&nbsp;编：<input name="postcode" id="order_postcode" data-label="邮编"><span id="postcode_hint"  class="dn" style="color: red"></span></div>
        <div style="margin-bottom: 5px;"><span style="color: red">*</span>地&nbsp;&nbsp;&nbsp;址：<input name="address" id="order_address" data-label="地址"><span id="address_hint"  class="dn" style="color: red"></span></div>
      </div>
    </div>
    <input type="hidden" name="items_c" value="{{ json_encode($items_c) }}"> 
    <input type="hidden" name="items_b" value="{{ json_encode($items_b) }}">
  </div>
  <div class="orderblock" style="margin-top: 10px;">
    <div class="steplabel">购课清单</div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead><?php $i=1; ?>
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
          @foreach ($courses as $v)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $v->name }}</td>
            <td>课程</td>
            <td>1</td>
            <td>{{ $v->computePrice( $items_c[$v->id] ) }}</td>
            <td></td>
          </tr>
          @endforeach
          @foreach ($books as $v) 
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $v->name }}</td>
            <td>教材</td>
            <td>{{ $v->count }}</td>
            <td>{{ $v->count * $v->discount_price }}</td>
            <td></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="priceblock"> <!-- 免运费的逻辑，只考虑教材的价格  -->
        <div>共{{$count}}件商品，商品总金额：<label>￥{{ number_format($total, 2) }}</label></div>  <?php $rows = count($books);  $fee = config('order.shipping_fee'); ?>
        <div><span style="color: red">(教材满100元免运费)</span>运费：<label> {{ ($rows > 0)?($books_total >=100 ? 0 : $fee) : 0 }}</label></div>
        <div>应付总额：<label>￥{{ number_format( $total + (($rows > 0)?($books_total >=100 ? 0 : $fee) : 0 ) , 2) }}</label></div>  
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

   function check_phone(element_id){
	 var element = $("#"+element_id);
  	 var span = element.parent().find('span').eq(1); 
     var value = element.val();  

      var reg=/^1\d{10}$/;       
      if(value.length ==0){
      	span.removeClass("dn");
      	span.html("× 请输入手机号");
      	return false;
      }else if (!reg.test(value)) {
      	span.removeClass("dn");
      	span.html("× 手机号格式错误");
      	return false;
      }else{
     	 span.addClass("dn");
         return true;
      }
      return true;
	};


 function check(element_id){
	 var element = $("#"+element_id);
	 var value = element.val();  
	 var span = element.parent().find('span').eq(1);
	 var label = element.data('label');

	 if(value.length == 0 ){
         span.html("× 请输入"+label);
         span.removeClass("dn");
         return false;
     }else{
    	 span.addClass("dn");
         return true;
     }
     return true;
 }
  
  var order_form = $('#order_form');
  order_form.submit(function (ev) { 
	  if(!check("order_receiver")){
          ev.preventDefault();
	      return false;
	  }

	  if(!check_phone("order_phone")){
          ev.preventDefault();
	      return false;
	  }

	  if(!check("order_postcode")){
          ev.preventDefault();
	      return false;
	  }

	  if(!check("order_address")){
          ev.preventDefault();
	      return false;
	  }
  	
      return true;
  });

  
</script>
@endsection