@extends('admin/admin')

@section('styles')
<style type="text/css">
  .main { padding: 20px; }
  #svalue { margin-left: 10px; margin-right: 10px; }
  .table-striped>tbody>tr:nth-of-type(odd) {
    background-color: inherit;
  }
  .table-striped>tbody>tr.odd, .table-striped>thead>tr.odd {
    background-color: #f9f9f9;
  }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  
  <h2 class="sub-header">订单列表 
   <form class="search_form pull-right form-inline" role="form" method="get" action="{{ url('/admin/orders') }}" >    
    <button class="btn btn-primary pull-right" type="submit">搜索</button>
    <input class="pull-right form-control" type="text" placeholder="搜索" name="stext" id="stext" value="{{ isset($stext) ? $stext : "" }}"/>
    <select class="form-control pull-right" name="svalue" id="svalue"></select>
    <select class="form-control pull-right" name="stype" id="stype">
      <option value="phone" {{ isset($stype) && $stype=='phone' ? 'selected' : '' }}>手机号</option>
      <option value="item_title" {{ isset($stype) && $stype=='item_title' ? 'selected' : '' }}>课程名称</option>
      <option value="orderno" {{ isset($stype) && $stype=='orderno' ? 'selected' : '' }}>订单号</option>
      <option value="paytime" {{ isset($stype) && $stype=='paytime' ? 'selected' : '' }}>订单状态</option>
      <option value="paymode" {{ isset($stype) && $stype=='paymode' ? 'selected' : '' }}>付款方式</option>
    </select>
  </form>
 </h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="odd">
          <th>订单编号</th>
          <th>购买时间</th>
          <th>产品名称</th>
          <th>产品价格</th>
          <th>订单总价</th>
          <th>付款方式</th>
          <th>订单状态</th>
          <th>手机号</th>
          <th>开通方式</th>
          <th>状态</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders->all() as $rowIndex=>$v) <?php $rows = count($v->orderItems); ?>
        <tr class="{{ $rowIndex%2 == 0 ? '' : 'odd' }}">
          <td rowspan="{{ $rows }}">{{ $v->orderno }}</td>
          <td rowspan="{{ $rows }}">{{ $v->created_at }}</td>
          <td>{{ $v->orderItems[0]->title }}</td>
          <td>{{ $v->orderItems[0]->price }}</td>
          <td rowspan="{{ $rows }}">{{ $v->totalprice }}</td>          
          <td rowspan="{{ $rows }}">{{ $v->paymode }}</td>          
          <td rowspan="{{ $rows }}">{{ $v->paytime ? '已支付' : '未支付' }}</td>
          <td rowspan="{{ $rows }}">{{ $v->phone }}</td>
          <td rowspan="{{ $rows }}"></td>
          <td rowspan="{{ $rows }}"></td>
          <td rowspan="{{ $rows }}"></td>
        </tr>
        @for($i=1; $i<$rows; $i++)
        <tr class="{{ $rowIndex%2 == 0 ? '' : 'odd' }}">
          <td>{{ $v->orderItems[$i]->title }}</td>
          <td>{{ $v->orderItems[$i]->price }}</td>
        </tr>
        @endfor
        @endforeach
      </tbody>
    </table>
    <div>{!! $orders->render() !!}</div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  var cbsvalue = '{{ isset($svalue) ? $svalue : '' }}';
  $(function(){
    $('#stype').change(function(){
      var type = $(this).val();
      $('#stext').toggle(!(type == 'paymode' || type == 'paytime'));
      $('#svalue').toggle(type == 'paymode' || type == 'paytime');
      if (type == 'paymode') {
        $('#svalue').html('<option value="alipay">支付宝</option><option value="wxpay">微信</option><option value="bank">网银</option><option value="default">缺省</option>');
      }
      else if (type == 'paytime') {
        $('#svalue').html('<option value="payed">已支付</option><option value="nopay">未支付</option>');
      }
      $('#svalue').val(cbsvalue);
    });
    $('#stype').change();
  });
</script>
@endsection