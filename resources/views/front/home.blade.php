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
				<ul>
					<a href="">
						<li>
							<div class="bottom"><img src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
							<p><b>综合素质材料分析题型答题技巧</b></p>
							<p>8月10日19:30-20:30<br/>主讲：董老师</p>
							<div class="top"><img width="261" src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
						</li>
					</a>
					<a href="">
						<li>
							<div class="bottom"><img src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
							<p><b>综合素质材料分析题型答题技巧</b></p>
							<p>8月10日19:30-20:30<br/>主讲：董老师</p>
							<div class="top"><img width="261" src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
						</li>
					</a>
					<a href="">
						<li>
							<div class="bottom"><img src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
							<p><b>综合素质材料分析题型答题技巧</b></p>
							<p>8月10日19:30-20:30<br/>主讲：董老师</p>
							<div class="top"><img width="261" src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
						</li>
					</a>
					<a href="">
						<li>
							<div class="bottom"><img src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
							<p><b>综合素质材料分析题型答题技巧</b></p>
							<p>8月10日19:30-20:30<br/>主讲：董老师</p>
							<div class="top"><img width="261" src="/assets/img/home_mfcxkc_pic1.jpg"/></div>
						</li>
					</a>
				</ul>
			</div>
			<!--直播课-->
			<div class="content_two dn">
				<ul>
						<li>
								<div>
										<img src="/assets/img/home_zbk_pic1.jpg" />
										<p class="ffyh mt10"><span class="cff3131 mr50 fs18">7月22日</span><span class="c188eee fs24">19:00--20:30</span></p>
										<p class="ffst fs12 mt10"><span class="c858585 mr22">在线直播</span><span class="c00cc99 fwb mr70">免费</span><span class="c868686">直播老师：董老师</span></p>
								</div>
								<a class="zzzb" href="#">正在直播 点击学习</a>
						</li>
						<li>
								<div>
										<img src="/assets/img/home_zbk_pic1.jpg" />
										<p class="ffyh mt10"><span class="cff3131 mr50 fs18">7月22日</span><span class="c188eee fs24">19:00--20:30</span></p>
										<p class="ffst fs12 mt10"><span class="c858585 mr22">在线直播</span><span class="c00cc99 fwb mr70">免费</span><span class="c868686">直播老师：董老师</span></p>
								</div>
								<a class="zzzb" href="#">未开始 敬请期待</a>
						</li>
						<li>
								<div>
										<img src="/assets/img/home_zbk_pic1.jpg" />
										<p class="ffyh mt10"><span class="cff3131 mr50 fs18">7月22日</span><span class="c188eee fs24">19:00--20:30</span></p>
										<p class="ffst fs12 mt10"><span class="c858585 mr22">在线直播</span><span class="c00cc99 fwb mr70">免费</span><span class="c868686">直播老师：董老师</span></p>
								</div>
								<a class="zzzb" href="#">已结束 查看回访</a>
						</li>
				</ul>
				<!--直播预告-->
				<div class="zbyg">
						<h2><a class="ffyh fs16">直播预告</a></h2>
						<p>
								<span class="pnum pnum1"></span><span class="ffst fs14">8月3日</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="ffst fs12">教育知识与能力简答题重点答疑</span></br><span class="ffst fs14">13:20-15:00</span>&nbsp;&nbsp;<span class="ffst fs12">直播教师：董老师</span>
						</p>
						<p>
								<span class="pnum pnum2"></span><span class="ffst fs14">8月3日</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="ffst fs12">教育知识与能力简答题重点答疑</span></br><span class="ffst fs14">13:20-15:00</span>&nbsp;&nbsp;<span class="ffst fs12">直播教师：董老师</span>
						</p>
						<p>
								<span class="pnum pnum3"></span><span class="ffst fs14">8月3日</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="ffst fs12">教育知识与能力简答题重点答疑</span></br><span class="ffst fs14">13:20-15:00</span>&nbsp;&nbsp;<span class="ffst fs12">直播教师：董老师</span>
						</p>
						<p>
								<span class="pnum pnum4"></span><span class="ffst fs14">8月3日</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="ffst fs12">教育知识与能力简答题重点答疑</span></br><span class="ffst fs14">13:20-15:00</span>&nbsp;&nbsp;<span class="ffst fs12">直播教师：董老师</span>
						</p>
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
												<p><span class="orange">{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
												<p><span class="orange">{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
												<p><span class="orange">{{ $v->discount_price }}</span>&nbsp;|&nbsp;<del>￥{{ $v->totalprice }}</del>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <p>{{ $v->name }}<br><span style="color:#f60;">{{  $v->discount_price }}</span><span style="color:#000;">&nbsp;|&nbsp;<del>￥{{ $v->price }}</del></span>&nbsp;<a href="{{ url("books/$v->id") }}" style="color:#a1a1a1;">详情</a> <a href="{{  url("cart/books/add/$v->id") }}"><img src="/assets/img/button_gm.png"></a></p>
                    </li>
                @endforeach
                </ul>
            </div>
</div>
<div class="clear h20"></div>
<!--权威名师团队-->
<div id="qwmstd">
            <div class="teacher">
                <h3></h3>
                <ul>
                    <li>
							<img src="/assets/img/home_teacher_pic1.png" />
							<div class="teacher_1">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;董老师—教育学金牌教师 育德独家金牌讲师,某高校教师。<br/>&nbsp;&nbsp;&nbsp;&nbsp;主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验,曾参与教育学阅卷和…</p>
							</div>	
                    </li>
					<li>
							<img src="/assets/img/home_teacher_pic2.png" />
							<div class="teacher_1">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;董老师—教育学金牌教师 育德独家金牌讲师,某高校教师。<br/>&nbsp;&nbsp;&nbsp;&nbsp;主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验,曾参与教育学阅卷和…</p>
							</div>	
                    </li>
					<li>
							<img src="/assets/img/home_teacher_pic3.png" />
							<div class="teacher_1">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;董老师—教育学金牌教师 育德独家金牌讲师,某高校教师。<br/>&nbsp;&nbsp;&nbsp;&nbsp;主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验,曾参与教育学阅卷和…</p>
							</div>	
                    </li>
					<li>
							<img src="/assets/img/home_teacher_pic4.png" />
							<div class="teacher_1">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;董老师—教育学金牌教师 育德独家金牌讲师,某高校教师。<br/>&nbsp;&nbsp;&nbsp;&nbsp;主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验,曾参与教育学阅卷和…</p>
							</div>	
                    </li>
					<li>
							<img src="/assets/img/home_teacher_pic5.png" />
							<div class="teacher_1">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;董老师—教育学金牌教师 育德独家金牌讲师,某高校教师。<br/>&nbsp;&nbsp;&nbsp;&nbsp;主讲教育学和试讲,教师资格证考试培训国内首批资深专家,熟知国家考试政策,丰富的实战培训经验,曾参与教育学阅卷和…</p>
							</div>	
                    </li>
                </ul>
            </div>
</div>
<div class="clear h20"></div>

@endsection

@section('scripts')

	<script type="text/javascript" src="/assets/js/home.js"></script>
@endsection

