@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂-课程列表页 @stop

@section('styles') 
        <link href="/assets/css/splby.css" rel="stylesheet" type="text/css" /> 
@stop

{{-- Content --}}
@section('content')
		<div class="clear"></div>
        <!--------------------------------------顶部banner开始------------------------------------------>		
		<div id="banner">
			<div>
				<a href="#"><img src="/assets/img/splby_banner1.jpg" /></a>
				<div id="splby_button_1"><div id="splby_button_11"></div><div id="splby_button_12"></div></div>
			</div>
		</div>
        <!--------------------------------------顶部banner结束------------------------------------------>
		<div class="clear"></div>
        <!--------------------------------------视频正文开始---------------------------------------------->		
		<div id="content">
			<!--按类型分 课程1-->
			@foreach ($groups ->all() as $k => $g) <?php $v = $g->zx ? $g->zx : ($g->xx ?$g->xx: $g->yr); /*默认展示组中的中学课程*/?>
			<div class="kelei @if($k%3 != 2 ) mr30 @endif">
					<div class="kelei_1">
							<a href="{{ url("courses/$v->id") }}"><img src="{{ url("$v->cover") }} " alt="课程图片"/></a>
							<div>
									<h2>{{ $v->name }}<br/>@if($v->kind == "bishi")笔试@elseif($v->kind == "mianshi")面试@endif课程</h2>
									<p class="gray">{{ $v->summary }}</p>
							</div>
					</div>
					<form action="{{ url("cart/courses/add/") }}" method="get" id="form_group_{{$g->id}}">
							<p class="kelei_2 fs12">
									<input type="radio" name="group_{{$g->id}}" value="{{ $g->zx->id }}" class="radio" id="course_{{ $g->zx->id }}" /><label for="course_{{ $g->zx->id }}" class="gray">&nbsp;&nbsp;中学</label>&nbsp;
									<input type="radio" name="group_{{$g->id}}" value="{{ $g->xx->id }}" class="radio" id="course_{{ $g->xx->id }}" /><label for="course_{{ $g->xx->id }}" class="gray">&nbsp;&nbsp;小学</label>&nbsp;
									<input type="radio" name="group_{{$g->id}}" value="{{ $g->yr->id }}" class="radio" id="course_{{ $g->yr->id }}" /><label for="course_{{ $g->yr->id }}" class="gray">&nbsp;&nbsp;幼儿</label>&nbsp;
									<span class="orange fs12">￥</span><span class="orange fs21">{{ $v->discount_price }}</span>&nbsp;&nbsp;&nbsp;
									<a href="{{ $v->trialvideo }}" class="orange fz12" target="_blank"><img src="/assets/img/splby_ico.jpg" alt="试听"/>&nbsp;试听</a>&nbsp;&nbsp;&nbsp;
									<input type="button" id="group_{{$g->id}}" value='购买' class="button fz12" onclick="javasrcipt:submitOrder({{$g->id}})"/>
							</p>
					</form>
			</div>
			@endforeach
				

		</div>
		<div class="clear"></div>
		<!--按级别分类  开始-->			
		<div id="content2" class="dn">
				<div class="jibie_title" >
						<img src="/assets/img/splby_jcspkc.png" />
						<ul>
								<li id="jb_zhongxue" class="hbb"><a href="#">中学</a></li>
								<li id="jb_xiaoxue"><a href="#">小学</a></li>
								<li id="jb_youer"><a href="#">幼儿</a></li>
						</ul>
				</div>
				<div class="clear"></div>
				
				<div class="jb_zx" id="content2_zx">
						@foreach ($courses_zx ->all() as $v)
						<!--级别分类：中学课程1-->
						<div class="jibie">
								<div class="jibie_1">
										<div class="jibie_1_1">
												<img src="{{ url("$v->cover") }} " alt="中学课程" width="275" height="160"/>
												<div><span>@if($v->kind == "bishi")笔试@elseif($v->kind == "mianshi")面试@endif课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
												<form action="{{url("cart/courses/add/$v->id") }}" method="get">
												<p>{{ $v->name }}</p>
												<p><span class="orange">{{ $v->totalprice }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="{{ $v->trialvideo }}" class="gray fs12" target="_blank"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
												<input type="submit" value='购买' class="button fz12"/></p>
												</form>
										</div>
								</div>
								<div class="jibie_2">
									<p>{{ $v->summary }}</p>
									<a href="{{ url("courses/$v->id") }}">查看课程详情</a>
								</div>	
						</div>
						@endforeach
						
				</div>
				
				<div class="jibie_xx dn" id="content2_xx">
						@foreach ($courses_xx ->all() as $v)
						<!--级别分类：小学课程1-->
						<div class="jibie">
								<div class="jibie_1">
										<div class="jibie_1_1">
												<img src="{{ url("$v->cover") }} " alt="小学课程" width="275" height="160"/>
												<div><span>@if($v->kind == "bishi")笔试@elseif($v->kind == "mianshi")面试@endif课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
												<form action="{{url("cart/courses/add/$v->id") }}" method="get">
												<p>{{ $v->name }}</p>
												<p><span class="orange">{{ $v->totalprice }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="{{ $v->trialvideo }}" class="gray fs12" target="_blank"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
												<input type="submit" value='购买' class="button fz12"/></p>
												</form>
										</div>
								</div>
								<div class="jibie_2">
									<p>{{ $v->summary }}</p>
									<a href="{{ url("courses/$v->id") }}">查看课程详情</a>
								</div>	
						</div>
					    @endforeach								
				
				</div>
				<div class="jibie_ye dn"  id="content2_ye">
						@foreach ($courses_yr ->all() as $v)
						<!--级别分类：幼儿课程1-->
						<div class="jibie">
								<div class="jibie_1">
										<div class="jibie_1_1">
												<img src="{{ url("$v->cover") }}" alt="幼儿课程" width="275" height="160"/>
												<div><span>@if($v->kind == "bishi")笔试@elseif($v->kind == "mianshi")面试@endif课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
												<form action="{{url("cart/courses/add/$v->id") }}" method="get">
												<p>{{ $v->name }}</p>
												<p><span class="orange">{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="{{ $v->trialvideo }}" class="gray fs12" target="_blank"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
												<input type="submit" value='购买' class="button fz12"/></p>
												</form>
										</div>
								</div>
								<div class="jibie_2">
									<p>{{ $v->summary }}</p>
									<a href="{{ url("courses/$v->id") }}">查看课程详情</a>
								</div>	
						</div>
					    @endforeach					
				</div>				
		</div>	

@endsection

@section('scripts')
	<script type="text/javascript" src="/assets/js/splby.js"></script>
	<script type="text/javascript">
		 function submitOrder(gid){
			var selected_radio = $("input[name='group_"+gid+"']:checked");
			var id = selected_radio.val();


		    var form = $('#form_group_'+gid);
		    form.attr('action', form.attr('action')+"/"+id);
		    form.submit();

         }
	</script>
@endsection
