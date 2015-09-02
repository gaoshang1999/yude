<?php
namespace  App\Http\Controllers\Ablesky;

use Laravel\Lumen\Routing\Controller;
use App\Models\AbleskyCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AbleskyController extends Controller
{
    public function __construct()
    {
    }


    public static $OrgId=907 ;
    public static $api_key = '323f9b0894a94936bf142864459ddac4' ;
    
    //API-1:用户名称唯一性验证
    protected $api_1 = 'http://www.ablesky.com/newAccountChecker.do?action=checkIfUserNameDuplicated&username=%s';
    
    //API-2:邮箱唯一性验证
    protected $api_2 = 'http://www.ablesky.com/newAccountChecker.do?action=checkIfEmailDuplicated&email=%s';
    
    //API-3:类目树的获取
    protected $api_3 = 'http://www.ablesky.com/organizationCategory.do?action=listOrgInteriorCategoryTree&organizationId=%s&optDate=%s&accessToken=%s';
    
    //API-4:机构开通类目
    protected $api_4 = 'http://www.ablesky.com/organizationStudentManage.do?action=openCategory&orgId=XXX&userName=XXX&categoryId=XXX&optDate=1343268217903&accessToken=XXX';
    
    //API-5:机构学员在机构网站点击跳转到AS网站的指定接口
    protected $api_5 = 'http://passport.ablesky.com/oneStopRedirect.do?action=login&encodedUserInfo=YTE3X29yZ3xhMTdfb3JnQGdtYWlsLmNvbXwzNTh8MTMzNTk1MjgwMTc0NA%3D%3D&accessToken=16bd1ee007229479195d3e6739fd8269&callbackUrl=http%3A%2F%2Fwww.alpha.ablesky.com%2FstudyCenterRedirect.do%3Faction%3DloadStudyCenterPage&idpDomain=edu.evebake.com';
    
    
    /*
     * 从能力天空调用课程目录获取接口，更新本地表中数据
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
    
    // 通过检查返回1，失败返回0
    public function checkIfUserNameDuplicated(Request $request, $username)
    {     
        $url = sprintf($this->api_1, $username);
        
        $json = json_decode( file_get_contents($url) );

        if($json == null){
            return new JsonResponse(['success'=>false, 'message' => '用户名验证失败，请重试']);
        }else if($json->success && ! $json->isduplicated){
            return new JsonResponse(['success'=>true, 'message' => '']);  
        }else{
        return new JsonResponsecode(['success'=>false, 'message' => '用户名已注册']);
        }
    }
    
    // 通过检查返回1，失败返回0
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
}

?>