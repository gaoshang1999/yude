<?php
namespace  App\Http\Controllers\Ablesky;

use Laravel\Lumen\Routing\Controller;
use App\Models\AbleskyCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class AbleskyController extends Controller
{
    public function __construct()
    {
        $this->OrgId = config('ablesky.OrgId');
        $this->api_key = config('ablesky.api_key');
    }


    protected $OrgId ;
    protected $api_key ;
    
    //API-1:用户名称唯一性验证
    protected $api_1 = 'http://www.ablesky.com/newAccountChecker.do?action=checkIfUserNameDuplicated&username=%s';
    
    // 通过检查返回true，失败返回false
    public function checkIfUserNameDuplicated(Request $request, $username)
    {
        $url = sprintf($this->api_1, $username);
    
        $json = json_decode( file_get_contents($url) );
    
        if($json == null){
            return new JsonResponse(['success'=>false, 'message' => '用户名验证失败，请重试']);
        }else if($json->success && ! $json->isduplicated){
            return new JsonResponse(['success'=>true, 'message' => '']);
        }else{
            return new JsonResponse(['success'=>false, 'message' => '用户名已注册']);
        }
    }
    
    
    //API-2:邮箱唯一性验证
    protected $api_2 = 'http://www.ablesky.com/newAccountChecker.do?action=checkIfEmailDuplicated&email=%s';
    
    // 通过检查返回true，失败返回false
    public function checkIfEmailDuplicated(Request $request, $email)
    {
        $url = sprintf($this->api_2, $email);
    
        $json = json_decode( file_get_contents($url) );
    
        if($json == null){
            return new JsonResponse(['success'=>false, 'message' => '邮箱验证失败，请重试']);
        }else if($json->success && ! $json->isduplicated){
            return new JsonResponse(['success'=>true, 'message' => '']);
        }else{
            return new JsonResponse(['success'=>false, 'message' => '邮箱已注册']);
        }
    }
    
    
    //API-3:类目树的获取
    protected $api_3 = 'http://www.ablesky.com/organizationCategory.do?action=listOrgInteriorCategoryTree&organizationId=%s&optDate=%s&accessToken=%s';
      
    /*
     * 从能力天空调用课程目录获取接口，更新本地表中数据
     * 
     * 1.开放API-3的accesstoken的生成
            Java示例伪代码
            String orgInfoWithKey = organizationId + “|” + optDate + “|” + api_key;
            String accesstoken = md5.encode(orgInfoWithKey .getBytes(“UTF-8”));
		// organizationId为机构在AbleSky网站上的机构Id，有AbleSky提供
		// optDate为机构执行操作的当前时间，由机构客户端自行生成,用于确认url的生命周期,即默认10分钟有效
 	// api_key为机构私钥，详情请见字典描述

     */
    public function update_ablesky_category()
    {
        $optDate = time() * 1000;  //毫秒级时间
        $t = utf8_encode ($this->OrgId.'|'.$optDate .'|'.$this->api_key);       
       
        $accessToken = md5($t);
        
        $url = sprintf($this->api_3, $this->OrgId, $optDate, $accessToken);

        $json = json_decode( file_get_contents($url) );
        if($json != null && $json->success){
            $list = $json->result->list;
            AbleskyCategory::truncate();
            $this-> parse_tree($list);
            return new JsonResponse(['success'=>true, 'message' => '']);  
        }else{       
            return new JsonResponse(['success'=>false, 'message' => '更新失败']);  
        }
    }
    private $rank = 0;
    /**
     * 递归遍历，解析树形 json 串，解析完一个对象，就保存到数据库中。
     * json 串结构参考能力天空接口文档。
     * @param unknown $list
     */
    private function parse_tree($list)
    {
        foreach($list as $t){
            $item['id'] = $t->id;
            $item['categoryName'] = $t->categoryName;
            $item['parentId'] = $t->parentId;
            $item['categoryLevel'] = $t->categoryLevel;
            $item['rank'] = $this-> rank++ ;
            AbleskyCategory::create($item);
           
            $this-> parse_tree($t->children->list);
        }
    }
    
    public function list_ablesky_category(Request $request)
    {
        $selected = $request['selected'];
        $jstree_html = (new AbleskyCategory())-> jstree_html();
        return view('admin.courses.ablesky_category', ['jstree_html'=> $jstree_html , 'selected' => $selected]);
    } 
    
   
    //API-4:机构开通类目
    protected $api_4 = 'http://www.ablesky.com/organizationStudentManage.do?action=openCategory&orgId=%s&userName=%s&categoryId=%s&optDate=%s&accessToken=%s';
     
    
    /**
     *@param string $username  为用户名
     *@param string $categoryList ablesky类目id列表，各个类目id以“,”分隔
     * 
     * 2.开放API-4的accesstoken的生成
        Java示例伪代码
        String categoryInfoWithKey = organizationId + “|” + username + “|” + categoryList + “|” + optDate + ”|” + api_key;
        String accesstoken = md5.encode(categoryInfoWithKey .getBytes(“UTF-8”));
		// organizationId为机构在AbleSky网站上的机构Id，有AbleSky提供
		// username 为用户名
		// categoryList 为绑定类目Id的列表, categoryId	类目id列表，各个类目id以“,”分隔
		// optDate为机构执行操作的当前时间，由机构客户端自行生成,用于确认url的生命周期,即默认10分钟有效
		// api_key为机构私钥，详情请见字典描述
     */    
    public function openCategory($username, $categoryList)
    {
        $optDate = time() * 1000;  //毫秒级时间
        $t = utf8_encode ($this->OrgId.'|'.$username .'|'.$categoryList .'|'.$optDate .'|'.$this->api_key);
        $accessToken = md5($t);
        
        $url = sprintf($this->api_4, $this->OrgId, $username, $categoryList, $optDate, $accessToken);
        
        $json = json_decode( file_get_contents($url) );
        
        if($json != null && $json->success){
            return true;
        }else{
            return false;
        }
    }
    
    //API-5:机构学员在机构网站点击跳转到AS网站的指定接口
    protected $api_5 = 'http://passport.ablesky.com/oneStopRedirect.do?action=login&encodedUserInfo=%s&accessToken=%s&callbackUrl=%s&idpDomain=%s';
    
    /**
     * 
     * @param unknown  
     * @param unknown 
     * encodeUserInfo包含以下信息

        1．	orgUsername: 用户在机构网站上注册的用户名
        2．	emailAddress: 用户在机构网站上的注册邮箱
        3．	orgId: Ablesky为机构网站提供的唯一标识
        4．	timestamp: 标志链接生成时刻的长整型时间戳，即从1970年1月1日0时开始计算的毫秒数（链接的过期时间为10分钟）
        
        将以上这些信息按照如下方式进行拼接，并以“|”进行分隔，此后再进行base64编码即可。
        伪代码如下：
        userInfo  =  base64.encode(orgUsername + “|” + emailAddress + “|” + orgId + “|” + timestamp)
        
        base64编码之后，可能会出现特殊字符(如”=”)，所以还需要进行URL编码。
        伪代码如下：
        encodedUserInfo = URLEncoder.encode(userInfo, "UTF-8");

     * 
     * 开放API-5的accesstoken的生成
        Java示例伪代码
        String userInfoWithKey = username + “|” + email + “|” + organizationId+ “|” + optDate+ “|” + apiKey;
        String accesstoken = md5.encode(userInfoWithKey.getBytes(“UTF-8”));
		// organizationId为机构在AbleSky网站上的机构Id，有AbleSky提供
		// username 为用户名
		// email 为用户邮箱
		// optDate为机构执行操作的当前时间，由机构客户端自行生成,用于确认url的生命周期,即默认10分钟有效
		// api_key为机构私钥，详情请见字典描述

     * 
     */
    public function oneStopRedirect()
    {
        $optDate = time() * 1000;  //毫秒级时间

        $user = Auth::user(); 
        $orgUsername = $user->name;
        $emailAddress = $user->email;
        
        $userInfo = base64_encode($orgUsername.'|'. $emailAddress .'|'. $this->OrgId .'|'. $optDate);
        $encodedUserInfo = urlencode($userInfo);        

        $t = utf8_encode ($orgUsername.'|'. $emailAddress .'|'.$this->OrgId.'|'.$optDate .'|'.$this->api_key);
        $accessToken = md5($t);
        
    
        $callbackUrl = "/ablesky/redirectTo";
        $idpDomain ="http://localhost";
        
        $url = sprintf($this->api_5, $encodedUserInfo, $accessToken, $callbackUrl, $idpDomain);
        
        return redirect($url);    
    }
    
    public function redirectTo()
    {
        return redirect("http://www.ablesky.com");
    }
}

?>