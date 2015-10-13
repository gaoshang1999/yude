<?php namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function userlist()
    {
        $data = ['users' => User::simplePaginate(20) ];
        return view('admin.user.list', $data);
    }
    
    public function search(Request $request)
    {
        $q = $request['q'];
        $field = $request['field'];
        $users = User::where($field, 'like', '%'.$q.'%')->simplePaginate(20) ;
        $users ->appends(['q' => $q]);
        $users ->appends(['field' => $field]);
        
        $data = ['users' => $users, 'q' => $q, 'field' => $field];
        return view('admin.user.list', $data);
    }

    public function useradd(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required|unique:users,name|max:255',
                'userphone' => 'required|digits:11|unique:users,phone',
                'useremail' => 'required|email|unique:users,email',
                'userrole' => 'required',
                'password' => 'required|confirmed|min:6|max:20',
            ]);

            $newuser = new User();
            $newuser->name = $request->input('username');
            $newuser->phone = $request->input('userphone');
            $newuser->email = $request->input('useremail');
            $newuser->role = $request->input('userrole');
            $newuser->password = bcrypt($request->input('password'));

            $newuser->save();
            return redirect('/admin/user');
        }
        else {
            $data = ['user' => NULL];
            return view('admin.user.create_edit', $data);
        }
    }

    public function useredit(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required|max:255|unique:users,name,'.$user->id,
                'userphone' => 'required|digits:11|unique:users,phone,'.$user->id,
                'useremail' => 'required|email|unique:users,email,'.$user->id,
                'userrole' => 'required',
            ]);
            $user->name = $request->input('username');
            $user->phone = $request->input('userphone');
            $user->email = $request->input('useremail');
            $user->role = $request->input('userrole');

            $user->save();
            
            $referer = $request->input('referer');
            return redirect(empty($referer)?'/admin/user':$referer);
        }
        else {
            return view('admin.user.create_edit', ['user' => $user]);
        }
    }
    
    public function delete(Request $request, $id)
    {
        User::where('id', $id)->delete();
        return redirect('/admin/user');
    }
    
    public function reset(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
            
            $referer = $request->input('referer');
            return redirect(empty($referer)?'/admin/user':$referer);
        }else {
            return view('admin.user.reset', ['user' => $user]);
        }
        
    }
    
    public function home()
    {
        if(Auth::user()->isAdmin()){
            return redirect('/admin/user');
        }else{
            return redirect('/admin/orders');
        }
            
        
    }
}
