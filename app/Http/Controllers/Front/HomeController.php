<?php
namespace  App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Books;
use App\Models\Html;
use Illuminate\Support\Facades\Auth;
use Storage;

class HomeController extends Controller
{
    public function __construct()
    {
    }


    public function home(Request $request)
    {
        if($request->exists("e") && Auth::user() && Auth::user() -> isAdmin())
        {
            return redirect('/admin/home/edit');
        }
        
        $books = Books::orderBy('buytimes', 'desc')->take(6) ->get();
        
        $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get() ;
        $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc')->take(8) ->get();
        
        $data = ['books' => $books, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
        return view('front.home.home', $data);
    }
    
    const HTML_KEY_banner = 'home.banner';
    const HTML_KEY_free = 'home.free';
    const HTML_KEY_teacher = 'home.teacher';
    
    public function html_edit(Request $request)
    {
//         $dir = __DIR__.'/../../../../';
//         $banner_path = $dir."resources/views/front/home/banner.blade.php";
//         $free_path = $dir."resources/views/front/home/free.blade.php";
//         $teacher_path = $dir."resources/views/front/home/teacher.blade.php";        

//         if ($request->isMethod('post')) {  
//             $banner = $request['banner'];
//             $free = $request['free'];
//             $teacher = $request['teacher'];

//             file_put_contents($banner_path, $banner);
//             file_put_contents($free_path, $free);
//             file_put_contents($teacher_path, $teacher);
            
//             return redirect('/index');
            
//         }else{      
//             return view('admin.home.html_edit', ['banner' => file_get_contents($banner_path), 'free' => file_get_contents($free_path),  'teacher' => file_get_contents($teacher_path)]);
//         }

        
        $banner_html = Html::where('key', self::HTML_KEY_banner) -> first();
        $free_html = Html::where('key', self::HTML_KEY_free) -> first();
        $teacher_html = Html::where('key', self::HTML_KEY_teacher) -> first();
        
        if ($request->isMethod('post')) {
            $banner = $request['banner'];
            $free = $request['free'];
            $teacher = $request['teacher'];
        
            $banner_html->html = $banner ;
            $banner_html->save();
            
            $free_html->html = $free ;
            $free_html->save();
            
            $teacher_html->html = $teacher ;
            $teacher_html->save();
            
            $this->unCacheView();
        
            return redirect('/index');
        
        }else{
            return view('admin.home.html_edit', ['banner' => $banner_html->html, 'free' => $free_html->html,  'teacher' =>$teacher_html->html ]);
        }        
    }

}

?>