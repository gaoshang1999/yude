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
        $var = explode('&', $querystr);
        $truedata = array();
        foreach ($var as $value) {
            $val = explode('=', $value);
            $truedata[$val[0]] = $val[1];
        }
        $data = $request->all();
        $verifyok = app('Yizhifu')->verify_return($data);
        if ($verifyok) {
            Log::debug('Yizhifu return get data verification success.', [
                'data' => $querystr
            ]);

            $order = Order::where('orderno', $request->get('out_trade_no'))->first();
            $order->paytime = date('Y-m-d H:i:s');
            $order->paymode = 'Yizhifu';
            $order->payload = json_encode($truedata);
            $order->save();

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

}