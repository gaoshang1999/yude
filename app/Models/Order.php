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

    protected $fillable = ['orderno', 'totalprice', 'receiver', 'phone', 'postcode', 'address', 'paymode', 'paytime', 'payload'];

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }
}
