<?php 

namespace App\Http\Controllers\Pay;

use Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Endroid\QrCode\QrCode;

class WxPayController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    // 页面跳转同步通知页面路径。
    public function wx_notify(Request $request)
    {
        $xml = $request->getContent();
        $ret = app('WxPay')->notify($xml);
        if ($ret['return_code'] == 'SUCCESS') {
            $order = Order::where('orderno', $ret['out_trade_no'])->first();
            if ($order && (!isset($order->paytime) || $order->paytime == NULL)) {
                Log::debug('WxPay notify get data verification success.', [
                    'out_trade_no' => $ret['out_trade_no'],
                    'transaction_id' => $ret['transaction_id']
                ]);
                $order->paytime = date('Y-m-d H:i:s');
                $order->paymode = 'wxpay';
                $order->payload = json_encode($ret);
                $order->save();
            }
            else {
                Log::notice('WxPay notify query data verification fail.', [
                    'data' => json_encode($ret)
                ]);
            }
        }
    }

    //
    public function payqrcode($orderno, $totalprice)
    {
        $wxpay = app('WxPay');
        $url = $wxpay->getPayUrl($orderno, $totalprice, '育德园师课程购买');
        // var_dump($url);
        if (array_key_exists('code_url', $url)) {
            $qrCode = new QrCode();
            $content = $qrCode->setSize(300)->setText(urldecode($url['code_url']))
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->get();
            return response($content, 200)->header('Content-Type', "image/png");
        }
        else {
            return 'error';
        }
    }

    public function pay($orderno, Request $request)
    {
        $order = Order::where('orderno', $orderno)->first();
        return view("order.wxpay", ['order'=>$order]);
    }

    public function checkorder($orderno)
    {
        $order = Order::where('orderno', $orderno)->first();
        return isset($order->paytime) && $order->paytime != null ? 'ok' : '';
    }
}