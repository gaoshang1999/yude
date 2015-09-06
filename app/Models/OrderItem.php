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

    protected $fillable = ['count', 'price', 'title', 'snapshot', 'order_id', 'type'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    
    public function isCourse()
    {
        if($this->type == 'course')
        {
            return true;
        }
        return false;
    }
    
    public function isBook()
    {
        if($this->type == 'book')
        {
            return true;
        }
        return false;
    }
    
    public function course()
    {
        if($this->isCourse())
        {
            $c = json_decode($this->snapshot);
            return $c;
        }        
        return null;
    }
    
    public function book()
    {
        if($this->isBook())
        {
            $b = json_decode($this->snapshot);
            return $b;
        }
        return null;
    }
    
}
