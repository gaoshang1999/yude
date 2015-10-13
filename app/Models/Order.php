<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = ['orderno', 'totalprice', 'receiver', 'phone', 'postcode', 'address',
               'paymode', 'paytime', 'payload', 'user_id', 'open_way'];

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    /**
     * 是否成功完成支付
     */
    public function isSuccessfullyPayed()
    {
        return $this->paytime != null;
    }
    
    public function isManualOpened()
    {
        return $this->open_way == 'manual';
    }

    public function isAutoOpened()
    {
        return $this->open_way == 'auto';
    }
    
    public function open_wayDesc()
    {
        if($this->isManualOpened()){
            return "手工";
        }else if($this->isAutoOpened()){
            return "自动";
        }else{
            return "未开通";
        }
    }
    
    public function statusDesc()
    {
        if($this->status == 0){
            return "未处理";
        }else{
            return "已处理";
        }
    }  

    public function paymodeDesc()
    {        
        switch ($this->paymode)
        {
            case "online":
                return "在线支付";
            case "alipay":
                return "支付宝";
            case "wxpay":
                 return "微信";
            case "bank":
                return "网银";               
            case "offline":
                return "银行汇款";  
        }
    }
       
    public function isPayedOffline()
    {
        return $this->paymode == "offline";
    }
}
