<?php namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

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

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
    }
}
