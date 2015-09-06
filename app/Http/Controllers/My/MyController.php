<?php namespace App\Http\Controllers\My;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Courses;
use App\Models\Order;
class MyController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function order()
    {
        $data = ['course'=>Courses::where('id', 1)->first()];
        return view('my.orderit', $data);
    }

    public function courses_add(Request $request, $id)
    {
        $cart_coureses = $request->session()->get('cart.coureses', []);
        if(! in_array($id, $cart_coureses)){
            $request->session()->push('cart.coureses', $id);
        }
        return view('front.cart_added');
    }
    
    /**
     * 支持购买多个book
     * @param Request $request
     * @param unknown $id
     * @return \Illuminate\View\View
     */
    public function books_add(Request $request, $id)
    {
        $number = $request->input("number", 1);
        
        $cart_books = $request->session()->pull('cart.books', []);
        unset($cart_books[$id]);
        $cart_books[$id] = $number;
        
        $request->session()->put('cart.books', $cart_books);
        return view('front.cart_added');
    }
    
    public function courses_remove(Request $request, $id)
    {
        $arr1 = $request->session()->pull('cart.coureses');
        $arr2 = array($id);
        $new_ids =  array_diff($arr1,$arr2);

        $request->session()->put('cart.coureses', $new_ids);
        return redirect('/order');
    }
    
    public function books_remove(Request $request, $id)
    {
        $arr1 = $request->session()->pull('cart.books');
//         $arr2 = array($id);
//         $new_ids =  array_diff($arr1,$arr2);
        foreach ($arr1 as $k => $v){
            if($k == $id){
                unset($arr1[$k]);
            }
        }

        $request->session()->put('cart.books', $arr1);
        return redirect('/order');
    }
    
    public function personal()
    {
        $orders = Order::where('phone',  Auth::user()->phone) ->orderBy('created_at', 'desc')-> get();
        return view('front.personal', ['orders' => $orders]);
    }
}
