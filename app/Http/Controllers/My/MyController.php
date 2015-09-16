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
        $c = Courses::where('id', $id)->first();
                
        $subitem = $request->input("subitem", $c->defaultSubitem());

        $cart_coureses = $request->session()->pull('cart_coureses', []);
        unset($cart_coureses[$id]);
        $cart_coureses[$id] = $c-> encodeSubitems($subitem);

        $request->session()->put('cart_coureses', $cart_coureses);
        return view('front.cart_added', ["from"=>"courses"]);
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
        
        $cart_books = $request->session()->pull('cart_books', []);
        unset($cart_books[$id]);
        $cart_books[$id] = $number;
        
        $request->session()->put('cart_books', $cart_books);
        return view('front.cart_added', ["from"=>"books"]);
    }
    
    public function courses_remove(Request $request, $id)
    {
        $arr1 = $request->session()->pull('cart_coureses');        
        unset($arr1[$id]);

        $request->session()->put('cart_coureses', $arr1);
        return redirect('/order');
    }
    
    public function books_remove(Request $request, $id)
    {
        $arr1 = $request->session()->pull('cart_books');
        unset($arr1[$id]);

        $request->session()->put('cart_books', $arr1);
        return redirect('/order');
    }
    
    public function personal()
    {
        $orders = Order::where('user_id',  Auth::user()->id) ->orderBy('created_at', 'desc')-> get();
        return view('front.personal', ['orders' => $orders]);
    }
    
    public function delete(Request $request, $id)
    {
        Order::where('id', $id)->where('user_id', Auth::user()->id)->delete();
        return redirect('/my/profile');
    }
}
