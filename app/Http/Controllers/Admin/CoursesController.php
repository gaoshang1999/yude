<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    public function courses()
    {        
        $data = ['courses' => Courses::orderBy('created_at', 'desc')->simplePaginate(20)];
        return view('admin.courses.list', $data);
    }
    
    public function search(Request $request)
    {
        $q = $request['q'];
        $field = $request['field'];
    
        if($field == 'level'){
            if($q == '中学') { $q = 'zhongxue';}
            else if($q == '小学') { $q = 'exiaoxue';}
            else if($q == '幼儿') { $q = 'youer';}
        }else if($field == 'kind'){
            if($q == '笔试') { $q = 'bishi';}
            else if($q == '面试') { $q = 'mianshi';}
        }else if($field == 'enable'){
            if($q == '上架') { $q = 1;}
            else if($q == '下架') { $q = 0;}
        }        
    
        $courses = Courses::where($field, 'like', '%'.$q.'%')->orderBy('created_at', 'desc')->simplePaginate(20)  ;
        $courses ->appends(['q' => $request['q']]);    
        $courses ->appends(['field' => $field]);

        $data = ['courses' => $courses, 'q' => $request['q'], 'field' => $field];
        return view('admin.courses.list', $data);
    }


    public function coursesadd(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'ablesky_category'=> 'required',
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|unique:courses|max:255',
                'enable' => 'required|boolean',
                'buytimes' => 'required|numeric|min:0',
                'hours' => 'required|numeric|min:0',
                'totalprice' => 'required|numeric|min:0',
                'discount_price' => 'required|numeric|min:0',
//                 'subname' => 'required',
                'subprice' => 'numeric|min:0',
                'discount_subprice' => 'numeric|min:0',
                'zongheprice' => 'numeric|min:0',
                'discount_zongheprice' => 'numeric|min:0',
                'nengliprice' => 'numeric|min:0',
                'discount_nengliprice' => 'numeric|min:0',  
                'cover' => 'required|image',
                'image' => 'required|image',
                'summary' => 'required',
                'description' => 'required',
                'hours_description' => 'required',
                'teacher' => 'required',
//                 'video' => 'required',
                'trialvideo' => 'required|url',   
//                 'sub_ablesky_category'=> 'required',
//                 'zonghe_ablesky_category'=> 'required',
//                 'nengli_ablesky_category'=> 'required_if:level,zhongxue',
                'has_sub' => 'required|boolean',
            ]);

            $input = $request->all();
            $courses = Courses::create($input);

            $imgs = ['cover', 'image'];
            foreach ($imgs as $c) {
                $file = array_get($input, $c);
                if ($file) {
                    $destinationPath = 'appfiles/courses';
                    if (!is_dir(base_path('public/' . $destinationPath))) {
                        mkdir(base_path('public/' . $destinationPath));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $courses->id.'-'.$c  . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName);
                    if ($upload_success) {
                        $courses[$c] = '/appfiles/courses/' . $fileName;
                    }
                }
            }
            $courses->save();                    

            return redirect('/admin/courses');
        }
        else {
            $data = ['courses' => NULL];
            return view('admin.courses.create_edit', $data);
        }
    }

    public function coursesedit(Request $request, $id)
    {        
        $courses = Courses::where('id', $id)->first();     
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'ablesky_category'=> 'required',
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|max:255|unique:courses,name,'.$courses->id,
                'enable' => 'required|boolean',
                'buytimes' => 'required|numeric|min:0',
                'hours' => 'required|numeric|min:0',
                'totalprice' => 'required|numeric|min:0',
                'discount_price' => 'required|numeric|min:0',
//                 'subname' => 'required',
                'subprice' => 'numeric|min:0',
                'discount_subprice' => 'numeric|min:0',
                'zongheprice' => 'numeric|min:0',
                'discount_zongheprice' => 'numeric|min:0',
                'nengliprice' => 'numeric|min:0',
                'discount_nengliprice' => 'numeric|min:0',           
//                 'cover' => 'required|image',
//                 'image' => 'required|image',
                'summary' => 'required',
                'description' => 'required',
                'hours_description' => 'required',
                'teacher' => 'required',
//                 'video' => 'required',
                'trialvideo' => 'required|url',     
//                 'sub_ablesky_category'=> 'required',
//                 'zonghe_ablesky_category'=> 'required',
//                 'nengli_ablesky_category'=> 'required_if:level,zhongxue',
                'has_sub' => 'required|boolean',
            ]);

            $input = $request->all();

            $courses->fill($input);
           
            $imgs = ['cover', 'image'];
            foreach ($imgs as $c) {
                $file = array_get($input, $c);
                if ($file) {
                    $destinationPath = 'appfiles/courses';
                    if (!is_dir(base_path('public/' . $destinationPath))) {
                        mkdir(base_path('public/' . $destinationPath));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $courses->id.'-'.$c  . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName);
                    if ($upload_success) {
                        $courses[$c] = '/appfiles/courses/' . $fileName;
                    }
                }
            }

            $courses->save();

            $referer = $input['referer'];
            return redirect(empty($referer)?'/admin/courses':$referer);
        }
        else {
            return view('admin.courses.create_edit', ['courses' => $courses]);
        }
    }
    
    public function delete(Request $request, $id)
    {
        Courses::where('id', $id)->delete();
        return redirect('/admin/courses');
    }
    
    public function lists(Request $request)
    {
//         $courses = Courses::where('enable', true)->orderBy('buytimes', 'desc') ->get();
        $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
        $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get() ;
        $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
        $groups = Groups::with('zx', 'xx', 'yr')->where('enable', true)->orderBy('rank') ->get();
        $data = ['groups' => $groups, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
        return view('front.courses_lists', $data);
    }
    
    public function detail(Request $request, $id)
    {
        if($request->has("e") && Auth::user() && Auth::user() -> isAdmin())
        {
            return redirect('/admin/courses/html_edit');
        }
        
        $course = Courses::where('id', $id)->first();
        
        //课程推荐，同级别课程中，随机推荐3个
        $courses_recommend = Courses::where('level', $course->level)->where('enable', true) ->where('id', '<>', $id) -> get()->all();
        shuffle($courses_recommend);
        $courses_recommend = array_slice($courses_recommend, 0, 3);
        
        //教材推荐，同级别教材中，随机推荐4个
        $books_recommend = Books::where('level', $course->level) -> get()->all();
        shuffle($books_recommend);
        $books_recommend = array_slice($books_recommend, 0, 4);
        
        return view('front.courses_detail', ['course' => $course, 'courses_recommend' => $courses_recommend, 'books_recommend'=>$books_recommend]);
    }
    
    public function html_edit(Request $request)
    {
        $dir = __DIR__.'/../../../../';
        $rightImage_path = $dir."resources/views/front/courses/rightImage.blade.php";      
        
        if ($request->isMethod('post')) {
            $rightImage = $request['rightImage'];
        
            file_put_contents($rightImage_path, $rightImage);
        
            return redirect('/courses/lists');
        
        }else{
            return view('admin.courses.html_edit', ['rightImage' => file_get_contents($rightImage_path) ]);
        }
    }
}