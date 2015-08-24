@extends('front.app')

{{-- Web site Title --}}
@section('title') 商品已成功加入购物车 @stop

@section('styles') 
<link href="/assets/css/cart.css" rel="stylesheet" type="text/css" />
@stop


{{-- Content --}}
@section('content')

 

           <div class="success">
           <div class="success-b">
            <img src="/assets/img/check.png"/>
            <h3>商品已成功加入购物车！</h3>
            <span id="flashBuy" style="display:none">商品数量有限，请您尽快下单并付款！</span>
            </div>

                <span id="initCart_next_go">
                <a id="GotoShoppingCart" class="btn-1" href="{{ url("order") }}?url=order">去购物车结算</a>
                <span id="next" class="next">
                您还可以
                <a id="jxgw" class="jxgw" href="javascript:history.back();">继续购物</a>
                </span>
                </span>

        </div>

         	
@endsection
