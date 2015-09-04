<?php 

namespace App\Http\Controllers\Pay;

use Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class YizhifuController extends Controller
{
    public function __construct()
    {
    }

    // 页面跳转同步通知页面路径。
    public function yzf_notify(Request $request)
    {
        $data = $request->all();
        Log::debug('Yizhifu yzf_notify get data : ', [
            'data' => json_encode($data)
        ]);
    }

    // 页面跳转同步通知页面路径。
    public function yzf_return(Request $request)
    {
        $querystr = iconv('GBK', 'UTF-8', urldecode($request->getQueryString()));
        // $var = explode('&', $querystr);
        // $data = array();
        // foreach ($var as $value) {
        //     $val = explode('=', $value);
        //     $data[$val[0]] = $val[1];
        // }
        $data = $request->all();
        $verifyok = app('Yizhifu')->verify_return($data);
        if ($verifyok) {
            Log::debug('Yizhifu return get data verification success.', [
                'data' => $querystr
            ]);
            return redirect('/order/step4');
        }
        else {
            Log::notice('Yizhifu return query data verification fail.', [
                'data' => $querystr
            ]);
            if (array_key_exists("v_oid", $data)) {
                $void = explode('-', $data['v_oid']);
                $orderno = $void[0] . $void[3] . intval($void[2]);
                $order = Order::where('orderno', $orderno)->first();
                return view('order.payfail', ['order'=>$order]);
            }
            else {
                return response('错误的返回值', 404);
            }
        }
    }

    public function test()
    {
        $order = (object)array(
            'id'=>3,
            'orderno' => '' . date('YmdHis') . (time()%1000),
            'subject' => '商品名称',
            'summary' => '商品说明',
            'showurl' => 'http://news.sina.com.cn',
            'totalfee'=> 0.01,
            'receiver'=> '收货人',
            'phone'=> '电话',
            'postcode'=> '邮编',
            'address'=> '地址',
        );

        $yzf = app('Yizhifu');
        $yzf->v_ymd = date('Ymd');
        $yzf->v_rcvname = str_pad(substr($order->orderno, -3), 5, '0', STR_PAD_LEFT);
        $yzf->v_rcvaddr = $order->address;
        $yzf->v_rcvtel = $order->phone;
        $yzf->v_rcvpost = $order->postcode;
        $yzf->v_amount = $order->totalfee;
        $yzf->v_ordername = $order->receiver;
        $yzf->v_oid = implode('-', [$yzf->v_ymd, $yzf->v_mid, $yzf->v_rcvname, date('His')]);

        return $yzf->buildRequestForm();
    }
}