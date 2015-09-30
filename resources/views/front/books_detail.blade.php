@extends('front.app')

{{-- Web site Title --}}
@section('title') {{ $book->pagetitle }} @stop
@section('meta_keywords') 
    <meta name="keywords" content="{{ $book->pagekeyword }}"/>
@stop
@section('meta_description') 
    <meta name="description" content="{{ $book->pagedescription }}"/>
@stop

@section('styles') 
<link href="/assets/css/jcxqy.css" rel="stylesheet" type="text/css" />  
@stop
    
{{-- Content --}}
@section('content')		
		<!--教材简介-->
		<div id="content_jianjie">
				<!--教材简介内容居中-->
				<div class="jcjj">
						<div class="left">
								<div class="pic">
										<img src="{{ url("$book->cover") }}" width="182px" height="283px"/>
								</div>
								<p>
										<a class="active"><img src="{{ url("$book->cover") }}"  /></a>
										<a><img src="{{ url("$book->cover2") }}" /></a>
										<a><img src="{{ url("$book->cover3") }}" /></a>
										<a><img src="{{ url("$book->cover4") }}" /></a>
								</p>
						</div>
						<div class="right">
							<h1>{{ $book->name }}<span>&nbsp;单独购买教材满<b>100免运费</b></span></h1>
							<p>{{ $book->summary }}

							</p>
							<form action="{{ url("cart/books/add/$book->id") }}" method="post">     <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<span>定价 ￥</span><span id="jcxqy_price">{{ $book->discount_price }}</span>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;    
							<a>购买数量</a>
							<span id="minus">-</span><input type="text" name="number" class="number" value="1" readonly="readonly" /><span id="plus">+</span><br/>
							<!--不要在前台提交价钱-->
							<input type="submit" id="jcxqy_buy" value="立即购买 ￥{{ $book->discount_price }}" />
							</form>

						</div>
				</div>
		</div>		
		<!--教材详情-->
		<div id="content_xiangqing">
				<div class="part_one">
						<img src="{{ $book->image }}" alt="教材特色" width="1184px" height="604px"/>
				</div>
				<div class="part_two">
						<div class="left">
								<h3>章节目录</h3>
								<div class="neirong"  id="neirong">
										<p id="book_description">
                                            {!! $book->description !!}
										</p>
										<div class="button dn" id="detail_botton">
											显示全部信息&nbsp;<img  src="/assets/img/jcxqy_ico_2.png"/>
										</div>
								</div>

						</div>

						<div class="right">
								<div class="right_1">
									<h4>组合推荐</h4>
									<ul>
									@foreach ($books_recommend as $k => $v)
										<li>
											<div><a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }}" width="132" height="204"/></a></div>
											<p>
												<a href="{{ url("books/$v->id") }}">{{ $v->name }}</a><br/>
												<span class="orange">￥{{ $v->discount_price }}</span>|<del>￥{{ $v->price }}</del>
												&nbsp;
												<a href="{{ url("books/$v->id") }}">详情</a>
												<a href="{{ url("cart/books/add/$v->id") }}" class="goumai">购买</a>
											</p>
										</li>
									 @endforeach	

									</ul>
								</div>

								<div class="right_2">
									<h4>课程推荐</h4>
									<ul>
									@foreach ($courses_recommend as $k => $v)
											<li>
												<a href="{{ url("courses/$v->id") }}">
													<div><img src="{{ url("$v->cover") }}" width="247" height="144"/></div>
													<p>{{ $v->name }}  ￥{{ $v->discount_price }}</p>
												</a>
											</li>
								   @endforeach										

					
									</ul>
								</div>
						</div>

				</div>
		</div> 
		<div class="clear"></div>
@endsection				
		
		
		
 

@section('scripts') 
     <script src="/assets/js/jcxqy.js"></script>
     
	<script type=text/javascript>
		$("#content_jianjie .left p img").click(function(){
			$(this).parent().addClass("active").siblings().removeClass("active");
			$("#content_jianjie .left .pic img").attr("src",this.src);
		});
 
		if($("#book_description").height() >= 575){
				$("#detail_botton").removeClass('dn'); 
		}

		$("#detail_botton").toggle(
				function(){  
        				$(this).html("显示部分信息&nbsp;<img src='/assets/img/jcxqy_ico_1.png'/>");
        				$("#neirong").height("auto"); 
//         				alert(11);
				},
				
				function(){					 
						$(this).html("显示全部信息&nbsp;<img src='/assets/img/jcxqy_ico_2.png'/>");
						$("#neirong").height(569);  
// 						alert(2222);
				}
		);
	</script>
	<script type=text/javascript>
		$("#minus").click(function(){										
					var n = parseInt($(".number").attr("value"));
					if(n>1){n -=1};
					$(".number").attr("value",n);
					var p=parseFloat($("#jcxqy_price").text());
					var num = new Number(p*n);
					var v = "立即购买 ￥"+num.toFixed(2);
					$("#jcxqy_buy").attr("value",v);
		});
		$("#plus").click(function(){
					var n = parseInt($(".number").attr("value"));
					if(n<199){n +=1};
					$(".number").attr("value",n);
					var p=parseFloat($("#jcxqy_price").text());
					var num = new Number(p*n);
					var v = "立即购买 ￥"+num.toFixed(2);
					$("#jcxqy_buy").attr("value",v);
		});	
	</script>
   
@endsection
