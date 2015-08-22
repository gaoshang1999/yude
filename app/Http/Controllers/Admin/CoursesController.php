<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function courses()
    {
        $data = ['courses' => Courses::simplePaginate(20) ];
        return view('admin.courses.list', $data);
    }
    
    public function search(Request $request)
    {
        $input = $request['q'];
        $courses = Courses::where('name', 'like', '%'.$input.'%')->simplePaginate(20) ;
        $courses ->appends(['q' => $input]);
    
        $data = ['courses' => $courses, 'q' => $input];
        return view('admin.courses.list', $data);
    }

    public function coursesadd(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|unique:courses|max:255',
                'enable' => 'required|boolean',
                'buytimes' => 'required|numeric|min:0',
                'hours' => 'required|numeric|min:0',
                'totalprice' => 'required|numeric|min:0',
                'subname' => 'required',
                'subprice' => 'required|numeric|min:0',
                'zongheprice' => 'required|numeric|min:0',
                'nengliprice' => 'numeric|min:0',
                'cover' => 'required|image',
                'video' => 'required',
                'trialvideo' => 'required|url',
                'summary' => 'required',
                'pagetitle' => 'required',
                'pagekeyword' => 'required',
                'pagedescription' => 'required',
            ]);

            $input = $request->all();
            $courses = Courses::create($input);

            $file = array_get($input,'cover');

            $destinationPath = 'appfiles/courses';
            if (!is_dir(base_path('public/' . $destinationPath))) {
                mkdir(base_path('public/' . $destinationPath));
            }
            $extension = $file->getClientOriginalExtension();
            $fileName = $courses->id . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName);
            if ($upload_success) {
                $courses->cover = '/appfiles/courses/' . $fileName;
                $courses->save();
            }

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
                'level' => 'required|in:zhongxue,xiaoxue,youer',
                'kind' => 'required|in:bishi,mianshi',
                'name' => 'required|max:255|unique:courses,name,'.$courses->id,
                'enable' => 'required|boolean',
                'buytimes' => 'required|numeric|min:0',
                'hours' => 'required|numeric|min:0',
                'totalprice' => 'required|numeric|min:0',
                'subname' => 'required',
                'subprice' => 'required|numeric|min:0',
                'zongheprice' => 'required|numeric|min:0',
                'nengliprice' => 'numeric|min:0',
                'video' => 'required',
                'trialvideo' => 'required|url',
                'summary' => 'required',
                'pagetitle' => 'required',
                'pagekeyword' => 'required',
                'pagedescription' => 'required',
            ]);

            $input = $request->all();
            unset($input['_token']);
            foreach ($input as $key => $value) {
                $courses[$key] = $value;
            }
            $file = array_get($input,'cover');
            if ($file) {
                $destinationPath = 'appfiles/courses';
                if (!is_dir(base_path('public/' . $destinationPath))) {
                    mkdir(base_path('public/' . $destinationPath));
                }
                $extension = $file->getClientOriginalExtension();
                $fileName = $courses->id . '.' . $extension;
                $upload_success = $file->move($destinationPath, $fileName);
                if ($upload_success) {
                    $courses->cover = '/appfiles/courses/' . $fileName;
                }
            }

            $courses->save();

            return redirect('/admin/courses');
        }
        else {
            return view('admin.courses.create_edit', ['courses' => $courses]);
        }
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