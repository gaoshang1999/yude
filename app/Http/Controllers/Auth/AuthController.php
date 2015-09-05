<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Traits\ThrottlesLogins;
use App\Http\Controllers\Auth\Traits\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Ablesky\AbleskyController;
use Illuminate\Http\JsonResponse;
use Log;
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
            'phonecode' => 'required|size:6|regex:/^' . $vcode['verifycode'] . '$/',
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
            return new JsonResponse(['success'=>true]);
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
            return new JsonResponse(['success'=>true]);
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

    public function phoneCheck(Request $request, $phone)
    {    
        $validator = Validator::make( ['phone' => $phone], [
            'phone' => 'required|phone|size:11|unique:users,phone']);   
    
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '手机号错误或已注册']);
        }else{
            return new JsonResponse(['success'=>true]);
        }
    }
    
    public function ajaxPostRegister(Request $request)
    {
        $data = $request->all();
        $vcode = $request->session()->get('p'.$data['phone']);
        
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users,name',
        ]);        
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '用户名错误或已注册']);
        }
        
        $validator = Validator::make($data, [
            'phone' => 'required|phone|size:11|unique:users,phone',
        ]);        
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '手机号错误或已注册']);
        }
        
        $validator = Validator::make($data, [
            'email' => 'required|email|max:255|unique:users,email',
        ]);        
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '邮箱错误或已注册']);
        } 
               
        $validator = Validator::make($data, [
            'phonecode' => 'required|size:6|regex:/^' . $vcode['verifycode'] . '$/',
        ]);    
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '验证码认证失败']);
        }     

        $validator = Validator::make($data, [
            'password' => 'required|confirmed|min:6|max:20',
        ]);
        if ($validator->fails()) {
            return new JsonResponse(['success'=>false, 'message' => '密码格式无效']);
        }

        $output = $this->ableskyUserRegister($request->all());

        if(!$output || $output->result->code != 0){
            return new JsonResponse(['success'=>false, 'message' => '调用远程注册服务失败']); 
        }
        $user = $this->create($request->all());
        $request->session()->forget('p' . $user->phone);
    
        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse(['success'=>true]);
        }
    
        return redirect($this->loginPath());
    }
    

    
    private $ablesky_user_api =  'http://www.ablesky.com/userAPI.do';
    
    /*
     * 1.	注册请求
            request内容（POST）
            data: {
            		type: 'register',									// 操作类型
            		orgId: 941,										// 网校Id
            		username: 'the_username' ,						// 用户名
            		password: 'the_password' , 						// 明文密码
            		email: 'the_email' 								// 邮箱
            }
            timestamp: 1387187648910							// 时间戳
            accessToken: 6c1975e41990de490d9f594ff351fbbe  	// 加密令牌
            
            response内容
            {
              	result: {
                	code: 0,
               		message: '请求成功'
            		},
            timestamp: 1387187648910,							// 时间戳
            accessToken: '38f56bff4abe4b7388ed0d9c38e556c9 '	// 加密令牌
            }        
      ----------------------------------------------------------------------------------------------------  
            四.	数据加加密和验证的方法
         String accessToken = DigestUtils.md5Hex(dataJson + “|” + timestamp + “|” + apiKey);
    
              即accessToken是由表征业务参数的json字符串与时间戳和apiKey连接并md5编码后产生的字符串。连接符请使用”|”。     
     */
     public function ableskyUserRegister($user)
     {
         $orgId = config('ablesky.OrgId');
         $data = json_encode(['type'=>'register', 'orgId'=> $orgId, 'username' => $user['name'] , 
             'password' => $user['password'], 'email' => $user['email'] ]);
         $timestamp = time() * 1000;  //毫秒级时间
         
         $accessToken = md5($data . '|' .$timestamp . '|' . $orgId);
         
         $post_data = ['data' => $data,'timestamp' => $timestamp, 'accessToken'=>$accessToken ];
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $this->ablesky_user_api);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         // post数据
         curl_setopt($ch, CURLOPT_POST, 1);
         // post的变量
         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
         $output = curl_exec($ch);
         curl_close($ch);        
         Log::info  ('AuthController-ableskyUserRegister: '.$data);
         Log::info  ('AuthController-ableskyUserRegister: '.http_build_query($post_data));
         Log::info  ('AuthController-ableskyUserRegister: '.$output);
        //打印获得的数据
         return json_decode($output);
     }
     
     public function resetPassword(Request $request)
     {
         $data = $request->all();
         $vcode = $request->session()->get('p'.$data['phone']);
         
         $validator = Validator::make($data, [
             'phonecode' => 'required|size:6|regex:/^' . $vcode['verifycode'] . '$/',
         ]);
         if ($validator->fails()) {
             return new JsonResponse(['success'=>false, 'message' => '验证码认证失败']);
         }
         
         $validator = Validator::make($data, [
             'password' => 'required|confirmed|min:6|max:20',
         ]);
         if ($validator->fails()) {
             return new JsonResponse(['success'=>false, 'message' => '密码格式无效']);
         }
         
         $user = Auth::user();
         $user->password = bcrypt($request->input('password'));
         $user->save();
         $request->session()->forget('p' . $user->phone);
         
         if ($request->ajax() || $request->wantsJson()) {
             return new JsonResponse(['success'=>true]);
         }
     }
}
