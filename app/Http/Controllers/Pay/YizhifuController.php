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

        $verifyok = app('Yizhifu')->verify_notify($data);
        if (!$verifyok) {
            echo("error<br>");
        }
        else {
            echo("sent");
            $querystr = iconv('GBK', 'UTF-8', urldecode($request->getQueryString()));
            $var = explode('&', $querystr);
            $truedata = array();
            foreach ($var as $value) {
                $val = explode('=', $value);
                $truedata[$val[0]] = $val[1];
            }
            //接收返回的参数
            $v_oid      = $truedata['v_oid'];//订单编号组
            $v_pmode    = $truedata['v_pmode'];//支付方式组
            $v_pstatus  = $truedata['v_pstatus'];//支付状态组
            $v_pstring  = $truedata['v_pstring'];//支付结果说明
            $v_amount   = $truedata['v_amount'];//订单支付金额
            $v_count    = $truedata['v_count'];//订单个数
            $v_moneytype= $truedata['v_moneytype'];//订单支付币种
            $v_mac      = $truedata['v_mac'];//数字指纹（v_mac）
            $v_md5money = $truedata['v_md5money'];//数字指纹（v_md5money）
            $v_sign     = $truedata['v_sign'];//验证商城数据签名（v_sign）
            //拆分参数
            $sp = '|_|';
            $a_oid      = explode($sp, $v_oid);
            $a_pmode    = explode($sp, $v_pmode);
            $a_pstatus  = explode($sp, $v_pstatus);
            $a_pstring  = explode($sp, $v_pstring);
            $a_amount   = explode($sp, $v_amount);
            $a_moneytype= explode($sp, $v_moneytype);

            //更改数据库状态
            //通过for循环查看该笔通知有几笔订单,并对于更改数据库状态
            for($i=0; $i < $v_count; $i++) {
                $void = explode('-', $a_oid[$i]);
                $orderno = $void[0] . $void[3] . intval($void[2]);
                $order = Order::whereNull('paytime')->where('orderno', $orderno)->first();
                if ($order != null) {
                    $order->paytime = date('Y-m-d H:i:s');
                    $order->paymode = 'Yizhifu';
                    $order->payload = json_encode({'v_oid':$a_oid[$i], 'v_pmode': $a_pmode[$i], 'v_pstatus': $a_pstatus[$i], 'v_pstring': $a_pstring[$i], 
                        'v_amount': $a_amount[$i], 'v_amount': $a_amount[$i], 'v_moneytype': $a_moneytype[$i]});
                    $order->save();
                }
            }
        }
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

            $void = explode('-', $data['v_oid']);
            $orderno = $void[0] . $void[3] . intval($void[2]);
            $order = Order::whereNull('paytime')->where('orderno', $orderno)->first();
            if ($order != null) {
                $order->paytime = date('Y-m-d H:i:s');
                $order->paymode = 'Yizhifu';
                $order->payload = json_encode($truedata);
                $order->save();
            }

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