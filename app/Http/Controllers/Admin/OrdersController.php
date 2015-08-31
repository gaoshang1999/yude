<?php namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Courses;
use App\Models\Books;

class OrdersController extends Controller
{
    public function __construct()
    {
        
    }

    public function orders(Request $request)
    {
        $input = $request->all();
        if (isset($input['stype']) && (!empty($input['stext']) || !empty($input['svalue']))) {
            switch ($input['stype']) {
                case 'phone':
                case 'orderno':
                    $input['orders'] = Order::where($input['stype'], $input['stext'])->simplePaginate(20);
                    break;
                case 'paymode':
                    $input['orders'] = Order::where($input['stype'], $input['svalue'])->simplePaginate(20);
                    break;
                case 'paytime':
                    $cond = $input['svalue'] == 'payed' ? 'whereNotNull' : 'whereNull';
                    $input['orders'] = Order::$cond('paytime')->simplePaginate(20);
                    break;
                case 'item_title':
                    $title = $input['stext'];
                    $input['orders'] = Order::whereHas('orderItems', function($q) use ($title) { $q->where('title', 'like', '%'.$title.'%'); })->simplePaginate(20);
                    break;
                default:
                    $input['orders'] = Order::simplePaginate(20);
                    break;
            }
        }
        else {
            $input['orders'] = Order::simplePaginate(20);
        }

        $input['courses'] = Courses::where('enable', true)->get();
        $input['books'] = Books::all();

        return view('admin.orders.list', $input);
    }

    public function neworder(Request $request)
    {
        $courses = $request->input('courses');
        $books = $request->input('books');

        if ($courses) {
            $request->session()->put('cart.coureses', $courses);
        }
        if ($books) {
            $request->session()->put('cart.books', $books);
        }

        return redirect('/order');
    }
}
