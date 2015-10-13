
 <table class="table ">
      <tbody>
       <tr class="odd">
          <td>订单编号</td> <td>{{ $v->orderno }}</td>
        </tr>
        <tr class="even">
          <td>购买时间</<td> <td>{{ $v->created_at }}</td>
        </tr> <?php $rows = count($v->orderItems); $course = new App\Models\Courses(); ?>
        @for($i=0; $i<$rows; $i++)
        
          <tr><td>产品{{ $i+1 }}-类别</td>  <td>@if($v->orderItems[$i]->isBook()) 教材 @else 课程 @endif </td></tr>
          <tr><td>产品{{ $i+1 }}-名称</td>  <td>{{ $v->orderItems[$i]->title }}</td></tr>
          @if($v->orderItems[$i]->isCourse()) 
             
            @foreach( $course->listSubitemsName($v->orderItems[$i]->count) as $k => $name)
                <tr><td>@if($k==0)包括子科 @endif</td>  <td>{{ $name }}</td></tr>
            @endforeach
          @endif
          
        @endfor
          <tr class="odd"><td>收件人</td>  <td>{{ $v->receiver }}</td></tr>
          <tr class="even"><td>手机号码</td> <td>{{ $v->phone }}</td></tr>           
          <tr class="odd"><td>地址</td> <td>{{ $v->address }}</td></tr>
          <tr class="even"><td>邮编</td>  <td>{{ $v->postcode }}</td></tr>
          
          <tr class="odd"><td>订单总价</td>  <td>{{ $v->totalprice }}</td></tr>
          <tr class="even"><td>付款方式</td> <td>{{ $v->paymodeDesc() }}</td></tr>
          <tr class="odd"><td>订单状态</td> <td>{{ $v->statusDesc() }}</td> </tr>
          <tr><td></td><td></td></tr>
        
      </tbody>
    </table>


  

