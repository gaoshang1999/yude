<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Traits\ThrottlesLogins;
use App\Http\Controllers\Auth\Traits\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    
    protected $username = 'phone';

    protected $redirectPath = '/';

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($request)
    {
        $data = $request->all();
        $vcode = $request->session()->get('p'.$data['phone']);

        return Validator::make($data, [
            'name' => 'required|max:255|unique:users,name',
            'phone' => 'required|phone|size:11|unique:users,phone',
            'email' => 'required|email|max:255|unique:users,email',
            'phonecode' => 'required|regex:/' . $vcode['verifycode'] . '/',
            'password' => 'required|confirmed|min:6|max:20',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'user',
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function authenticated($request, $user)
    {
        $url = $request->input('url');
        
        if ($request->ajax() || $request->wantsJson()) {
            return json_encode(['success'=>true]);
        }
        
        if($url){
            return redirect($url);
        }
        if ($user->role === 'admin') {
            return redirect('/admin');
        }
        else {
            return redirect('/my');
        }
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // Auth::login($this->create($request->all()));
        $user = $this->create($request->all());
        $request->session()->forget('p' . $user->phone);

        if ($request->ajax() || $request->wantsJson()) {
            return json_encode(['success'=>true]);
        }
        
        return redirect($this->loginPath());
    }

    public function sendCode(Request $request)
    {
        $code = rand(100001, 999999);
        //短信接口机构代码 $jgid
        $jgid = '300';
        //短信接口用户名 $loginname
        $loginname = 'yude';
        //短信接口密码 $passwd
        $passwd = '123';
        //发送到的目标手机号码 $telphone，多个号码用半角分号分隔
        $telphone = $request->input('mobile');
        //短信内容 $message
        $message = urlencode("您的手机验证码为：" . $code);
        $gateway = "http://223.4.21.214:8180/service.asmx/SendMessageStr?Id={$jgid}&Name={$loginname}&Psw={$passwd}&Message={$message}&Phone={$telphone}&Timestamp=0";
        $result = file_get_contents($gateway);

        $request->session()->put('p'.$telphone, ['verifycode' => $code, 'deadline' => 60]);

        echo json_encode(['deadline'=>60]);
        // echo json_encode($request->session()->all());
    }
    
    public function postValidate(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        
        if($key == 'phone'){
            $validator = Validator::make( [$key => $value], [       
            'phone' => 'required|phone|size:11|unique:users,phone']);            

        }elseif ($key == 'name'){
            $validator = Validator::make( [$key => $value], [       
            'name' => 'required|max:255|unique:users,name']);
            
        }elseif ($key == 'email'){
            $validator = Validator::make( [$key => $value], [       
            'email' => 'required|email|max:255|unique:users,email']);
        }
        
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }else{
            echo json_encode(['success'=>true]);
        }
    }
}
