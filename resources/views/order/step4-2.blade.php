@extends('front.app')

@section('styles')
<style type="text/css">
  
  pre {
    display: block;
    padding: 9.5px;
    margin: 0 0 10px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #333;
    word-break: break-all;
    word-wrap: break-word;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="col-sm-12 main" >
  @include('errors.list')
  <div class="stepbar clearfix">
    <div class="col-sm-3">
      <div class="bar"><span>1</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>2</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar"><span>3</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar active"><span>4</span></div>
    </div>
  </div>
  <div class="orderblock clearfix">
    <div style="margin: 40px 230px;text-align: left">
      <label style="font-size: 24px; color: #000000"><img src="/assets/img/bank_offline.png" style="vertical-align:bottom; margin-right:10px;">银行汇款账号</label>
      <hr/>
      
       <div style="float: right; border:none; text-align: left; padding: 5px 10px; background-color: #eeeeee;  ">
  
<pre style="border:none; text-align: left; background-color: #eeeeee; "> <span  style=" color: #000000; font-size: 18px;">温馨提示</span>
1.可用手机拍下此页，方便查阅。
2.你也可以用微信二维码把账号扫描出
来，并复制粘贴到短信草稿箱里。
</pre> 
 <img alt="" src="/assets/img/bank_card_code.png"  style="margin-left:45px;"/>
 </div>
      
      <div style="margin: 20px 40px;">
      <span style="background-color: #ffecb2; width=200px; font-size: 18px;">对公账户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <pre style="border:none; text-align: left; padding: 10px 30px; line-height:1.5;background-color: #ffffff; font-size: 18px;">
收款单位：北京育德园师教育科技有限公司
账号：9104 0154 8000 00373
开户行：上海浦东发展银行北京黄寺支行
</pre>


 

 
 
<pre style="border:none; text-align: left; padding: 10px 30px; line-height:1.5;background-color: #ffffff; color: #f35a01; font-size: 18px;">
注意：汇款时填写的信息必须和以上完全一致，否则会被银行退回。
</pre>

 <pre style="border:none; text-align: left; padding: 50px 30px; line-height:1.5;background-color: #ffffff;">
 </pre>


<hr/>
<pre style="border:none; text-align: left; padding: 10px 30px; line-height:1.5;background-color: #ffffff; ">
<span  style=" color: #f35a01">说明：</span>
1.汇款时请多汇几元钱或者几角钱，如100.7元，目的是为了确认谁汇的款。
2.付款后填写：说明汇款银行、金额已经你是详细要求！
3.7*8小时服务热线：400-607-107 查询。
</pre>

<input style="float: right; background-color: #f35a01; padding: 10px 20px; border:none; color: white; font-size:16px; margin: 0px auto;" type="button" onclick="javascript:gotoHome();" value="确认并返回首页">
      </div>
      <div style="margin: 20px;"></div>
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
  });

  function gotoHome()
  {
	  window.location.href = "/";
  }
</script>
@endsection