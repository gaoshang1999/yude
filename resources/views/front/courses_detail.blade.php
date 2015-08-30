@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂-课程详情页 @stop

@section('styles') 
        <link href="/assets/css/spxqy.css" rel="stylesheet" type="text/css" /> 
@stop

{{-- Content --}}
@section('content')
		
		<!--视频简介-->
		<div id="content_jianjie">
				<!--图片简介-->
				<div class="spjj">
						<div class="pic"><img src="{{ url("$v->cover") }}" width="440px" height="256px"/></div>
				
						<!--文字简介-->
						<div class="wenzi">
								<h1>{{ $v->name }}</h1>
								<p>{{ $v->summary }}</p>
								<form action="{{ url("cart/courses/add/$v->id") }}" method="get">
								<p><input type="submit" title="立即购买" value="立即购买 ￥{{ $v->totalprice }}"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="fz24 gray">原价&nbsp;<del>￥{{ $v->totalprice }}</del></span> </p>
								<p class="p3">可选单科&nbsp;&nbsp;&nbsp;&nbsp;
								@if($v->level == "zhongxue")
										<label><input type="checkbox" name="buy" value="" />&nbsp;教育知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value=""/>&nbsp;学科知识与能力</label>
								@elseif($v->level == "xiaoxue")
										<label><input type="checkbox" name="buy" value="" />&nbsp;教育教学知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;
								@elseif($v->level == "youer")
										<label><input type="checkbox" name="buy" value="" />&nbsp;保教知识与能力</label>&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="buy" value="" />&nbsp;综合素质</label>&nbsp;&nbsp;&nbsp;								
								@endif
								</p>
								<p class="p4">已有{{ $v->buytimes }}人购买该课程</p>
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
								<img src="{{ $v->image }}" alt="课程优势" width="780px" height="500px"/>
						</div>

						<!--免费试听  内容部分-->
						<div class="content_mfst dn">
								<div>
										<h3>中学协议金牌保过班</h3>
										<video src="{{ $v->trialvideo }}" alt="课程试听" ></video>
								</div>
						</div>
						<!--课程简介  内容部分-->
						<div class="content_kcjj dn">
								{!! $v->description !!}
						</div>
						<!--相关推荐  内容部分-->
						<div class="content_xgtj dn">
								<h2 class="jpkc ml14">精品课程推荐</h2>
								<!--答题技巧-->
								<ul class="dtjq ml14">
										<li class="mr16"><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
										<li class="mr16"><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
										<li><a href="#"><img src="/assets/img/spxqy_tjkc.jpg" alt="课程推荐" /><p>小学真题详解班&nbsp;&nbsp;&nbsp;￥386.00</p></a></li>
								</ul>
								<h2 class="ptjc ml14">配套教材推荐</h2>
								<ul class="ptjctj ml14">
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li class="mr17">
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
										<li>
											<div>
												<img src="/assets/img/spxqy_ptjc.png" alt="教材">
											</div>
											<p>教育知识与能力</p>
											<p>
												<span class="orange">39.00</span>|<del class="gray2">￥53.00</del>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="gray3">详情</span></a>&nbsp;<a href="#"><span class="button">购买</span></a>
											</p>
										</li>
								</ul>
						</div>
				</div>

				<div class="right1">
						{!! $v->hours_description !!}
				</div>
				<div class="right2">
				        {!! $v->teacher !!}
				</div>
				<div class="right3">
						<a href="#"><img src="/assets/img/spxqy_right3_banner.png" alt="" /></a>
				</div>
		</div>
@endsection		
	
		
		
@section('scripts') 
        <script src="/assets/js/spxqy.js"></script>
@stop
