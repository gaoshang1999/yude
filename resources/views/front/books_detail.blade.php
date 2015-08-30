@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂-教材详情页 @stop

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
										<img src="{{ url("$v->cover") }}" width="182px" height="283px"/>
								</div>
								<p>
										<a class="active"><img src="{{ url("$v->cover") }}"  /></a>
										<a><img src="{{ url("$v->cover2") }}" /></a>
										<a><img src="{{ url("$v->cover3") }}" /></a>
										<a><img src="{{ url("$v->cover4") }}" /></a>
								</p>
						</div>
						<div class="right">
							<h1>{{ $v->name }}<span>&nbsp;单独购书包含邮费（到付）<b>报班赠送教材</b></span></h1>
							<p>{{ $v->summary }}

							</p>
							<form action="{{ url("cart/books/add/$v->id") }}" method="get">
							<span>定价 ￥</span><span id="jcxqy_price">{{ $v->discount_price }}</span>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;    
							<a>购买数量</a>
							<span id="minus">-</span><input type="text" name="number" class="number" value="1" readonly="readonly" /><span id="plus">+</span><br/>
							<!--不要在前台提交价钱-->
							<input type="submit" id="jcxqy_buy" value="立即购买 ￥{{ $v->discount_price }}" />
							</form>

						</div>
				</div>
		</div>		
		<!--教材详情-->
		<div id="content_xiangqing">
				<div class="part_one">
						<img src="{{ $v->image }}" alt="教材特色" width="1186px" height="607px"/>
				</div>
				<div class="part_two">
						<div class="left">
								<h3>章节目录</h3>
								<div class="neirong">
										<p>
                                            {!! $v->description !!}
										</p>
										<div class="button dn">
											显示全部信息&nbsp;<img src="/assets/img/jcxqy_ico_2.png"/>
										</div>
								</div>

						</div>

						<div class="right">
								<div class="right_1">
									<h4>组合推荐</h4>
									<ul>
										<li>
											<div><img src="/assets/img/spxqy_ptjc.png" /></div>
											<p>
												教育知识与能力<br/>
												<span class="orange">39.00</span>|<del>￥53.00</del>
												&nbsp;
												<a href="#">详情</a>
												<a href="#" class="goumai">购买</a>
											</p>
										</li>
										<li>
											<div><img src="/assets/img/spxqy_ptjc.png" /></div>
											<p>
												教育知识与能力<br/>
												<span class="orange">39.00</span>|<del>￥53.00</del>
												&nbsp;
												<a href="#">详情</a>
												<a href="#" class="goumai">购买</a>
											</p>
										</li>
									</ul>
								</div>

								<div class="right_2">
									<h4>课程推荐</h4>
									<ul>
											<li>
												<a href="#">
													<div><img src="/assets/img/spxqy_tjkc.jpg" /></div>
													<p>小学真题详解班  ￥386.00</p>
												</a>
											</li>
											<li>
												<a href="#">
													<div><img src="/assets/img/spxqy_tjkc.jpg" /></div>
													<p>小学真题详解班  ￥386.00</p>
												</a>
											</li>
											<li>
												<a href="#">
													<div><img src="/assets/img/spxqy_tjkc.jpg" /></div>
													<p>小学真题详解班  ￥386.00</p>
												</a>
											</li>
											<li>
												<a href="#">
													<div><img src="/assets/img/spxqy_tjkc.jpg" /></div>
													<p>小学真题详解班  ￥386.00</p>
												</a>
											</li>
					
									</ul>
								</div>
						</div>

				</div>
		</div> 
		<div class="clear"></div>
@endsection				
		
		
		
 

@section('scripts') 
<script>
		$("#content_jianjie .left p img").click(function(){
			$(this).parent().addClass("active").siblings().removeClass("active");
			$("#content_jianjie .left .pic img").attr("src",this.src);
		});
	</script>
	<script>
		if($("#content_xiangqing .part_two .left p").height() >= 575){
				$("#content_xiangqing .part_two .left .button").removeClass('dn');
		}

		$("#content_xiangqing .part_two .left .button").toggle(function(){
				$(this).html("显示部分信息&nbsp;<img src='/assets/img/jcxqy_ico_1.png'/>");
				$("#content_xiangqing .part_two .left .neirong").height("auto");
				},
				function(){
						$(this).html("显示全部信息&nbsp;<img src='/assets/img/jcxqy_ico_2.png'/>");
						$("#content_xiangqing .part_two .left .neirong").height(569);

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
        <script src="/assets/js/jcxqy.js"></script>
@endsection
