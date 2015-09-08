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
        return $this->hasMany('App\Models\OrderItem');
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
    

}
