<?php 

namespace App\Http\Controllers\Alipay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlipayController extends Controller
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
    public function ali_return(Request $request)
    {
        // 验证请求。
        if (! app('AlipayWeb')->verify()) {
            Log::notice('Alipay return query data verification fail.', [
                'data' => $request->getQueryString()
            ]);
            return view('alipay.fail');
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify get data verification success.', [
                    'out_trade_no' => $request->input('out_trade_no'),
                    'trade_no' => $request->input('trade_no')
                ]);
                break;
        }

        return redirect('/order/step4');
    }

    // 服务器异步通知页面路径。
    public function ali_notify(Request $request)
    {
        // 验证请求。
        if (! app('AlipayWeb')->verify()) {
            Log::notice('Alipay notify post data verification fail.', [
                'data' => $request->getContent()
            ]);
            return 'fail';
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify post data verification success.', [
                    'out_trade_no' => $request->input('out_trade_no'),
                    'trade_no' => $request->input('trade_no')
                ]);
                break;
        }

        return 'success';
    }

    //
    public function ali_test(Request $request)
    {
        $order = array(
            'orderNo' => ''.time(), 
            'subject' => '商品名称',
            'summary' => '商品说明',
            'showurl' => 'http://news.sina.com.cn',
            'totalfee'=> 0.01
        );

        $alipayWeb = app('AlipayWeb');

        $alipayWeb->setOutTradeNo($order['orderNo'])
                ->setTotalFee($order['totalfee'])
                ->setSubject($order['subject'])
                ->setBody($order['summary'])
                ->setShowUrl($order['showurl']);

        return redirect($alipayWeb->getPayLink());
    }
}