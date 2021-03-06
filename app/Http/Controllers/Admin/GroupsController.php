<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Courses;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function groups()
    {
        $data = ['groups' => Groups::with('zx', 'xx', 'yr')->orderBy('created_at', 'desc')->paginate(20) ];
        return view('admin.groups.list', $data);
    }
    
    public function search(Request $request)
    {
        $q = $request['q'];
        $field = $request['field'];       

        if($field == 'zx_course' || $field == 'xx_course' || $field == 'yr_course'){
            $courses = Courses::where('name', 'like', '%'.$q.'%')->first();            
            $q = $courses->id;
        }
   
        $groups = Groups::where($field, 'like', '%'.$q.'%')->paginate(20) ;
        $groups ->appends(['q' => $request['q']]);
        $groups ->appends(['field' => $field]);
        
        $data = ['groups' => $groups, 'q' => $request['q'], 'field' => $field];
        return view('admin.groups.list', $data);
    }

    public function groupsadd(Request $request)
    { 
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|unique:groups|max:255',
                'rank' => 'required|integer|min:0',
                'zx_course' => 'required|integer',
                'xx_course' => 'required|integer',
                'yr_course' => 'required|integer',  
                'enable' => 'required|boolean',
            ]);

            $input = $request->all();
            $groups = Groups::create($input);
                        
            $groups->save(); 
       
            return redirect('/admin/groups');
        }
        else {
            $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
            $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get() ;
            $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
            $data = ['groups' => NULL, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
            
            return view('admin.groups.create_edit', $data);
        }
    }

    public function groupsedit(Request $request, $id)
    {
        $groups = Groups::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:255|unique:groups,name,'.$groups->id,
                'rank' => 'required|integer|min:0',
                'zx_course' => 'required|integer',
                'xx_course' => 'required|integer',
                'yr_course' => 'required|integer',
                'enable' => 'required|boolean',
            ]);

            $input = $request->all();
            $groups->fill($input);
            
            $groups->save();
            
            $referer = $input['referer'];
            return redirect(empty($referer)?'/admin/groups':$referer);
        }
        else {
            $courses_zx = Courses::where('level', 'zhongxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
            $courses_xx = Courses::where('level', 'xiaoxue')->where('enable', true)->orderBy('buytimes', 'desc') ->get() ;
            $courses_yr = Courses::where('level', 'youer')->where('enable', true)->orderBy('buytimes', 'desc') ->get();
            $data = ['groups' => $groups, 'courses_zx' => $courses_zx, 'courses_xx' => $courses_xx, 'courses_yr' => $courses_yr];
           
            return view('admin.groups.create_edit', $data);
        }
    }
    
    public function delete(Request $request, $id)
    {
        Groups::where('id', $id)->delete();
        return redirect('/admin/groups');
    }
    
    public function lists(Request $request)
    {       
        $groups_1 = Groups::where('level', 'zhongxue')->where('enable', true) ->get();    
        $groups_2 = Groups::where('level', 'xiaoxue')->where('enable', true) ->get() ;        
        $groups_3 = Groups::where('level', 'youer')->where('enable', true) ->get();        
        $data = ['groups_1' => $groups_1, 'groups_2' => $groups_2, 'groups_3' => $groups_3];
        return view('front.groups_lists', $data);
    }
    
    public function detail(Request $request, $id)
    {
        $groups = Groups::where('id', $id)->first();
        return view('front.groups_detail', ['v' => $groups]);
    }
}