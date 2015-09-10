<?php namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Courses;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
                    $input['orders'] = Order::where($input['stype'], $input['stext'])->orderBy('created_at', 'desc')->simplePaginate(20);
                    break;
                case 'paymode':
                    $input['orders'] = Order::where($input['stype'], $input['svalue'])->orderBy('created_at', 'desc')->simplePaginate(20);
                    break;
                case 'paytime':
                    $cond = $input['svalue'] == 'payed' ? 'whereNotNull' : 'whereNull';
                    $input['orders'] = Order::$cond('paytime')->orderBy('created_at', 'desc')->simplePaginate(20);
                    break;
                case 'item_title':
                    $title = $input['stext'];
                    $input['orders'] = Order::whereHas('orderItems', function($q) use ($title) { $q->where('title', 'like', '%'.$title.'%'); })->orderBy('created_at', 'desc')->simplePaginate(20);
                    break;
                default:
                    $input['orders'] = Order::orderBy('created_at', 'desc')->simplePaginate(20);
                    break;
            }
        }
        else {
            $input['orders'] = Order::orderBy('created_at', 'desc')->simplePaginate(20);
        }

        $input['courses_zx'] = Courses::where('level', 'zhongxue')->where('enable', true)->get();
        $input['courses_xx'] = Courses::where('level', 'xiaoxue')->where('enable', true)->get();
        $input['courses_yr'] = Courses::where('level', 'youer')->where('enable', true)->get();
        $input['books'] = Books::all();
        $input['users'] = User::where('role', 'user')->get();
// dump($input);
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
        $request->session()->put('buyer.id', $request->input('user'));

        return redirect('/order');
    }
    
    public function detail(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();  
        
        return view('admin.orders.orderItems', ['v' => $order]);
    }
    
    public function open(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        
        if(!$order->user->is_reged){
            return new JsonResponse(['success'=>false, 'message' => '用户'.$order->user->name.'未在能力天空注册！']);
        }

        $ablesky= app('Ablesky');
        $ret = $ablesky -> openCourses( $order, 'manual' );
        
        if($ret){
            return new JsonResponse(['success'=>true, 'message' => '开通成功']);
        }else{
            return new JsonResponse(['success'=>false, 'message' => '开通失败,请重试']);  
        }        
    }
    
    public function delete(Request $request, $id)
    {
        $order = Order::where('id', $id)->delete();
        return redirect('/admin/orders');
    }
    
    public function user_search(Request $request)
    {
         $q = $request['q'];
         $users = User::where('name', 'like', '%'.$q.'%') -> orWhere('phone', 'like', '%'.$q.'%') -> get();
         return view('admin.orders.users', ['users' => $users]);
    }
}
