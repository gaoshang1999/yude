<?php
namespace  App\Http\Controllers\Front;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Books;

class HomeController extends Controller
{
    public function __construct()
    {
    }


    public function home()
    {
        $books = Books::orderBy('buytimes', 'desc')->take(8) ->get();
        
        $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get() ;
        $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        
        $data = ['books' => $books, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
        return view('front.home', $data);
    }
    

}

?>