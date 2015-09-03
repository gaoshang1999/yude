<?php
namespace App\Providers\WxPay;

use Illuminate\Http\Request;

class WxPay
{
    //=======【基本信息设置】=====================================
    //
    /**
     * TODO: 修改这里配置为您自己申请的商户信息
     * 微信公众号信息配置
     * 
     * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
     * 
     * MCHID：商户号（必须配置，开户邮件中可查看）
     * 
     * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
     * 
     * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
     * @var string
     */
    private $appid;
    private $mch_id;
    private $key;
    private $appsecret;
    
    //=======【证书路径设置】=====================================
    /**
     * TODO：设置商户证书路径
     * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
     * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
     * @var path
     */
    private $apiclient_cert;
    private $apiclient_key;

    private $spbill_create_ip;

    /**
    *  回调 URL
    **/
    private $notify_url;

    public function __construct()
    {
        $this->apiclient_cert = getcwd() . DIRECTORY_SEPARATOR . 'apiclient_cert.pem';
        $this->apiclient_key = getcwd() . DIRECTORY_SEPARATOR . 'apiclient_key.pem';
    }

    public function setAppid($appid)
    {
        $this->appid = $appid;
        return $this;
    }

    public function setMchid($mchid)
    {
        $this->mch_id = $mchid;
        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setAppsecret($appsecret)
    {
        $this->appsecret = $appsecret;
        return $this;
    }

    public function setSpbillCreateIp($ip) {
        $this->spbill_create_ip = $ip;
        return $this;
    }

    public function setNotifyUrl($url)
    {
        $this->notify_url = $url;
        return $this;
    }

    public function getPayUrl($orderno, $totalfee, $body)
    {
        $input = new WxPayUnifiedOrder();
        $input->body = $body;
        $input->out_trade_no = $orderno;
        $input->total_fee = $totalfee * 100;
        $input->time_start = date("YmdHis");
        $input->time_expire = (date("YmdHis", time() + 24 * 60 * 60 * 2)); // 两天
        $input->trade_type = "NATIVE";
        $input->product_id = $orderno;

        return $this->unifiedOrder($input, 30);
    }

    /**
     * 
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function unifiedOrder($inputObj, $timeOut = 6)
    {
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        //检测必填参数
        if(!isset($inputObj->out_trade_no)) {
            throw new \Exception("缺少统一支付接口必填参数 out_trade_no！");
        }else if(!isset($inputObj->body)) {
            throw new \Exception("缺少统一支付接口必填参数 body！");
        }else if(!isset($inputObj->total_fee)) {
            throw new \Exception("缺少统一支付接口必填参数 total_fee！");
        }else if(!isset($inputObj->trade_type)) {
            throw new \Exception("缺少统一支付接口必填参数 trade_type！");
        }
        
        //关联参数
        if($inputObj->trade_type == "JSAPI" && !isset($inputObj->openid)){
            throw new Exception("统一支付接口中，缺少必填参数 openid！trade_type为 JSAPI 时，openid 为必填参数！");
        }
        if($inputObj->trade_type == "NATIVE" && !isset($inputObj->product_id)){
            throw new Exception("统一支付接口中，缺少必填参数 product_id！trade_type为 NATIVE 时，product_id 为必填参数！");
        }
        
        //异步通知url未设置，则使用配置文件中的url
        if(!isset($inputObj->notify_url)) {
            $inputObj->notify_url = $this->notify_url;//异步通知url
        }
        
        $inputObj->appid = $this->appid;  //公众账号ID
        $inputObj->mch_id = $this->mch_id;  //商户号
        $inputObj->spbill_create_ip = $this->spbill_create_ip;//终端ip
        $inputObj->nonce_str = $this->getNonceStr();          //随机字符串
        
        //签名
        $inputObj->sign = $inputObj->MakeSign($this->key);

        $xml = $inputObj->ToXml();
        
        $response = $this->postXmlCurl($xml, $url, false, $timeOut);

        $result = WxPayResults::Init($response);
        
        return $result;
    }

    public function notify($xml)
    {
        $ret = ['return_code'=>'FAIL', 'return_msg'=>''];
        //如果返回成功则验证签名
        try {
            $result = WxPayResults::Init($xml);
            $ret = $result;
            if ($ret['return_code'] == 'SUCCESS' && array_key_exists('result_code', $ret) && $ret['result_code'] == 'SUCCESS' && array_key_exists('transaction_id', $ret) && trim($ret['transaction_id']) != '') {
                $oquery = new WxPayOrderQuery();
                $oquery->transaction_id = trim($ret['transaction_id']);
                $queryResult = $this->orderQuery($oquery);
                if (array_key_exists('return_code', $queryResult) && array_key_exists('result_code', $queryResult) && $queryResult['return_code'] == 'SUCCESS' && $queryResult['result_code'] == 'SUCCESS') {
                }
                else {
                    $ret['return_code'] = 'FAIL';
                    $ret['return_msg'] = '订单查询失败';
                }
            }
            else {
                $ret['return_code'] = 'FAIL';
                $ret['return_msg'] = '回调数据异常';
            }
        } catch (WxPayException $e){
            $ret['return_msg'] = $e->errorMessage();
        }

        return $ret;
    }

    /**
     * 
     * 查询订单，WxPayOrderQuery中out_trade_no、transaction_id至少填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayOrderQuery $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function orderQuery($inputObj, $timeOut = 30)
    {
        $url = "https://api.mch.weixin.qq.com/pay/orderquery";
        //检测必填参数
        if(!isset($inputObj->out_trade_no) && !isset($inputObj->transaction_id)) {
            throw new WxPayException("订单查询接口中，out_trade_no、transaction_id至少填一个！");
        }
        $inputObj->appid = $this->appid;  //公众账号ID
        $inputObj->mch_id = $this->mch_id;  //商户号
        $inputObj->nonce_str = $this->getNonceStr();  //随机字符串
        
        //签名
        $inputObj->sign = $inputObj->MakeSign($this->key);
        
        $xml = $inputObj->ToXml();
        
        $response = $this->postXmlCurl($xml, $url, false, $timeOut);

        $result = WxPayResults::Init($response);
        
        return $result;
    }
    
    /**
     * 
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public function getNonceStr($length = 32) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }
    
    /**
     * 以post方式提交xml到对应的接口url
     * 
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {       
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        
        //如果有配置代理这里就设置代理
        // if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
        //     && WxPayConfig::CURL_PROXY_PORT != 0){
        //     curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
        //     curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        // }
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $this->apiclient_cert);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $this->apiclient_key);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else { 
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }
    
    /**
     * 获取毫秒级别的时间戳
     */
    private function getMillisecond()
    {
        //获取毫秒的时间戳
        $time = explode ( " ", microtime () );
        $time = $time[1] . ($time[0] * 1000);
        $time2 = explode( ".", $time );
        $time = $time2[0];
        return $time;
    }
}

class WxPayDataBase
{
    private $values = array();

