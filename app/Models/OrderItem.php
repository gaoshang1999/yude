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

    protected $fillable = ['count', 'price', 'title', 'snapshot', 'order_id', 'type', 'is_opened'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    
    public function isCourse()
    {
        return $this->type == 'course';
    }
    
    public function isBook()
    {
        return $this->type == 'book' ;
    }
    
    public function course()
    {
        if($this->isCourse() && $this->snapshot)
        {
            $course = new Courses();            
            $c = json_decode($this->snapshot, true);
            $course->fill($c);
            return $course;
        }        
        return null;
    }
    
    public function book()
    {
        if($this->isBook() && $this->snapshot)
        {
            $book = new Books();
            $b = json_decode($this->snapshot, true);
            $book->fill($b);
            return $book;
        }
        return null;
    }
    
}
