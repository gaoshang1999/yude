@extends('admin/admin')

{{-- Content --}}
@section('content')
<div class="col-sm-10 col-sm-offset-1 main">
  @include('errors.list')
  <h2 class="page-header">{{ $groups ? '编辑' : '创建新' }}课程组</h2>
  <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/groups/' . ($groups ? 'edit/'.$groups->id : 'add')) }}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label"><span style="color: red">*</span>名称</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="名称" value="{{ old('name', $groups ? $groups->name : '') }}">
      </div>
    </div>

    <div class="form-group">
      <label for="rank" class="col-sm-2 control-label"><span style="color: red">*</span>显示顺序</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="rank" placeholder="显示顺序" min="1"  step="1" value="{{ old('rank', $groups ? $groups->rank : 0) }}">
      </div>
    </div>

    <div class="form-group">
      <label for="summary" class="col-sm-2 control-label">课程组简介</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="summary" id="summary" placeholder="课程组">{{ old('summary', $groups ? $groups->summary : '') }}</textarea>
      </div>
    </div>
    

<hr/>
    <div class="form-group">
      <label for="zx_course" class="col-sm-2 control-label"><span style="color: red">*</span>中学课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="zx_course_name" id ="zx_course_name" placeholder="中学课程" value="{{ old('zx', $groups ? $groups->zx->name : '') }}" readonly> 
        <input type="hidden" class="form-control" name="zx_course" id ="zx_course" value="{{ old('zx_course', $groups ? $groups->zx_course : '') }}"/>
      </div>
      <input type="button" class="btn btn-primary" id="btn_myModal_zx" data-toggle="modal" data-target="#myModal_zx" value="选择"/>
    </div>
    <div class="form-group">
      <label for="xx_course" class="col-sm-2 control-label"><span style="color: red">*</span>小学课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="xx_course_name" id ="xx_course_name" placeholder="小学课程" value="{{ old('xx', $groups ? $groups->xx->name : '') }}" readonly>
        <input type="hidden" class="form-control" name="xx_course" id ="xx_course" value="{{ old('xx_course', $groups ? $groups->xx_course : '') }}"/>
      </div>
     <input type="button" class="btn btn-primary" id="btn_myModal_xx" data-toggle="modal" data-target="#myModal_xx" value="选择"/>
    </div>
    <div class="form-group">
      <label for="yr_course" class="col-sm-2 control-label"><span style="color: red">*</span>幼儿课程</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="yr_course_name" id ="yr_course_name"placeholder="幼儿课程" value="{{ old('yr', $groups ? $groups->yr->name : '') }}" readonly>
        <input type="hidden" class="form-control" name="yr_course" id ="yr_course" value="{{ old('yr_course', $groups ? $groups->yr_course : '') }}"/>
      </div>
        <input type="button" class="btn btn-primary" id="btn_myModal_yr" data-toggle="modal" data-target="#myModal_yr" value="选择"/>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">保存</button> <button type="button" class="btn btn-primary" onclick="javascript :history.back(-1)">返回</button>
      </div>
    </div>
    <input type="hidden"  name="referer" value="{{ Request::header('referer') }}" />
  </form>
  
  <!-- 中学课程选择dialog -->
  <div class="modal fade" id="myModal_zx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">中学课程&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="selectedLabel"></label></h4>
        </div>
        <div class="modal-body">
          <form id="" action="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="courses">
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
                    @foreach ($courses_zx as $v)
                    <tr id="courses_tr_{{ $v->id }}" ondblclick="zx_dbclick_tr({{ $v->id }});">
                      <td><label><input type="radio" name="courses_zx_radio" id="courses_radio_{{ $v->id }}" value="{{ $v->id }}"/>{{ $v->id }}</label></td>
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

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="btn_select_zx">确定</button>
        </div>
      </div>
    </div>
  </div>
  
    <!-- 小学课程选择dialog -->
  <div class="modal fade" id="myModal_xx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">小学课程&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="selectedLabel"></label></h4>
        </div>
        <div class="modal-body">
          <form id="" action="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="courses">
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
                    @foreach ($courses_xx as $v)
                    <tr ondblclick="xx_dbclick_tr({{ $v->id }});">
                      <td><label><input type="radio" name="courses_xx_radio" id="courses_radio_{{ $v->id }}" value="{{ $v->id }}"/>{{ $v->id }}</label></td>
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

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="btn_select_xx">确定</button>
        </div>
      </div>
    </div>
  </div>
  
      <!-- 幼儿课程选择dialog -->
  <div class="modal fade" id="myModal_yr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">小学课程&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="selectedLabel"></label></h4>
        </div>
        <div class="modal-body">
          <form id="" action="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="courses">
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
                    @foreach ($courses_yr as $v)
                    <tr ondblclick="yr_dbclick_tr({{ $v->id }});">
                      <td><label><input type="radio" name="courses_yr_radio" id="courses_radio_{{ $v->id }}" value="{{ $v->id }}"/>{{ $v->id }}</label></td>
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

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="btn_select_yr">确定</button>
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection

@section('scripts')
<script type="text/javascript">

var zx_select_fun = function(){ 
	var selected_radio = $("input[name='courses_zx_radio']:checked");
	var id = selected_radio.val();
	var name = selected_radio.parent().parent().parent().children('td').eq(1).html();
	$('#zx_course_name').val(name);
	$('#zx_course').val(id);
	$('#myModal_zx').modal('hide');
}
                    
$('#btn_select_zx').click(zx_select_fun);                   

function zx_dbclick_tr(id){
$('#courses_radio_'+id).click();
zx_select_fun();
}
                    
var xx_select_fun = function(){ 
	var selected_radio = $("input[name='courses_xx_radio']:checked");
	var id = selected_radio.val();
	var name = selected_radio.parent().parent().parent().children('td').eq(1).html();
	$('#xx_course_name').val(name);
	$('#xx_course').val(id); 
	$('#myModal_xx').modal('hide');
}

$('#btn_select_xx').click(xx_select_fun);

function xx_dbclick_tr(id){
	$('#courses_radio_'+id).click();
	xx_select_fun();
}

var yr_select_fun = function(){ 
	var selected_radio = $("input[name='courses_yr_radio']:checked");
	var id = selected_radio.val();
	var name = selected_radio.parent().parent().parent().children('td').eq(1).html();
	$('#yr_course_name').val(name);
	$('#yr_course').val(id);
	$('#myModal_yr').modal('hide');
}

$('#btn_select_yr').click(yr_select_fun);

function yr_dbclick_tr(id){
	$('#courses_radio_'+id).click();
	yr_select_fun();
}
</script>
@endsection                  
