<?php namespace App\Http\Controllers\My;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Courses;

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
        $request->session()->push('cart.coureses', $id);
        return view('front.cart_added');
    }
    
    public function books_add(Request $request, $id)
    {
        $request->session()->push('cart.books', $id);
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
        $arr2 = array($id);
        $new_ids =  array_diff($arr1,$arr2);

        $request->session()->put('cart.books', $new_ids);
        return redirect('/order');
    }
    
    public function personal()
    {
        return view('front.personal');
    }
}
