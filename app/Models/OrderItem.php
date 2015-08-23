<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orderitems';

    protected $fillable = ['count', 'price', 'title', 'snapshot', 'order_id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
