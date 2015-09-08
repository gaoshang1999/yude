<?php namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use SebastianBergmann\Environment\Console;
use App\Models\Order;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('phone', function($attribute, $value, $parameters) {
            return strlen($value) === 11;
        });

//         DB::listen(function($sql, $bindings, $time) {
//             Log::info  ($sql);
//         });
        
        Order::updated(function ($order) {            
            if ( $order -> isSuccessfullyPayed() ) {                
                $ablesky= app('Ablesky');
                $ablesky -> openCourses( $order );
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Ablesky', function ($app) {        

            $ablesky = new \App\Http\Controllers\Ablesky\Ablesky();
        
            return $ablesky;
        });
        
        $this->app->bind('AlipayWeb', function ($app) {
            $notify_url = $app->request->root() . '/alipay/notify';
            $return_url = $app->request->root() . '/alipay/return';

            //建立请求
            $alipayWeb = new \App\Providers\Alipay\AlipayWeb();
            $alipayWeb->setPartner(config('alipay.partner_id'))
                    ->setSellerId(config('alipay.seller_id'))
                    ->setKey(config('alipay.key'))
                    ->setSignType(config('alipay.sign_type'))
                    ->setNotifyUrl($notify_url)
                    ->setReturnUrl($return_url)
                    ->setExterInvokeIp($app->request->getClientIp());

            return $alipayWeb;
        });

        $this->app->bind('WxPay', function ($app) {
            $notify_url = $app->request->root() . '/wxpay/notify';
            $return_url = $app->request->root() . '/wxpay/return';

            //建立请求
            $wxpay = new \App\Providers\WxPay\WxPay();
            $wxpay->setAppid(config('wxpay.appid'))
                    ->setMchid(config('wxpay.mch_id'))
                    ->setKey(config('wxpay.key'))
                    ->setAppsecret(config('wxpay.appsecret'))
                    ->setNotifyUrl($notify_url)
                    ->setSpbillCreateIp($app->request->getClientIp());

            return $wxpay;
        });


        $this->app->bind('Yizhifu', function ($app) {
            $notify_url = $app->request->root() . '/yizhifu/notify';
            $return_url = $app->request->root() . '/yizhifu/return';

            //建立请求
            $yizhifu = new \App\Providers\Yizhifu\YzfPay();
            $yizhifu->setNotifyUrl($notify_url)->setReturnUrl($return_url)->setKey(config('yizhifu.key'));
            $yizhifu->v_mid = config('yizhifu.mid');

            return $yizhifu;
        });
    }
}
