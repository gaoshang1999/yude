<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        $cart_courses = $request->session()->get('cart_coureses', []); 
        $course_ids = array_keys($cart_courses);
        $cart_books = $request->session()->get('cart_books', []);

        $book_ids = array_keys($cart_books);
        
        $courses = Courses::whereIn('id', $course_ids)->get();
        $books = Books::whereIn('id', $book_ids)->get();

        $total = 0;
        foreach ($courses as $c) {                        
            $total +=  $c->computePrice($cart_courses[$c->id]);
        }
        foreach ($books as $c) {
            $total +=  ($c->discount_price * $cart_books[$c->id] );
        }

        $data = ['courses'=>$courses, 'cart_courses' => $cart_courses, 'books'=>$books, 'cart_books'=>$cart_books, 'total'=>$total];
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
            $total +=  $c->computePrice($c->count);
            $items_c[''. $c->id] = $c->count;
            $count += $c->count;
        }
        $books_total = 0;
        $cart_books = $request->session()->pull('cart_books', []);
        foreach ($books as $c) {
            $c->count = intval($request->input('count_b_' . $c->id));
            $total += $c->count * $c->discount_price; 
            $books_total  += $c->count * $c->discount_price; 
            $items_b[''. $c->id] = $c->count;
            $count += $c->count;         

            unset($cart_books[$c->id]);
            $cart_books[$c->id] = $c->count;         
        }
        $request->session()->put('cart_books', $cart_books);
        return view('order.step2', ['courses'=>$courses, 'books'=> $books, 'total'=>$total, 'books_total' =>$books_total, 'count'=> $count, 'items_c'=>$items_c, 'items_b'=>$items_b]);
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
            $total += $c->computePrice($c->count);
            $item['count'] = $c->count;
            $item['price'] = $c->computePrice($c->count);
            $item['title'] = $c->name;
            $item['type'] = "course";
            $itemData[] = $item;
        }
        $items_b = json_decode($data['items_b'], true);
        $books = Books::whereIn('id', array_keys($items_b))->get();
        $books_total = 0;
        foreach ($books as $c) {
            $item['snapshot'] = json_encode($c);
            $c->count = $items_b[''.$c->id];
            $total += $c->count * $c->discount_price;
            $books_total  += $c->count * $c->discount_price;
            $item['count'] = $c->count;
            $item['price'] = $c->discount_price;
            $item['title'] = $c->name;
            $item['type'] = "book";
            $itemData[] = $item;
        }
        //免运费的逻辑，只考虑教材的价格 
        $data['totalprice'] = $total + ( count($books) >0 ?($books_total >=100 ? 0 : config('order.shipping_fee')) : 0);
        $data['user_id'] = $request->session()->get('buyer.id', Auth::user()->id);

        $order = Order::create($data);

        foreach ($itemData as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }
        //从session 中去除已经生成订单课程
        $arr1 = $request->session()->pull('cart_coureses');
        foreach(array_keys($items_c) as $id){
            unset($arr1[$id]);        
        }
        $request->session()->put('cart_coureses', $arr1);
        
        //从session 中去除已经生成订单教材
        $arr1 = $request->session()->pull('cart_books');
        foreach(array_keys($items_b) as $id){
            unset($arr1[$id]);        
        }        
        $request->session()->put('cart_books', $arr1);
        
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
        $paymode = $request->input('paymode');
        if (strcasecmp($paymode, 'alipay') == 0){
            $order = Order::where('orderno', $orderno)->first();
            $alipayWeb = app('AlipayWeb');

            $alipayWeb->setOutTradeNo($order->orderno)
                    ->setTotalFee($order->totalprice)
                    ->setSubject('育德园师课程购买')
                    ->setBody('育德园师课程购买');

            return redirect($alipayWeb->getPayLink());
        }
        else if (strcasecmp($paymode, 'wxpay') == 0){
            return redirect('/wxpay/pay/' . $orderno);
        }
        else if (strcasecmp($paymode, 'bank') == 0){
            $order = Order::where('orderno', $orderno)->first();

            $yzf = app('Yizhifu');
            $yzf->v_ymd = date('Ymd');
            $yzf->v_rcvname = str_pad(substr($order->orderno, -3), 5, '0', STR_PAD_LEFT);
            $yzf->v_rcvaddr = $order->address;
            $yzf->v_rcvtel = $order->phone;
            $yzf->v_rcvpost = $order->postcode;
            $yzf->v_amount = $order->totalprice;
            $yzf->v_ordername = $order->receiver;
            $yzf->v_oid = implode('-', [$yzf->v_ymd, $yzf->v_mid, $yzf->v_rcvname, substr($order->orderno, -9, 6)]);

            return $yzf->buildRequestForm();
        }
        else {
            echo 'no support';
            return;
        }
    }
}
