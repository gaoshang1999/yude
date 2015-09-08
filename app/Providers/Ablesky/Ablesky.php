<?php
namespace  App\Providers\Ablesky;

use App\Models\Order;
use App\Models\OrderItem;

class Ablesky
{
    public function __construct()
    {
        $this->OrgId = config('ablesky.OrgId');
        $this->api_key = config('ablesky.api_key');
    }

    protected $OrgId ;
    protected $api_key ;    

   
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
    

    /**
     * 支付成功后，调用该方法，调能力天空接口，开通订单中的课程
     * @param Order $order
     */    
    public function openCourses($order, $open_way ="auto")
    {
        $ablesky_category_ids = []; //课程id, 用于开通课程
        $item_ids = [];  //oderitem is, 用于开通成功后更新状态
        $items = $order->orderItems();
        foreach ($items as $k => $v)
        {
            if($v->isCourse()){
                $ablesky_category_ids []= $v->course()-> getAbleskyCategoryIds($v->count) ;
                $item_id []= $v->id ;
            }
        }
        $user = $order->user()->first();    
//         dump($user);

        $retcode = $this->openCategory($user->name, join(",", $ablesky_category_ids));
    
        if($retcode)
        {
            OrderItem::whereIn('id', $item_ids) ->update(['is_opened' => true]);
            Order::where('id', $order->id)->first() ->update(['open_way' => $open_way]);;
            return true;
        }
        
        return false;
    }
}

?>