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

  #btnnew { width: auto; margin-left: 20px; }
  .tab-content { max-height: 400px; overflow: scroll; }
</style>
@endsection

{{-- Content --}}
@section('content')
<div class="col-sm-12 main">
  @include('errors.list')
  
  <h2 class="sub-header">订单列表 
   <form class="search_form pull-right form-inline" role="form" method="get" action="{{ url('/admin/orders') }}" >
    <input type="button" class="btn btn-primary pull-right" id="btnnew" data-toggle="modal" data-target="#myModal" value="新建"/>
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
          <th>产品类别</th>
          <th>产品名称</th>
          <th>产品价格</th>
          <th>订单总价</th>
          <th>付款方式</th>
          <th>订单状态</th>
          <th>用户名</th>
          <th>手机号</th>
          <th>开通方式</th>
          <th>状态</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders->all() as $rowIndex=>$v) <?php $rows = count($v->orderItems); ?>
        <tr class="{{ $rowIndex%2 == 0 ? '' : 'odd' }}" ondblclick="javascript:showDialog({{ $v->id }})">
          <td rowspan="{{ $rows }}">{{ $v->orderno }}</td>
          <td rowspan="{{ $rows }}">{{ $v->created_at }}</td>
          <td> @if($v->orderItems[0]->isBook()) 教材 @else 课程 @endif </td>
          <td>{{ $v->orderItems[0]->title }}</td>
          <td>{{ $v->orderItems[0]->price }}</td>
          <td rowspan="{{ $rows }}">{{ $v->totalprice }}</td>          
          <td rowspan="{{ $rows }}">{{ $v->paymode }}</td>          
          <td rowspan="{{ $rows }}">{{ $v->paytime ? '已支付' : '未支付' }}</td>
          <td rowspan="{{ $rows }}">{{ $v->user->name }}</td>
          <td rowspan="{{ $rows }}">{{ $v->phone }}</td>
          <td rowspan="{{ $rows }}"></td>
          <td rowspan="{{ $rows }}"></td>
          <td rowspan="{{ $rows }}"> </td>
        </tr>
        @for($i=1; $i<$rows; $i++)
        <tr class="{{ $rowIndex%2 == 0 ? '' : 'odd' }}">
          <td> @if($v->orderItems[$i]->isBook()) 教材 @else 课程 @endif </td>
          <td>{{ $v->orderItems[$i]->title }}</td>
          <td>{{ $v->orderItems[$i]->price }}</td>
        </tr>
        @endfor
        @endforeach
      </tbody>
    </table>
    <div>{!! $orders->render() !!}</div>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">选择产品&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="selectedLabel"></label></h4>
        </div>
        <div class="modal-body">
          <form id="productsForm" action="{{ url('/admin/orders/new') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#peple" aria-controls="peple" role="tab" data-toggle="tab">购买人</a></li>
              <li role="presentation"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">课程</a></li>
              <li role="presentation"><a href="#books" aria-controls="books" role="tab" data-toggle="tab">教材</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="peple">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>姓名</th>
                      <th>手机号</th>
                      <th>邮箱</th>
                      <th>类型</th>
                      <th>创建时间</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td><label><input type="radio" name="user" value="{{ $user->id }}"/>&nbsp;&nbsp;{{ $user->id }}</label></td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->phone }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role === 'admin' ? '管理员' : '学员' }}</td>
                      <td>{{ $user->created_at }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="courses">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>课程名称</th>
                      <th>级别</th>
                      <th>类别</th>
                      <th>总价格</th>
                      <th>折扣价</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($courses as $v)
                    <tr>
                      <td><label><input type="checkbox" name="courses[]" value="{{ $v->id }}"/>&nbsp;&nbsp;{{ $v->id }}</label></td>
                      <td>{{ $v->name }}</td>
                      <td>@if($v->level == "zhongxue") 中学  @elseif($v->level == "xiaoxue") 小学 @elseif($v->level == "youer") 幼儿  @endif</td>
                      <td>@if($v->kind == "bishi") 笔试  @elseif($v->kind == "mianshi") 面试  @endif</td>
                      <td>{{ $v->totalprice }}</td>
                      <td>{{ $v->discount_price }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="books">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>教材名称</th>
                      <th>级别</th>
                      <th>类别</th>
                      <th>定价</th>
                      <th>折扣价</th>
                      <th>库存</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($books as $v)
                    <tr>
                      <td><label><input type="checkbox" name="books[]" value="{{ $v->id }}"/>&nbsp;&nbsp;{{ $v->id }}</label></td>
                      <td>{{ $v->name }}</td>
                      <td>@if($v->level == "zhongxue") 中学  @elseif($v->level == "xiaoxue") 小学 @elseif($v->level == "youer") 幼儿  @endif</td>
                      <td>@if($v->kind == "bishi") 笔试  @elseif($v->kind == "mianshi") 面试  @endif</td>
                      <td>{{ $v->price }}</td>
                      <td>{{ $v->discount_price }}</td>
                      <td>{{ $v->inventory }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="btnCreateNew">确定</button>
        </div>
      </div>
    </div>
  </div> <!-- end of modal -->
  
  <!-- Modal -->


  <div class="modal fade" id="orderItemModal" tabindex="-1" role="dialog" aria-labelledby="orderItemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="orderItemModalLabel">订单详情&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="selectedLabel"></label></h4>
        </div>
        <div class="modal-body">
            <div class="loading-modal" id ="orderItemModal_body">加载中...</div>
         </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
      </div>
    </div>
  </div> <!-- end of modal -->
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

    $('#btnCreateNew').click(function(){
      var data = $('#productsForm').serializeArray();
      var keys = $.map(data, function(v){ return v.name; });
      console.log('data : ', data, ' ; keys : ', keys);
      if (keys.length < 1 || keys.indexOf('user') < 0 || (keys.indexOf('courses[]')<0 && keys.indexOf('books[]')<0)) {
        alert('请选择购买人，并至少选择一门课程或一套教材');
      }
      else {
        $('#productsForm').submit();
      }
    });
  });

   function showDialog(id) {
	    $("#orderItemModal_body").html("加载中...");  // Or use a progress bar...
	    $("#orderItemModal").modal("show");
	    $.ajax({
	        url: "{{ url('/admin/orders')}}/"+ id,
	    }).success(function(data) {
	        $("#orderItemModal_body").html(data);
	    });
	}
</script>
@endsection