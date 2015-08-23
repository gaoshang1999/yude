<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Courses;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function step1(Request $request)
    {
        $courseid = 1;
        if (($cid = $request->input('cid'))) {
            $courseid = $cid;
        }
        $data = ['course'=>Courses::where('id', $courseid)->first()];
        return view('order.step1', $data);
    }

    public function step2(Request $request)
    {
        $courseIds = array();
        foreach ($request->all() as $key => $value) {
            if (starts_with($key, 'check')) {
                $num = substr($key, strlen('check_'));
                $courseIds[] = $num;
            }
        }

        $items = array();
        $total = 0;
        $courses = Courses::whereIn('id', $courseIds)->get();
        foreach ($courses as $c) {
            $c->count = intval($request->input('count_' . $c->id));
            $total += $c->count * $c->totalprice;
            $items[''. $c->id] = $c->count;
        }
        return view('order.step2', ['courses'=>$courses, 'total'=>$total, 'items'=>json_encode($items)]);
    }

    public function step3(Request $request)
    {
        $data = $request->all();
        $data['orderno'] = '' . date('YmdHis') . (time()%1000);

        $total = 0;
        $items = json_decode($data['items'], true);
        $itemData = array();
        $courses = Courses::whereIn('id', array_keys($items))->get();
        foreach ($courses as $c) {
            $item['snapshot'] = json_encode($c);
            $c->count = $items[''.$c->id];
            $total += $c->count * $c->totalprice;
            $item['count'] = $c->count;
            $item['price'] = $c->totalprice;
            $item['title'] = $c->name;
            $itemData[] = $item;
        }

        $data['totalprice'] = $total;

        $order = Order::create($data);

        foreach ($itemData as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }
        return redirect('/order/payonline/'.$data['orderno']);
    }

    public function step4()
    {
        return view('order.step4');
    }

    public function payonline($orderno)
    {
        $order = Order::where('orderno', $orderno)->first();
        return view('order.step3', ['order'=>$order]);
    }

    public function topay($orderno, Request $request)
    {
        $order = Order::where('orderno', $orderno)->first();
        $paymode = $request->input('paymode');
        if (strcasecmp($paymode, 'alipay') == 0){
            $alipayWeb = app('AlipayWeb');

            $alipayWeb->setOutTradeNo($order->orderno)
                    ->setTotalFee($order->totalprice)
                    ->setSubject('育德园师课程购买')
                    ->setBody('育德园师课程购买');

            return redirect($alipayWeb->getPayLink());
        }
        else {
            echo 'no support';
            return;
        }
    }
}