    public function __get($key) {
        return array_key_exists($key, $this->values) ? $this->values[$key] : null;
    }

    public function __set($key, $val) {
        $this->values[$key] = $val;
    }

    public function __isset($key) {
        return isset($this->values[$key]);
    }

    public function __unset($key)
    {
        if (array_key_exists($key, $this->values))
            unset($this->values[$key]);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    public function ToXml()
    {
        if(!is_array($this->values) 
            || count($this->values) <= 0)
        {
            throw new WxPayException("数组数据异常！");
        }
        
        $xml = "<xml>";
        foreach ($this->values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }
    
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public function FromXml($xml)
    {   
        if(!$xml){
            throw new WxPayException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $this->values;
    }
    
    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    
    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function MakeSign($key)
    {
        //签名步骤一：按字典序排序参数
        ksort($this->values);
        $string = $this->ToUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$key;

        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 获取设置的值
     */
    public function GetValues()
    {
        return $this->values;
    }
}

/**
 * 
 * 接口调用结果类
 * @author widyhu
 *
 */
class WxPayResults extends WxPayDataBase
{
    /**
     * 
     * 检测签名
     */
    public function CheckSign()
    {
        //fix异常
        if(!$this->IsSignSet()){
            throw new Exception("签名错误！");
        }
        
        $sign = $this->MakeSign();
        if($this->GetSign() == $sign){
            return true;
        }
        throw new Exception("签名错误！");
    }
    
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function Init($xml)
    {   
        $obj = new self();
        $obj->FromXml($xml);
        //fix bug 2015-06-29
        if($obj->values['return_code'] != 'SUCCESS'){
             return $obj->GetValues();
        }
        $obj->CheckSign();
        return $obj->GetValues();
    }
}

/**
 * 
 * 统一下单输入对象
 * @author widyhu
 *
 */
class WxPayUnifiedOrder extends WxPayDataBase
{
}

/**
 * 
 * 订单查询输入对象
 * @author widyhu
 *
 */
class WxPayOrderQuery extends WxPayDataBase
{
}