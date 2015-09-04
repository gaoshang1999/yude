<?php
namespace App\Providers\Yizhifu;

use Illuminate\Http\Request;

class YzfPay
{
    private $params = array(
            'v_mid'     =>'',
            'v_oid'     =>'',
            'v_rcvname' =>'',
            'v_rcvaddr' =>'',
            'v_rcvtel'  =>'',
            'v_rcvpost' =>'',
            'v_amount'  =>'',
            'v_ymd'     =>'',
            'v_url'     =>'',
            'v_md5info' =>'',
            'v_ordername'   =>'',
            'v_orderstatus' =>'1',
            'v_moneytype'   =>'0',
        );

    private $gateway = "https://pay.yizhifubj.com/prs/user_payment.checkit";

    private $notify_url;
    private $return_url;
    private $key;

    public function __construct() {
    }

    public function __set($key, $val) {
        $this->params[$key] = $val;
        return $this;
    }

    public function __get($key) {
        return array_key_exists($key, $this->params) ? $this->params[$key] : null;
    }

    public function __isset($key) {
        return isset($this->params[$key]);
    }

    public function __unset($key)
    {
        if (array_key_exists($key, $this->params))
            unset($this->params[$key]);
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setNotifyUrl($url)
    {
        $this->notify_url = $url;
        return $this;
    }

    public function setReturnUrl($url)
    {
        $this->return_url = $url;
        $this->params['v_url'] = $url;
        return $this;
    }

    public function buildRequestForm ()
    {
        $sorter = ['v_moneytype', 'v_ymd', 'v_amount', 'v_rcvname', 'v_oid', 'v_mid', 'v_url'];
        $str = '';
        foreach ($sorter as $value) {
            $str = $str . $this->params[$value];
        }
        $sign = hash_hmac('md5', $str, $this->key);
        $this->params['v_md5info'] = $sign;

        $sHtml = "<form id='yzhifusubmit' name='alipaysubmit' action='".$this->gateway."' method='post'>";
        while (list ($key, $val) = each ($this->params)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<label>正在跳转...</label>";

        $sHtml = $sHtml."<script>document.forms['yzhifusubmit'].submit();</script>";

        return $sHtml;
    }

    public function verify_return($data)
    {
        $sorter = ['v_oid', 'v_pstatus', 'v_pstring', 'v_pmode'];
        $str = '';
        $ok = array_key_exists('v_md5info', $data);
        if ($ok) {
            foreach ($sorter as $val) {
                if (!array_key_exists($val, $data)) {
                    // echo $val . '------------not exists<br/>';
                    $ok = false;
                }
                else {
                    // $str = $str . iconv('UTF-8', 'GBK', $data[$val]);
                    $str = $str . $data[$val];
                }
            }
        }
        if ($ok) {
            $sign = hash_hmac('md5', $str, $this->key);
            $ok = $sign == $data['v_md5info'];
        }
        return $ok;
    }

}