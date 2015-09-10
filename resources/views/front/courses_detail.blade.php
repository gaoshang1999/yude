@extends('front.app')

{{-- Web site Title --}}
@section('title') {{ $course->pagetitle }} @stop
@section('meta_keywords') 
    <meta name="keywords" content="{{ $course->pagekeyword }}"/>
@stop
@section('meta_description') 
    <meta name="description" content="{{ $course->pagedescription }}"/>
@stop

@section('styles') 
        <link href="/assets/css/spxqy.css" rel="stylesheet" type="text/css" /> 
@stop

{{-- Content --}}
@section('content')
		
		<!--视频简介-->
		<div id="content_jianjie">
				<!--图片简介-->
				<div class="spjj">
						<div class="pic"><img src="{{ url("$course->cover") }}" width="440px" height="256px"/></div>
				
						<!--文字简介-->
						<div class="wenzi">
								<h1>{{ $course->name }}</h1>
								<p>{{ $course->summary }}</p>
								<form action="{{ url("cart/courses/add/$course->id") }}" method="post" id="order_form">     <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<p><input type="submit" title="立即购买" id="discount_price" value="立即购买 ￥{{ $course->discount_price }}"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="fz24 gray">原价&nbsp;<del id="total_price">￥{{ $course->totalprice }}</del></span> </p>
								<p class="p3">可选单科&nbsp;&nbsp;&nbsp;&nbsp;		
								    @if($course->discount_subprice) <label><input type="checkbox" name="subitem[]" value="1" data-price="{{ $course->subprice }}" data-discount_price="{{ $course->discount_subprice }}"  checked/>&nbsp;{{$course->subname}}</label>&nbsp;&nbsp;&nbsp; @endif
									@if($course->discount_zongheprice) 	<label><input type="checkbox" name="subitem[]" value="2"  data-price="{{ $course->zongheprice }}" data-discount_price="{{ $course->discount_zongheprice }}"   checked/>&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp; @endif
								@if($course->isZhongxue())
									@if($course->discount_nengliprice) 	<label><input type="checkbox" name="subitem[]" value="4"  data-price="{{ $course->nengliprice }}" data-discount_price="{{ $course->discount_nengliprice }}"  checked/>&nbsp;学科知识与能力</label> @endif
								@endif
									
								</p>
								<p class="p4">已有{{ $course->buytimes }}人购买该课程</p>
								</form>
						</div>
				</div>
		</div>		
		<!--课程详情-->
		<div id="content_xiangqing">
				<div class="left">
						<!--左侧标题-->
						<div class="title">
							<ul>
									<li class="title1 active">课程优势</li>
									<li class="title2">免费试听</li>
									<li class="title3">课程简介</li>
									<li class="title4">相关推荐</li>
							</ul>
						</div>
				<script>
					
				</script>
						<!--课程优势  内容部分-->
						<div class="content_kcys">
								<img src="{{ $course->image }}" alt="课程优势" width="780px" height="500px"/>
						</div>

						<!--免费试听  内容部分-->
						<div class="content_mfst dn">
								<div>
										<h3>{{ $course->name }}</h3>
										<!--  <video src="{{ $course->trialvideo }}" alt="课程试听" ></video> -->
										<iframe height=450 width=770 src="{{ $course->trialvideo }}" frameborder=0 allowfullscreen></iframe>
								</div>
						</div>
						<!--课程简介  内容部分-->
						<div class="content_kcjj dn">
								{!! $course->description !!}
						</div>
						<!--相关推荐  内容部分-->
						<div class="content_xgtj dn">
								<h2 class="jpkc ml14">精品课程推荐</h2>
								<!--答题技巧-->
								<ul class="dtjq ml14">
								 @foreach ($courses_recommend as $k => $v)
										<li class="@if($k%3 != 2 ) mr16 @endif"><a href="{{ url("courses/$v->id") }}"><img src="{{ url("$v->cover") }}" alt="课程推荐" width="247" height="144"/><p>{{ $v->name }}&nbsp;&nbsp;&nbsp;￥{{ $v->discount_price }}</p></a></li>
								 @endforeach
								</ul>
								<h2 class="ptjc ml14">配套教材推荐</h2>
								<ul class="ptjctj ml14">
									@foreach ($books_recommend as $k => $v)
										<li class="@if($k%4 != 3 ) mr17 @endif">
											<div>
												<a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }}" alt="教材" width="132" height="204"/></a>
											</div>
											<p><a href="{{ url("books/$v->id") }}">{{ $v->name }}</a></p>
											<p>
												<span class="orange">￥{{ $v->discount_price }}</span>|<del class="gray2">￥{{ $v->price }}</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ url("books/$v->id") }}"><span class="gray3">详情</span></a>&nbsp;<a href="{{ url("cart/books/add/$v->id") }}"><span class="button">购买</span></a>
											</p>
										</li>
									@endforeach										
								</ul>
						</div>
				</div>

				<div class="right1">
						{!! $course->hours_description !!}
				</div>
				<div class="right2">
				        {!! $course->teacher !!}
				</div>
				<div class="right3">
						<a href="#"><img src="/assets/img/spxqy_right3_banner.png" alt="" /></a>
				</div>
		</div>
@endsection		
	
		
		
@section('scripts') 
        <script src="/assets/js/spxqy.js"></script>
        <script type="text/javascript">
           var total = {{ $course->totalprice }};
           var discount =  {{ $course->discount_price }}; 
           //选择全部子科时， 使用总价格和总优惠价格
           function change(){
        	   total_price = 0;
        	   discount_price  = 0;
        	   var isAllSelect = true;
               $('input[name="subitem[]"]').each(function(){ 
                   if($(this).is(':checked')){
                	   total_price += $(this).data('price') ;
                	   discount_price += $(this).data('discount_price') ;                	   
                   }else{
                	   isAllSelect = false;
                   }
               });

               if(isAllSelect){
            	   $('#total_price').html(total);
                   $('#discount_price').val("立即购买 ￥"+discount);  
               }else{
                   $('#total_price').html(total_price);
                   $('#discount_price').val("立即购买 ￥"+discount_price);  
               }             
           }
        
            $('input[name="subitem[]"]').click(function(){
            	change();                
            });


		    $('#order_form').submit(function (ev) { 
			    var select = false;
			    $('input[name="subitem[]"]').each(function(){ 
	                   if($(this).is(':checked')){
	                	   select = true;
	                   }
	             });			    
		    	
		    	if(!select){
    		        alert("请先选择单科，再点击购买");
    		        return false;
    		    }  	
		        return true;
		    });
            
            
        </script>
@stop
