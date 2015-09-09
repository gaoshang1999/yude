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
    
    public function open_way_desc()
    {
        if($this->isManualOpened()){
            return "手工";
        }else if($this->isAutoOpened()){
            return "自动";
        }else{
            return "未开通";
        }
    }
}
