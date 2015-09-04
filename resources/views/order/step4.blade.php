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
  pre {
    display: block;
    padding: 9.5px;
    margin: 0 0 10px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #333;
    word-break: break-all;
    word-wrap: break-word;
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    border-radius: 4px;
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
      <div class="bar"><span>3</span></div>
    </div>
    <div class="col-sm-3">
      <div class="bar active"><span>4</span></div>
    </div>
  </div>
  <div class="orderblock clearfix">
    <div style="text-align: center">
      <label style="font-size: 24px; color: #009839"><img src="/assets/img/rightgreen.png" style="vertical-align:bottom; margin-right:10px;">恭喜您的订单已经交易成功</label>
      <div style="margin: 40px 230px;">
        <pre style="border: 1px solid #f56d18; text-align: left; padding: 10px 30px; line-height:1.5">
温馨提示：
您好，你的课程/教材已经购买成功！
如果您购买了课程，您可以在登录状态下，点击屏幕右上角的“学习课程”观看视频课件。
如果您购买了教材，或者有赠送材料，我们工作人员会及时按照您填写的地址发送，请注意查收。
如有疑问，请拨打4000-607-107</pre>
      </div>
      <div style="margin: 20px;"><a href="{{ url('/my/profile') }}" style="margin-right: 30px; color: black;">前往个人中心查看订单</a><a href="/" style=" color: black;">返回首页</a></div>
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
</script>
@endsection