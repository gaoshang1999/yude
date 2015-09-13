@extends('front.app')

{{-- Web site Title --}}
@section('title') 园师课堂  @stop

@section('styles') 
        <link href="/assets/css/home.css" rel="stylesheet" type="text/css" /> 
@stop

{{-- Content --}}
@section('content')	
		<!--登录、注册部分 引用结束-->	
<div class="clearfloat"></div>		
<!--banner 轮播图 开始-->		
        <div id="carousel-example-generic" style="margin-top:-20px" class="carousel slide"  data-ride="carousel">
  			<!-- Indicators -->
			  <ol class="carousel-indicators">
			  				    	<li data-target="#carousel-example-generic" data-slide-to="0"  class="active"  ></li>
			    			    	<li data-target="#carousel-example-generic" data-slide-to="1"  ></li>
			    			    	<li data-target="#carousel-example-generic" data-slide-to="2"  ></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			  			<div class="item  active ">
									<a href="#" target="_blank"><img style="width:100%" src="/assets/img/home_banner1.jpg" alt="园师课堂"></a>

					    </div>
					  	<div class="item ">
									<a href="#" target="_blank"><img style="width:100%" src="/assets/img/home_banner2.jpg" alt="园师课堂"></a>

					    </div>
					  	<div class="item ">
									<a href="#" target="_blank"><img style="width:100%" src="/assets/img/home_banner3.jpg" alt="园师课堂"></a>

					    </div>
				</div>
		</div>
<!--banner 轮播图 结束-->			
<div class="clearfloat"></div>
<div class="clear h20"></div>
<!--免费畅学课程-->
<div id="mfcxkc">
	<div class="title">
			<div class="title1"></div>
			<ul>
					<li class="lihover">公开课</li>
					<li>直播课</li>
			</ul>
			<a class="more" href="">更多>></a>
	</div>


		<div class="content">
			<!--公开课-->
			<div class="content_one">
                 @include('front.home.open')			
			</div>
			<!--直播课-->
			<div class="content_two dn">
			      @include('front.home.live')	
				<!--直播预告-->
				<div class="zbyg">
				  @include('front.home.forecast')	
				</div>
			</div>
      </div>
</div>
		<div class="clear"></div>
<!--精彩视频课程-->
<div id="jcspkc">
		<!--按级别分类  开始-->			
		<div id="content2">
				<div class="jibie_title" >
						<img src="/assets/img/splby_jcspkc.png" />
						<ul>
								<li id="jb_zhongxue" class="hbb"><a href="#">中学</a></li>
								<li id="jb_xiaoxue"><a href="#">小学</a></li>
								<li id="jb_youer"><a href="#">幼儿</a></li>
						</ul>
						<a class="more" href="{{ url("courses/lists") }}">更多课程</a>
				</div>
				<div class="clear"></div>
				
				<div class="jb_zx" id="content2_zx">
				@foreach ($courses_zx ->all() as $v)
						<!--级别分类：中学课程1-->
						<div class="jibie">
								<div class="jibie_1">
										<div class="jibie_1_1">
												<img src="{{ url("$v->cover") }}" alt="中学课程" width="275" height="160"/>
												<div><span>@if($v->kind == "bishi") 笔试 @elseif($v->kind == "mianshi") 面试 @endif 课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
										   <form action="{{url("cart/courses/add/$v->id") }}" method="get">
												<p>{{ $v->name }}</p>
												<p><span class="orange">￥{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="#" class="gray fs12"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
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
												<img src="{{ url("$v->cover") }}" alt="小学课程" width="275" height="160"/>
												<div><span>@if($v->kind == "bishi") 笔试 @elseif($v->kind == "mianshi") 面试 @endif 课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
										   <form action="{{url("cart/courses/add/$v->id") }}" method="get">											
												<p>{{ $v->name }}</p>
												<p><span class="orange">￥{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="#" class="gray fs12"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
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
												<div><span>@if($v->kind == "bishi") 笔试 @elseif($v->kind == "mianshi") 面试 @endif 课程</span><span>共计{{ $v->hours }}课时</span></div>
										</div>
										<div class="jibie_1_2">
										 <form action="{{url("cart/courses/add/$v->id") }}" method="get">					
												<p>{{ $v->name }}</p>
												<p><span class="orange">￥{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a href="#" class="gray fs12"><img src="/assets/img/splby_ico1.jpg" />&nbsp;试听</a>&nbsp;
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
		<!--按级别分类 结束-->		
</div>
<div class="clear h20"></div>
<!--独家出版教材-->
<div id="djcbjc">

            <div class="jclby_zx">
                <h3></h3> 
                <a class="more" style="float:right; margin-top:-15px;  margin-right:18px; color:#a5a5a5;" href="{{ url("books/lists") }}">更多教材</a>
                <ul>
                @foreach ($books ->all() as $v)
                    <li>
                    <div><a href="{{ url("books/$v->id") }}"><img src="{{ url("$v->cover") }} " width="132" height="205" /></a></div>
                        <p>{{ $v->name }}<br><span style="color:#f60;">￥{{  $v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="{{ url("books/$v->id") }}" style="color:#a1a1a1;">详情</a> <a href="{{  url("cart/books/add/$v->id") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>
                @endforeach
                </ul>
            </div>
</div>
<div class="clear h20"></div>
<!--权威名师团队-->
<div id="qwmstd">
            <div class="teacher">
@include('front.home.teacher')
            </div>
</div>
<div class="clear h20"></div>

@endsection

@section('scripts')
    <script src="/assets/js/jquery-2.1.4.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/js/home.js"></script>
@endsection

