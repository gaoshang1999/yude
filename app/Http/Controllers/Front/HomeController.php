<?php
namespace  App\Http\Controllers\Front;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;
use Storage;

class HomeController extends Controller
{
    public function __construct()
    {
    }


    public function home(Request $request)
    {
        
//         dump(  $request->has("e") );

        if($request->has("e") && Auth::user() && Auth::user() -> isAdmin())
        {
            return redirect('/admin/home/edit');
        }
        
        $books = Books::orderBy('buytimes', 'desc')->take(8) ->get();
        
        $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get() ;
        $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        
        $data = ['books' => $books, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
        return view('front.home.home', $data);
    }
    
    
    public function html_edit(Request $request)
    {
        $dir = __DIR__.'/../../../../';
        $open_path = $dir."resources/views/front/home/open.blade.php";
        $live_path = $dir."resources/views/front/home/live.blade.php";
        $forecast_path = $dir."resources/views/front/home/forecast.blade.php";
        $teacher_path = $dir."resources/views/front/home/teacher.blade.php";
        

        if ($request->isMethod('post')) {
            $open = $request['open'];
            $live = $request['live'];
            $forecast = $request['forecast'];
            $teacher = $request['teacher'];
            
            file_put_contents($open_path, $open);
            file_put_contents($live_path, $live);
            file_put_contents($forecast_path, $forecast);
            file_put_contents($teacher_path, $teacher);
            
            return redirect('/index');
            
        }else{      
            return view('admin.home.html_edit', ['open' => file_get_contents($open_path), 'live' => file_get_contents($live_path), 'forecast' => file_get_contents($forecast_path), 'teacher' => file_get_contents($teacher_path)]);
        }
        
    }

}

?>