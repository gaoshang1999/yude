<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Courses;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Books;

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
        $course_ids = $request->session()->get('cart.coureses');
        $book_ids = $request->session()->get('cart.books');
        $courses = Courses::whereIn('id', $course_ids)->get();
        $books = Books::whereIn('id', $book_ids)->get();
        
        $total = 0;
        foreach ($courses as $c) {            
            $total +=  $c->totalprice;
        }
        foreach ($books as $c) {
            $total +=  $c->discount_price;
        }

        $data = ['courses'=>$courses, 'books'=>$books, 'total'=>$total];
        return view('order.step1', $data);
    }

    public function step2(Request $request)
    {
        $course_ids = array();
        $book_ids = array();

        foreach ($request->all() as $key => $value) {
            if (starts_with($key, 'check_c')) {
                $num = substr($key, strlen('check_c_'));
                $course_ids[] = $num;
            }else if (starts_with($key, 'check_b')) {
                $num = substr($key, strlen('check_b_'));
                $book_ids[] = $num;
            }
        }

        $items_c = array(); $items_b = array();
        $total = 0;  $count = 0;
        $courses = Courses::whereIn('id', $course_ids)->get();
        $books = Books::whereIn('id', $book_ids)->get();
        foreach ($courses as $c) {
            $c->count = intval($request->input('count_c_' . $c->id));
            $total += $c->count * $c->totalprice;
            $items_c[''. $c->id] = $c->count;
            $count += $c->count;
        }
        foreach ($books as $c) {
            $c->count = intval($request->input('count_b_' . $c->id));
            $total += $c->count * $c->discount_price;
            $items_b[''. $c->id] = $c->count;
            $count += $c->count;
        }
        return view('order.step2', ['courses'=>$courses, 'books'=> $books, 'total'=>$total, 'count'=> $count, 'items_c'=>json_encode($items_c), 'items_b'=>json_encode($items_b)]);
    }

    public function step3(Request $request)
    {
        $data = $request->all();
        $data['orderno'] = '' . date('YmdHis') . (time()%1000);

        $total = 0;
        $itemData = array();
        
        $items_c = json_decode($data['items_c'], true);        
        $courses = Courses::whereIn('id', array_keys($items_c))->get();
        foreach ($courses as $c) {
            $item['snapshot'] = json_encode($c);
            $c->count = $items_c[''.$c->id];
            $total += $c->count * $c->totalprice;
            $item['count'] = $c->count;
            $item['price'] = $c->totalprice;
            $item['title'] = $c->name;
            $item['type'] = "course";
            $itemData[] = $item;
        }
        $items_b = json_decode($data['items_b'], true);
        $books = Books::whereIn('id', array_keys($items_b))->get();
        foreach ($books as $c) {
            $item['snapshot'] = json_encode($c);
            $c->count = $items_b[''.$c->id];
            $total += $c->count * $c->discount_price;
            $item['count'] = $c->count;
            $item['price'] = $c->discount_price;
            $item['title'] = $c->name;
            $item['type'] = "book";
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
