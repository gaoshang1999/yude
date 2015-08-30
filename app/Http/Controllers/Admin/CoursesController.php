<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function courses()
    {
        $data = ['courses' => Courses::orderBy('created_at', 'desc')->simplePaginate(20) ];
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
    
        $courses = Courses::where($field, 'like', '%'.$q.'%')->simplePaginate(20) ;
        $courses ->appends(['q' => $request['q']]);    

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
                'subname' => 'required',
                'subprice' => 'required|numeric|min:0',
                'zongheprice' => 'required|numeric|min:0',
                'nengliprice' => 'numeric|min:0',                
                'cover' => 'required|image',
                'image' => 'required|image',
                'summary' => 'required',
                'description' => 'required',
                'hours_description' => 'required',
                'teacher' => 'required',
                'video' => 'required',
                'trialvideo' => 'required|url',      
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
                'subname' => 'required',
                'subprice' => 'required|numeric|min:0',
                'zongheprice' => 'required|numeric|min:0',
                'nengliprice' => 'numeric|min:0',                
//                 'cover' => 'required|image',
//                 'image' => 'required|image',
                'summary' => 'required',
                'description' => 'required',
                'hours_description' => 'required',
                'teacher' => 'required',
                'video' => 'required',
                'trialvideo' => 'required|url',      
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
        $courses = Courses::get();
        $courses_1 = Courses::where('level', 'zhongxue') ->get();
        $courses_2 = Courses::where('level', 'xiaoxue') ->get() ;
        $courses_3 = Courses::where('level', 'youer') ->get();
        $data = ['courses' => $courses, 'courses_1' => $courses_1, 'courses_2' => $courses_2, 'courses_3' => $courses_3];
        return view('front.courses_lists', $data);
    }
    
    public function detail(Request $request, $id)
    {
        $courses = Courses::where('id', $id)->first();
        return view('front.courses_detail', ['v' => $courses]);
    }
}